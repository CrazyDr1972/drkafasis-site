# Site Inventory

## Site Overview

This repository is the umbrella workspace for the Dr Kafasis website. It separates WordPress theme work, blog operations, broader site documentation, and future automation into distinct areas.

## Main Areas

- `theme/`
- `blog/`
- `site/`
- `automation/`

## Theme Workspace

- Existing WordPress theme work currently lives under `theme/drkafasis-betheme-audit/`
- This area contains the copied BeTheme audit workspace and related local notes
- It should remain stable unless a specific WordPress code task is requested

## Blog Workspace

- `blog/ideas/` for topic capture
- `blog/drafts/` for active article development
- `blog/published/` for final approved article versions
- `blog/templates/` for reusable article structures
- `blog/seo-audits/` for article-level SEO review notes

## Site Documentation Area

- `site/docs/` for site-wide notes and inventories
- `site/redirects/` for redirect planning
- `site/schema/` for structured data planning
- `site/assets/` for non-theme asset inventories and notes

## Automation Area

- `automation/wordpress-api/` reserved for future WordPress API integration code
- `automation/scripts/` reserved for local helper scripts
- `automation/prompts/` reserved for reusable Codex or workflow prompts

## Known Existing Assets / Notes

- Root workspace includes umbrella-level guidance in `README.md` and `AGENTS.md`
- Local Codex settings exist under `.codex/config.toml`
- The copied theme workspace includes its own `notes/` directory with migration and audit notes
- A baseline blog article template already exists at `blog/templates/article-template.md`

## Open Questions

- Which site sections should receive dedicated inventory notes first
- Which blog categories or medical topic clusters should be standardized
- Whether a future shared publishing checklist should live under `blog/` or `site/docs/`
- Which automation tasks are actually worth implementing first

## Next Documentation Priorities

- Add a content pipeline note for draft to publish workflow
- Add a redirect mapping template under `site/redirects/`
- Add a schema planning note for medical article pages
- Add a site asset inventory note for logos, favicons, and key media resources

