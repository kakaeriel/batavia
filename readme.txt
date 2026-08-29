=== Batavia ===
Contributors: kakaeriel
Requires at least: 6.7
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.5.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Tags: accessibility-ready, block-patterns, block-styles, blog, custom-colors, custom-logo, custom-menu, editor-style, featured-images, full-site-editing, full-width-template, grid-layout, one-column, portfolio, sticky-post, template-editing, threaded-comments, translation-ready, wide-blocks

A block theme for a personal site: home page, notes, selected work and a rate card, built entirely from core blocks.

== Description ==

Batavia is a personal site in two pages. Home holds who you are, selected
work, roles and how you take work. Notes is the writing index. There is no
contact page -- buttons open WhatsApp or email from the theme settings.

The system is quiet: ink on paper, a monospace accent for the parts of the page
that are really data, and hairline rules doing the work that boxes and shadows
usually do.

Everything is composed from core blocks. There are no custom post types and no
custom taxonomies, which means your content stays yours when you switch themes,
and everything you see on the front end can be rearranged in the Site Editor.

Thirteen patterns, in two groups. Seven for a front page (the client pattern
is optional and is not used on the shipped homepage):

* Hero -- name, role, summary, calls to action and a tools line
* Experience -- roles and dates, each with a square for a company mark or logo
* Client -- optional wordmarks; not used on the front page
* Portfolio grid -- project cards with screenshots, including fun projects
* Consulting rates -- hourly, project and retainer as rows, not cards
* Post index -- recent posts as article entries
* Closing call to action -- a last invitation to get in touch, before the footer

And six for the middle of an article:

* Note -- an aside on a tinted panel, for a caveat or a prerequisite
* Specification table -- monospace key and value rows on hairline rules
* Numbered steps -- a procedure, each step ruled off from the next
* Questions and answers -- collapsible Details blocks
* About the author -- a short bio with social icons
* Portfolio detail -- a project's client, role, timeline and stack, for the
  top of a portfolio post

Under Appearance > Batavia there is a settings screen for the details that
would otherwise have to be retyped into every pattern that mentions them: your
name, what you do, a WhatsApp number, an email address and your social profiles.
The patterns read them through the Block Bindings API, so a pattern used in
twenty posts shows the same email address in all twenty, and correcting it is
one edit. Fields left empty change nothing -- the pattern's own text stands.

Dark mode follows the visitor's system preference. There is no toggle and no
front-end JavaScript: the six colour presets are repainted under
prefers-color-scheme, so anything using the theme's palette moves with it.

IBM Plex Sans and IBM Plex Mono are bundled with the theme and served from your
own domain. Batavia makes no external requests of any kind -- no font CDN, no
analytics, no phone-home, and nothing hidden behind an upgrade. It is free
software, and the source is public.

== Frequently Asked Questions ==

= Where do I set the favicon and my social links? =

Appearance > Batavia, across a few tabs. Site identity holds WordPress's own
settings -- site icon, logo, title, tagline and front page -- gathered in one
place so setting up a new site is not a tour of four screens. Those values belong
to your site rather than to Batavia, and they stay as you left them if you
switch theme.

Profile and Contact hold Batavia's own: your name, role, location, email
address and contact page. Social media holds fourteen social
profiles; icons whose field you leave empty are left out of the page entirely,
so there are no dead links and no gaps.

= Why can I not edit this heading in the post editor? =

Because it is reading a value from one of the tabs under Appearance > Batavia,
and the editor is telling you where to change it. Blocks connected to a setting
show a small indicator in the editor; the fix is to change the setting, not the
block. If you would rather write directly into the block, remove the connection
from the block's sidebar.

= How do I separate blog posts from portfolio projects? =

Use categories. Create a Blog category and a Portfolio category, then assign each
post to one of them. The Portfolio grid and Post index patterns are ordinary
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

Appearance > Editor > Styles. Browse Styles to switch the whole set: the default
Neutral rust, or Slate, Forest, Indigo, Newsprint. Every colour is still one of
six presets -- Paper, Panel, Ink, Annotation, Accent and Rule -- so editing a
preset changes it everywhere at once, in both light and dark mode.

If you set a literal colour rather than a preset, that colour will stay fixed in
both schemes, which is worth knowing before you wonder why one element does not
follow dark mode.

= Can I use real client logos instead of the text wordmarks? =

Yes. Replace any wordmark in the Client pattern with an Image block and apply the
"Logo mark" block style, which desaturates the image until it is hovered so a row
of mismatched logos stays visually quiet.

= Does the theme work without the bundled patterns? =

Yes. The patterns are starting points. Delete them, edit them, or build your own
pages from core blocks; the theme's styling comes from theme.json and applies to
any block you use.

= How do I reuse a section across several posts? =

Two things are worth separating. Details that repeat -- your name, your email
address, your social profiles -- come from the Profile, Contact and Social media
tabs under Appearance > Batavia, so they are already consistent everywhere and
stay that way after you change one.

Wording is different. Select the blocks, choose Create pattern from the toolbar
and tick Synced: every copy then updates together. That pattern is yours, stored
in your site rather than in the theme, so it survives a theme switch too.

= Is there a paid version? =

No, and there is no plan for one. Batavia is GPL-licensed free software with
its source in public, complete as published: no locked patterns, no upgrade
prompts, no accounts.

== Copyright ==

Batavia WordPress Theme, (C) 2026 Hairil.
Batavia is distributed under the terms of the GNU General Public License v2 or later.

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

No images, icons or third-party JavaScript are bundled with this theme. The two
JavaScript files it does ship are its own, both admin-only: one resolves the
settings a block is connected to inside the editor, the other opens the media
library on the settings screen. The front end runs no theme JavaScript at all.

== Changelog ==

= 1.4.0 =
* Added a Homepage tab under Appearance > Batavia: every section can be
  turned off individually, Selected work and Notes can each be pointed at a
  category, and Experience and Consulting are now editable lists with add,
  remove and drag-to-reorder rows rather than three roles and three tiers
  hardcoded into the pattern.
* Notes can be set to all categories or one specific category, as an
  explicit choice rather than an unlabelled empty dropdown.
* Split the Settings tab into four: Site identity, Profile, Contact and
  Social media, each its own form and its own save button.
* Added a footer copyright override.
* Selected work always shows its featured image and title and never its
  description, rather than three separate toggles.
* Removed the Closing call to action, End of post prompt, Pull quote and
  Tools line patterns, and the "Getting started" tab -- Hero already carries
  its own tools line and call-to-action buttons.
* Renamed two patterns to match what they actually are: Notes index is now
  Post index, and Client strip is now Client.
* The Hero's status line no longer assumes a specific kind of availability --
  its default text and placeholder are now a neutral example.

= 1.3.0 =
* Cooler, higher-contrast palette: Paper and Panel now separate the homepage
  into bands rather than one wash of cream.
* Added four colour sets -- Slate, Forest, Indigo, Newsprint -- under Styles.
  Dark mode follows whichever set is active.
* Navigation is two pages, Home and Notes. There is no contact page; the
  buttons open WhatsApp or email from the theme settings.
* Stack is a single tools line rather than a three-column catalogue.
* Selected work carries the screenshots, Experience carries a square for a
  company mark, consulting reads as rows rather than pricing cards, and notes
  entries show a thumbnail, title and opening sentences.

= 1.2.0 =
* Added a settings screen under Appearance > Batavia, in two clearly separated
  halves: WordPress's own site identity settings, and Batavia's profile,
  contact and social details.
* Added a block binding source, so patterns read those details instead of
  repeating them. An empty setting leaves the pattern's own text in place.
* Added social icons to the footer, driven by the settings. Icons with no address
  are dropped before the page is sent.
* Added seven patterns for use inside an article: Note, Specification table,
  Numbered steps, Questions and answers, Pull quote, About the author, End of
  post prompt.
* Added three block styles: Spec sheet for tables, Numbered steps for lists, and
  Ruled for Details blocks.
* Neutralised the placeholder text in the Hero, rate card and call-to-action
  patterns so it reads as something to replace rather than someone else's copy.
* Requires WordPress 6.7, up from 6.6, for editor-side block bindings.

= 1.1.0 =
* Added an Appearance sub-page explaining what the theme expects, since a block
  theme has no Customizer to put that in.

= 1.0.0 =
* Initial release.
