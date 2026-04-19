<?php
/**
 * Enqueue parent and child theme styles.
 */
function betheme_child_enqueue_styles() {
	wp_enqueue_style(
		'betheme-parent-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme( 'betheme' )->get( 'Version' )
	);

	wp_enqueue_style(
		'betheme-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'betheme-parent-style' ),
		wp_get_theme()->get( 'Version' )
	);
}
add_action( 'wp_enqueue_scripts', 'betheme_child_enqueue_styles' );

/**
 * Disable the block editor for posts.
 */
function betheme_child_disable_post_block_editor( $use_block_editor, $post ) {
	return false;
}
add_filter( 'use_block_editor_for_post', 'betheme_child_disable_post_block_editor', 10, 2 );

/**
 * Disable the widgets block editor.
 */
function betheme_child_disable_widgets_block_editor( $use_widgets_block_editor ) {
	return false;
}
add_filter( 'use_widgets_block_editor', 'betheme_child_disable_widgets_block_editor' );

/**
 * Remove dashicons on the frontend for unauthenticated users.
 */
function betheme_child_deregister_dashicons_for_guests() {
	if ( ! is_user_logged_in() ) {
		wp_deregister_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'betheme_child_deregister_dashicons_for_guests', 100 );

/**
 * Output migrated custom head additions from the parent theme.
 */
function betheme_child_output_custom_head_additions() {
	echo '<link rel="apple-touch-icon" sizes="180x180" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/apple-touch-icon.png' ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="32x32" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/favicon-32x32-1.png' ) . '">' . "\n";
	echo '<link rel="icon" type="image/png" sizes="16x16" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/favicon-16x16-1.png' ) . '">' . "\n";
	echo '<link rel="manifest" href="' . esc_url( '/site.webmanifest' ) . '">' . "\n";
	echo '<link rel="mask-icon" href="' . esc_url( 'https://www.drkafasis.gr/wp-content/uploads/2022/04/safari-pinned-tab.svg' ) . '" color="' . esc_attr( '#5bbad5' ) . '">' . "\n";
	echo '<meta name="msapplication-TileColor" content="' . esc_attr( '#da532c' ) . '">' . "\n";
	echo '<meta name="theme-color" content="' . esc_attr( '#ffffff' ) . '">' . "\n";
	echo '<link rel="preconnect" href="' . esc_url( 'https://maps.gstatic.com/' ) . '">' . "\n";
	echo '<link rel="preconnect" href="' . esc_url( 'https://maps.googleapis.com' ) . '">' . "\n";
}
add_action( 'wp_head', 'betheme_child_output_custom_head_additions' );

/**
 * Replace the parent post signature filter with the child theme version.
 */
function betheme_child_replace_parent_post_signature_filter() {
	remove_filter( 'the_content', 'wpb_after_post_content', 10 );
	remove_filter( 'the_content', 'betheme_child_append_post_signature', 10 );
	add_filter( 'the_content', 'betheme_child_append_post_signature', 10 );
}
add_action( 'wp', 'betheme_child_replace_parent_post_signature_filter', 1 );

/**
 * Append the existing signature block after single post content.
 */
function betheme_child_append_post_signature( $content ) {
	if ( is_single() ) {
		$content .= '<div id="blog-post-footer">
    <p class="big"><i>Με εκτίμηση</i></p>

<h3>Θεόδωρος Καφάσης</h3>

<p class="big">Γενικός Οικογενειακός Iατρός</p>
<p class="big">Κουσίδη 31 - Ζωγράφου, Τ.Κ. 15772</p>
<p class="big">Τηλ: <a href="tel:2107793711" role="link">2107793711</a> - www.drkafasis.gr</p></div>';
	}

	return $content;
}
