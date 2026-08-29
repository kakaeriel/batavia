# Changelog

All notable changes to Celestine are recorded here, following
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

The version in `style.css` is the source of truth and must match the
`Stable tag` in `readme.txt` for every release.

## [Unreleased]

## [1.1.0] - 2026-08-22

### Added

- An Appearance sub-page. A block theme has no Customizer, and the Site Editor
  gives no hint about what a theme expects of you, so the page names the
  categories the patterns are built around, points at Reading settings for the
  static front page, and links into each part of the Site Editor.

  Kept within what a theme is permitted to do: no demo importer, no outbound
  requests, no usage tracking. Those belong in a companion plugin. Verified
  against Theme Check -- zero warnings, zero recommendations.


### Added

- `tools/dev-server.sh`, a local WordPress on SQLite that needs no Docker.
- `tools/dev-markers.php`, annotating the rendered page with the template,
  parts and patterns that produced it.
- `tools/dev-guard.php`, which stops WordPress from offering to "update" the
  theme under development into whatever is published under the same slug.
- `tools/pull-from-editor.php` and `tools/reset-editor.php`, moving Site Editor
  customisations onto the theme's files and clearing them again.
- `tools/preflight.sh`, checking the built zip against the WordPress.org
  submission requirements Theme Check does not cover, including whether the
  theme slug is already published by someone else.

### Changed

- Renamed the theme from Almanac to Celestine. The `almanac` slug was already
  taken on WordPress.org; `celestine` was confirmed available via the
  WordPress.org Themes API before the rename.

### Fixed

- Theme Check honours `.distignore`, so a symlinked development install is
  checked as the theme that ships rather than as the repository.

## [1.0.0] - 2026-08-20

Initial release.

### Added

- Full site editing block theme targeting WordPress 6.6+, `theme.json` v3.
- Six-slug colour system with automatic dark mode driven by
  `prefers-color-scheme`, implemented by repainting the colour presets.
- Self-hosted IBM Plex Sans and Plex Mono, Latin and Latin Extended subsets
  split by `unicode-range`; the two regular weights are preloaded.
- Eight front page patterns, seven templates, header and footer parts.
- Eight custom block styles.
- Translation template covering pattern titles and descriptions.
- Development tooling: canonical block markup validation against the editor's
  own parser, structural validation, a WCAG contrast audit, and PHPCS.

[Unreleased]: https://github.com/celestine-theme/celestine/compare/v1.0.0...HEAD
[1.0.0]: https://github.com/celestine-theme/celestine/releases/tag/v1.0.0
