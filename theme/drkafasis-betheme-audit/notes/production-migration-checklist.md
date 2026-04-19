# Production Migration Checklist

## Pre-deploy backups

- Take a full filesystem backup of the live WordPress site.
- Take a full database backup before any theme change.
- Confirm access to hosting file manager, SFTP, and WordPress admin.
- Record the currently active theme and parent theme version.

## Files to upload

- Upload the full `betheme-child` folder to `wp-content/themes/`.
- Do not overwrite the existing `betheme` parent theme during child theme upload.
- Verify uploaded files include `style.css`, `functions.php`, and `README.md`.

## Theme activation step

- In WordPress admin, go to Appearance > Themes.
- Confirm `BeTheme Child` is visible and recognized as a child of `betheme`.
- Activate `BeTheme Child`.

## Immediate post-activation checks

- Check homepage and a sample of key internal pages.
- Check a single post page and confirm the signature block still appears.
- Confirm favicon, manifest, theme-color, and map preconnect tags are present in page source.
- Confirm frontend styling loads correctly from both parent and child theme.
- Confirm logged-out frontend pages do not load `dashicons`.
- Confirm classic editor behavior remains as expected for posts and widgets.

## Rollback plan

- If anything breaks, reactivate the previous theme state immediately.
- Restore the pre-deploy backup if theme reactivation alone does not recover expected behavior.
- Do not delete parent-theme custom code until the child-theme activation is validated.

## Conditions before any parent theme update

- Child theme must be activated successfully in production.
- Migrated customizations must be validated on live pages.
- Unmigrated parent-theme logic must be reviewed and explicitly resolved.
- Only after validation should parent-theme custom code cleanup or parent theme update be considered.

