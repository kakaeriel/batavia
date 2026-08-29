=== Celestine ===
Contributors: yourwporgusername
Requires at least: 6.6
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: accessibility-ready, block-patterns, block-styles, blog, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, full-width-template, grid-layout, one-column, portfolio, sticky-post, template-editing, threaded-comments, translation-ready, wide-blocks

A precise block theme for engineers: portfolio, technical blog and consulting rates, built entirely from core blocks.

== Description ==

Celestine is for engineers who want one site instead of three. It puts a project
portfolio, a technical blog and a consulting rate card under a single, quiet
typographic system: ink on paper, a monospace accent for the parts of the page
that are really data, and hairline rules doing the work that boxes and shadows
usually do.

Everything is composed from core blocks. There are no custom post types, no
custom taxonomies and no theme settings screen, which means your content stays
yours when you switch themes, and everything you see on the front end can be
rearranged in the Site Editor.

Eight patterns cover the front page:

* Hero -- availability, name, role, summary and calls to action
* Tech stack -- a three-column specification sheet in monospace
* Experience timeline -- a ruled rail of roles and companies
* Client strip -- companies worked with, as monospace wordmarks
* Portfolio grid -- a Query Loop laid out as project cards
* Consulting rates -- hourly, project and retainer packages
* Writing index -- a ruled list of recent posts
* Closing call to action -- a contact section above the footer

Dark mode follows the visitor's system preference. There is no toggle and no
JavaScript: the six colour presets are repainted under prefers-color-scheme,
so anything using the theme's palette moves with it.

IBM Plex Sans and IBM Plex Mono are bundled with the theme and served from your
own domain. Celestine makes no external requests of any kind -- no font CDN, no
analytics, no phone-home. Two small stylesheets and no theme JavaScript.

== Frequently Asked Questions ==

= How do I separate blog posts from portfolio projects? =

Use categories. Create a Blog category and a Portfolio category, then assign each
post to one of them. The Portfolio grid and Writing index patterns are ordinary
Query Loop blocks, so you point each one at the right category by selecting the
block, opening the Filters panel in the sidebar, and choosing a category under
Taxonomies.

The patterns ship unfiltered rather than pre-filtered because a theme cannot know
the category IDs on your site -- those are created when you create the category.
Setting it is a single click per block, and it only has to be done once.

= Why do I see the portfolio homepage instead of my posts? =

WordPress uses the front-page template for the site's front page regardless of
your Reading settings. If you would rather the front page list your posts, go to
Appearance > Editor > Templates, open Front Page, and either replace its contents
or delete the template so the index template takes over.

= How do I change the colours or fonts? =

Appearance > Editor > Styles. Every colour in the theme is one of six presets --
Paper, Panel, Ink, Annotation, Accent and Rule -- so editing a preset changes it
everywhere at once, in both light and dark mode.

If you set a literal colour rather than a preset, that colour will stay fixed in
both schemes, which is worth knowing before you wonder why one element does not
follow dark mode.

= Can I use real client logos instead of the text wordmarks? =

Yes. Replace any wordmark in the Client strip with an Image block and apply the
"Logo mark" block style, which desaturates the image until it is hovered so a row
of mismatched logos stays visually quiet.

= Does the theme work without the bundled patterns? =

Yes. The patterns are starting points. Delete them, edit them, or build your own
pages from core blocks; the theme's styling comes from theme.json and applies to
any block you use.

== Copyright ==

Celestine WordPress Theme, (C) 2026 Celestine Contributors.
Celestine is distributed under the terms of the GNU General Public License v2 or later.

This program is free software: you can redistribute it and/or modify it under the
terms of the GNU General Public License as published by the Free Software
Foundation, either version 2 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY
WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A
PARTICULAR PURPOSE. See the GNU General Public License for more details.

= Bundled resources =

IBM Plex Sans and IBM Plex Mono
Copyright 2017 IBM Corp.
Licensed under the SIL Open Font License, Version 1.1
Source: https://github.com/IBM/plex
Licence: https://scripts.sil.org/OFL
Full licence text: assets/fonts/LICENSE-IBM-Plex.txt

The bundled woff2 files are the Latin and Latin Extended subsets, taken from the
Fontsource distribution of IBM Plex (https://fontsource.org). Only the weights the
theme actually uses are included: 400, 500 and 600 for Plex Sans plus a 400
italic, and 400 and 500 for Plex Mono.

No images, icons or JavaScript libraries are bundled with this theme.

== Changelog ==

= 1.0.0 =
* Initial release.
