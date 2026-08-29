#!/usr/bin/env bash
#
# Checks the built theme against the WordPress.org submission requirements that
# the Theme Check plugin does not cover -- the ones that fail at upload time
# rather than at review time:
#
#   - mixed line endings, which break the directory's SVN import
#   - hidden files, VCS directories and other prohibited files
#   - the four files a block theme must contain
#   - style.css Version matching readme.txt Stable tag
#   - screenshot.png present, at most 1200x900, and in 4:3
#   - a theme slug nobody else has already published
#   - placeholder metadata left unedited
#
# Runs against the built zip, which is what gets uploaded.
#
# Reference: https://make.wordpress.org/themes/handbook/review/required/
#
# Usage: bash tools/preflight.sh
set -euo pipefail

THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "${THEME_DIR}"

RED=$'\033[31m'; GREEN=$'\033[32m'; YELLOW=$'\033[33m'; DIM=$'\033[2m'; RESET=$'\033[0m'
FAILED=0
WARNED=0

pass() { printf '  %sok  %s %s\n' "${GREEN}" "${RESET}" "$1"; }
fail() { printf '  %sFAIL%s %s\n' "${RED}" "${RESET}" "$1"; FAILED=$((FAILED + 1)); }
warn() { printf '  %swarn%s %s\n' "${YELLOW}" "${RESET}" "$1"; WARNED=$((WARNED + 1)); }

SLUG="$(basename "${THEME_DIR}")"
VERSION="$(sed -n 's/^Version:[[:space:]]*//p' style.css | head -1 | tr -d '[:space:]')"
ZIP="build/${SLUG}-${VERSION}.zip"

if [[ ! -f "${ZIP}" ]]; then
	printf '%sBuilding %s first.%s\n' "${DIM}" "${ZIP}" "${RESET}"
	bash tools/build-zip.sh >/dev/null
fi

STAGE="$(mktemp -d)"
trap 'rm -rf "${STAGE}"' EXIT
unzip -q "${ZIP}" -d "${STAGE}"
T="${STAGE}/${SLUG}"

printf '\n%sChecking %s against the WordPress.org requirements%s\n\n' "${DIM}" "${ZIP}" "${RESET}"

CRLF="$( find "${T}" -type f \
	\( -name '*.php' -o -name '*.css' -o -name '*.html' -o -name '*.json' -o -name '*.txt' -o -name '*.pot' \) \
	-exec grep -lU $'\r' {} \; 2>/dev/null || true )"

if [[ -z "${CRLF}" ]]; then
	pass "line endings are consistently LF"
else
	fail "CRLF line endings found (breaks the directory's SVN import):"
	printf '       %s\n' ${CRLF}
fi

PROHIBITED="$( find "${T}" \
	\( -name '.*' -o -name '*.sql' -o -name '*.zip' -o -name 'favicon.ico' \
	   -o -name 'thumbs.db' -o -name 'desktop.ini' -o -name 'error_log' \
	   -o -name 'web.config' -o -name 'php.ini' \) -print 2>/dev/null || true )"

[[ -z "${PROHIBITED}" ]] && pass "no hidden or prohibited files in the package" \
	|| { fail "prohibited files in the package:"; printf '       %s\n' ${PROHIBITED}; }

VCS="$( find "${T}" -type d \( -name '.git' -o -name '.svn' -o -name '.hg' -o -name '.bzr' \) 2>/dev/null || true )"
[[ -z "${VCS}" ]] && pass "no version control directories" || fail "version control directories present"

DEV="$( find "${T}" -maxdepth 1 \( -name 'node_modules' -o -name 'vendor' -o -name 'tools' -o -name 'build' \) 2>/dev/null || true )"
[[ -z "${DEV}" ]] && pass "no development directories" || fail "development directories shipped: ${DEV}"

for f in style.css readme.txt theme.json templates/index.html; do
	[[ -f "${T}/${f}" ]] && pass "required file ${f}" || fail "missing required file ${f}"
done

STABLE="$( sed -n 's/^Stable tag:[[:space:]]*//p' "${T}/readme.txt" | head -1 | tr -d '[:space:]' )"
[[ "${VERSION}" == "${STABLE}" ]] && pass "Version matches readme.txt Stable tag (${VERSION})" \
	|| fail "style.css Version (${VERSION}) does not match readme.txt Stable tag (${STABLE})"

for header in "Theme Name" "Author" "Description" "Version" "Requires at least" "Tested up to" "Requires PHP" "License" "License URI" "Text Domain"; do
	grep -q "^${header}:" "${T}/style.css" || fail "style.css is missing the ${header} header"
done
pass "style.css carries every required header"

DOMAIN="$( sed -n 's/^Text Domain:[[:space:]]*//p' "${T}/style.css" | head -1 | tr -d '[:space:]' )"
[[ "${DOMAIN}" == "${SLUG}" ]] && pass "text domain matches the theme slug" \
	|| fail "text domain is '${DOMAIN}', expected '${SLUG}'"

#
# A slug already published by someone else is not just a naming problem. Every
# WordPress install with this theme -- including the development one -- compares
# its version against the published theme and offers an update. Accepting it
# deletes the theme directory before installing the download, which destroys a
# working copy that is bind-mounted or symlinked into wp-content/themes.
#
TAKEN="$( curl -sfL --max-time 10 \
	"https://api.wordpress.org/themes/info/1.2/?action=theme_information&request%5Bslug%5D=${SLUG}" \
	2>/dev/null | grep -o '"version":"[^"]*"' | head -1 | cut -d'"' -f4 || true )"

if [[ -n "${TAKEN}" ]]; then
	fail "the slug '${SLUG}' is already published on WordPress.org (version ${TAKEN})"
	printf '       %sSubmission will be rejected, and WordPress will offer to "update"%s\n' "${DIM}" "${RESET}"
	printf '       %syour working copy into that theme, deleting it. Rename before shipping.%s\n' "${DIM}" "${RESET}"
else
	pass "the slug '${SLUG}' is not taken on WordPress.org"
fi

grep -qiE '^Author:[[:space:]]*(Batavia Contributors|Your Name)' "${T}/style.css" \
	&& warn "style.css Author is still a placeholder" || true
grep -qiE '^Contributors:[[:space:]]*yourwporgusername' "${T}/readme.txt" \
	&& warn "readme.txt Contributors is still a placeholder (needs a WordPress.org username)" || true
grep -q 'accessibility-ready' "${T}/style.css" \
	&& warn "accessibility-ready is claimed; expect the separate, slower accessibility review" || true

SHOT=""
[[ -f "${T}/screenshot.png" ]] && SHOT="${T}/screenshot.png"
[[ -f "${T}/screenshot.jpg" ]] && SHOT="${T}/screenshot.jpg"

if [[ -z "${SHOT}" ]]; then
	fail "screenshot.png is missing (required; at most 1200x900, ratio 4:3)"
else
	DIMS="$( php -r '$s = getimagesize($argv[1]); echo $s ? $s[0] . " " . $s[1] : "0 0";' "${SHOT}" )"
	W="${DIMS% *}"; H="${DIMS#* }"

	if (( W > 1200 || H > 900 )); then
		fail "screenshot is ${W}x${H}; the maximum is 1200x900"
	elif (( W * 3 != H * 4 )); then
		fail "screenshot is ${W}x${H}; the ratio must be 4:3"
	else
		pass "screenshot is ${W}x${H} (4:3)"
	fi
fi

printf '\n'

if (( FAILED > 0 )); then
	printf '%s%d blocking issue(s)%s, %d warning(s).\n' "${RED}" "${FAILED}" "${RESET}" "${WARNED}"
	printf '%sAlso run: npm run theme-check%s\n' "${DIM}" "${RESET}"
	exit 1
fi

printf '%sNo blocking issues%s, %d warning(s).\n' "${GREEN}" "${RESET}" "${WARNED}"
printf '%sAlso run: npm run theme-check%s\n' "${DIM}" "${RESET}"
