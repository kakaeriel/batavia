# Changelog

All notable changes to Batavia are recorded here, following
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

The version in `style.css` is the source of truth and must match the
`Stable tag` in `readme.txt` for every release.

## [Unreleased]

## [1.5.0] - 2026-08-29

### Added

- Post detail sidebar: Recent notes, Selected work, Get in touch and
  Consulting, plus a Related notes section after the content.
- Portfolio detail pattern, for a portfolio post's own content (client,
  role, timeline, stack, live link).
- Closing call to action section above the footer.
- "All except one category" mode for Notes.
- A placeholder shown in place of a post's missing featured image.
- Experience rows can show a company logo as a circular photo, with the
  company name printed next to the role.
- "All notes" and "View all work" links; the category archive for
  Selected work now uses the portfolio grid layout instead of a plain list.

### Changed

- Selected work: two columns, uncropped screenshots, no category badge,
  capped at six with a "View all work" link.
- Post tags moved below the content and styled as chips instead of
  underlined text.
- Previous/Next links repositioned above Related notes.
- Removed the rule between entries in Notes, Experience and archive
  listings, and the border around Closing call to action.

### Fixed

- Category and portfolio filtering (Selected work, Notes) did not
  actually filter anything.
- Several sections rendered centered instead of left-aligned: Experience
  rows, archive/search page titles, and text next to thumbnails or in
  the sidebar.
- The Logo media picker did not open on the Homepage tab.
- A stray top margin under the footer.
- A company name in Experience was clipped instead of shown in full.

## [1.4.0] - 2026-08-29

### Changed

- Renamed the theme from Celestine to Batavia.
- Repositioned from a portfolio/blog/rate-card theme to a two-page
  personal site (home and notes), with no contact page -- patterns open
  WhatsApp or email directly instead.
- Settings screen grew to five tabs: Site identity, Profile, Contact,
  Social media, Homepage.
- Four style variations: Forest, Indigo, Newsprint, Slate.

### Added

- Theme settings stored in one option and read into patterns through the
  Block Bindings API.
- Five new content patterns: Note, Specification table, Numbered steps,
  Questions and answers, About the author.
- Theme screenshot.

### Removed

- Technical-blog-oriented patterns that no longer fit the personal-site
  scope.

## [1.1.0] - 2026-08-22

### Added

- An Appearance sub-page guiding setup: the pattern categories, a link to
  Reading settings, and links into the Site Editor.
- Local dev tooling: a SQLite dev server, on-page dev markers, an
  update guard, Site Editor sync scripts, and a submission preflight
  check.

### Changed

- Renamed the theme from Almanac to Celestine (the `almanac` slug was
  already taken on WordPress.org).

### Fixed

- Theme Check now honours `.distignore`, so a symlinked dev install is
  checked as the theme that ships.

## [1.0.0] - 2026-08-20

Initial release.

### Added

- Full site editing block theme targeting WordPress 6.6+, `theme.json` v3.
- Automatic dark mode via `prefers-color-scheme`.
- Self-hosted IBM Plex Sans and Plex Mono.
- Eight front page patterns, seven templates, header and footer parts,
  eight custom block styles.
- Translation-ready.
- Development tooling: block markup validation, structural validation, a
  contrast audit, and PHPCS.

[Unreleased]: https://github.com/batavia-theme/batavia/compare/v1.5.0...HEAD
[1.5.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.5.0
[1.4.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.4.0
[1.1.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.1.0
[1.0.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.0.0
