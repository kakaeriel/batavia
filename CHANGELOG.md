# Changelog

All notable changes to Batavia are recorded here, following
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and
[Semantic Versioning](https://semver.org/spec/v2.0.0.html).

The version in `style.css` is the source of truth and must match the
`Stable tag` in `readme.txt` for every release.

## [Unreleased]

## [1.5.0] - 2026-08-29

### Added

- A third "All except one category" mode for Notes, alongside "All
  categories" and "One specific category".
- A Logo media field on each Experience row, alongside Mark, desaturated
  until hovered like the Client pattern's wordmarks.
- Closing call to action, a new pattern just above the footer: a button
  reusing Hero's own contact_url binding, not a form.
- Portfolio detail, a new pattern for the top of a portfolio post's own
  content: Client, Role, Timeline and Stack as monospace rows, plus a
  "Visit the live site" button.
- "View all work" and "All notes" links below Selected work and Notes,
  pointing at the relevant category archive (or the posts page, if one is
  set) instead of doing nothing.
- The category archive for whichever category Selected work is scoped to
  now gets the portfolio grid's own two-column layout instead of the
  standard post list.

### Changed

- Selected work: two columns instead of three, so a screenshot reads as a
  screenshot; no crop, screenshots show at their original aspect ratio; no
  category badge, since one is redundant once the section is scoped to a
  single category; capped at six projects with the "View all work" link
  carrying the rest; a hairline-to-accent hover state on the image instead
  of a shadow or a zoom.
- Removed the Hero status line entirely -- pattern markup, both settings
  fields, and every doc reference.
- Closing call to action's background changed from an Ink/Base inversion to
  Surface, and its accent top border was removed.
- Removed the rule between entries in Notes and between rows in Experience.

### Fixed

- `portfolio_category` and Notes' "One specific category" mode never
  actually filtered anything: `query_loop_block_query_vars` fires once per
  Query Loop descendant, never the Query block itself, so the className it
  was read from was always empty. Now baked directly into the Query block's
  own `query.taxQuery` attribute instead, the same mechanism a category
  chosen by hand in the block's Filters panel already uses.
- Experience's rows were centered instead of stretching full width, from a
  `constrained` layout with no `contentSize` falling back to the theme's
  global default. The same root cause, in the narrower form of a
  `contentSize` given without `justifyContent`, also centered the text
  column next to each Notes and post-list thumbnail, and each Consulting
  tier's copy, instead of keeping it flush against the thumbnail -- and
  centered the archive and search templates' page title.
- The footer template part carried a stray 24px top margin from the root
  layout's global blockGap, stacking on top of its own padding.
- The Logo media picker did not open on the Homepage tab --
  `wp_enqueue_media()` only ran on Site identity, from before Experience
  had a media field of its own.
- The Mark field could overflow its 3rem square; a company name typed in
  full is now clipped to two characters, per the field's own help text.

## [1.4.0] - 2026-08-29

### Changed

- Renamed the theme from Celestine to Batavia, across the text domain, slug,
  function and constant prefixes, block/pattern namespaces, and CSS class
  names.
- Repositioned from a portfolio/blog/rate-card theme for engineers to a
  two-page personal site (home and notes), with no dedicated contact page --
  patterns open WhatsApp or email instead.
- `Appearance -> Batavia` grew from one explanatory page into a five-tab
  settings screen (Site identity, Profile, Contact, Social media, Homepage).
- Four style variations: Forest, Indigo, Newsprint, Slate.

### Added

- `inc/settings.php` and `inc/bindings.php`: a single `batavia_settings`
  option, read into patterns through the Block Bindings API, so a value like
  an email address is entered once and stays consistent everywhere it is used.
- Five new patterns for the middle of an article: Note, Specification table,
  Numbered steps, Questions and answers, About the author.
- `screenshot.png` for the theme directory listing.

### Removed

- The technical-blog-oriented patterns (`tech-stack`, `cta-footer`,
  `hidden-blog-heading`) that do not fit the personal-site scope.

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

[Unreleased]: https://github.com/batavia-theme/batavia/compare/v1.5.0...HEAD
[1.5.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.5.0
[1.4.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.4.0
[1.0.0]: https://github.com/batavia-theme/batavia/releases/tag/v1.0.0
