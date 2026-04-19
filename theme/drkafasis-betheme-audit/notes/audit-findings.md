## Planned migration target: betheme-child

- Initial child theme skeleton created locally
- No production deployment yet
- No custom snippets migrated yet

## Migrated to child theme (local only)

- block editor disable
- widgets block editor disable
- dashicons deregistration for guests
- single post signature block
- not migrated yet:
- pojo-accessibility update suppression logic
- header.php custom head additions

## Migrated to child theme via wp_head hook

- favicon / manifest / theme-color / preconnect additions
- parent header.php still unchanged locally

## Current status

- Local child theme prepared
- Safe customizations migrated
- Header additions migrated via wp_head
- Production activation not done yet
- Parent theme update still blocked pending validation

## Child preview fix

- Duplicate signature found during child preview
- Fixed in child theme by removing parent `wpb_after_post_content` filter before re-adding the child implementation
