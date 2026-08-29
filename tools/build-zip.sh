#!/usr/bin/env bash
#
# Builds the distributable theme zip.
#
# The repository carries development tooling that must not reach a user's
# wp-content/themes directory. This copies only the files listed for
# distribution into build/celestine, zips that, and then asserts nothing excluded
# slipped through -- worth having, because a stray node_modules is an instant
# rejection from the theme directory.
#
# Usage: bash tools/build-zip.sh
set -euo pipefail

THEME_SLUG="celestine"
THEME_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
BUILD_DIR="${THEME_DIR}/build"
STAGE_DIR="${BUILD_DIR}/${THEME_SLUG}"

cd "${THEME_DIR}"

VERSION="$(sed -n 's/^Version:[[:space:]]*//p' style.css | head -1 | tr -d '[:space:]')"

if [[ -z "${VERSION}" ]]; then
	echo "error: could not read Version from style.css" >&2
	exit 1
fi

echo "Building ${THEME_SLUG} ${VERSION}"

rm -rf "${BUILD_DIR}"
mkdir -p "${STAGE_DIR}"

EXCLUDES=()
while IFS= read -r line; do
	[[ -z "${line}" || "${line}" == \#* ]] && continue
	EXCLUDES+=( "--exclude=${line}" )
done < .distignore

rsync -a "${EXCLUDES[@]}" ./ "${STAGE_DIR}/"

if [[ ! -f "${STAGE_DIR}/screenshot.png" ]]; then
	echo "warning: screenshot.png is missing; the theme will have no preview image" >&2
fi

cd "${BUILD_DIR}"
ZIP_NAME="${THEME_SLUG}-${VERSION}.zip"
zip -rq "${ZIP_NAME}" "${THEME_SLUG}"

LEAKED="$( unzip -Z1 "${ZIP_NAME}" | grep -E "(^|/)(node_modules|vendor|tools|\.git|\.wp-core|\.wp-local|build)(/|$)|(^|/)(composer|package)(-lock)?\.json$|(^|/)phpcs\.xml\.dist$" || true )"

if [[ -n "${LEAKED}" ]]; then
	echo "error: development files leaked into the zip:" >&2
	echo "${LEAKED}" >&2
	exit 1
fi

FILE_COUNT="$( unzip -Z1 "${ZIP_NAME}" | wc -l | tr -d ' ' )"
SIZE="$( du -h "${ZIP_NAME}" | cut -f1 | tr -d ' ' )"

echo "Wrote build/${ZIP_NAME} (${FILE_COUNT} entries, ${SIZE})"
