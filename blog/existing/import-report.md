# Existing Article Import Report

## Backup Files Inspected

- `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\BACKUPS\drkafasis-working-2026-04-19`
- `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\BACKUPS\drkafasis-working-2026-04-19\database\drkafasi_drkafasis.sql`
- `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\BACKUPS\drkafasis-working-2026-04-19\site\public_html`
- `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\BACKUPS\drkafasis-working-2026-04-19\site\public_html\wp-config.php`
- `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\BACKUPS\drkafasis-working-2026-04-19\site\public_html\wp-content`

## SQL Dump Used

- `drkafasi_drkafasis.sql`
- Dump format: phpMyAdmin SQL export
- WordPress table prefix detected: `wp_`

## WordPress Structure Detected

- WordPress core content tables are present in the dump
- Tables used for extraction: `wp_posts`, `wp_terms`, `wp_term_taxonomy`, `wp_term_relationships`, `wp_options`
- Permalink structure found in `wp_options`: `/%postname%/`
- Home URL found in `wp_options`: `https://www.drkafasis.gr`

## public_html Clues

- `site/public_html` contains a full WordPress filesystem snapshot
- `wp-config.php` confirms the same database name and `wp_` table prefix as the SQL dump
- `wp-content/cache/` and LiteSpeed cache/plugin folders are present, but were not used as the source of truth for article text
- `wp-content/uploads/` is present and can be used later for media tracing if needed

## Candidate Content Counts

- Total `wp_posts` rows parsed: 367
- Candidate published blog articles (`post` + `publish`): 52
- Excluded content types/statuses include: 4 pages, 123 attachments, 7 navigation items, 7 cookie records, 2 review feed items, 1 contact forms, 170 revisions, 1 auto-drafts

## Export Result

- Published articles exported: 52
- Raw source snapshots written to: `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\REPOS\drkafasis-site\blog\existing\raw`
- Cleaned Markdown exports written to: `E:\- Documents & Projects\Visual Studio 2012 - LEARNING\Studio WebPage\REPOS\drkafasis-site\blog\existing\cleaned`

## Taxonomy Notes

- No `post_tag` taxonomy rows were detected in the SQL dump, so exported tags are empty
- Categories were mapped from `wp_term_relationships` to `wp_term_taxonomy` to `wp_terms`
- No custom blog post type was required for the exported articles; published articles live in the standard `post` post type

## Uncertainties

- `original_url` values were inferred from the `home` option plus the `/%postname%/` permalink structure
- Markdown output is a normalized conversion from stored HTML and plain text, not a manual editorial rewrite
- Raw snapshots preserve the original `post_content` for traceability where cleanup decisions may later be reviewed

## Skipped Items

- No published `post` articles were skipped

## Assumptions Made

- Standard WordPress articles are represented by `wp_posts.post_type = post` and `post_status = publish`
- The SQL dump is the authoritative source of article text for this import
- Filesystem cache and plugin data under `public_html` were used only as contextual validation, not as content sources
