<?php
/**
 * Headerdata of Theme options.
 * @package ForeverWood
 * @since ForeverWood 1.0.0
*/  

// Additional CSS
if(	!is_admin()){
function foreverwood_fonts_include () {
global $foreverwood_options_db;
// Google Fonts
$bodyfont = $foreverwood_options_db['foreverwood_body_google_fonts'];
$headingfont = $foreverwood_options_db['foreverwood_headings_google_fonts'];
$headlinefont = $foreverwood_options_db['foreverwood_headline_google_fonts'];
$postentryfont = $foreverwood_options_db['foreverwood_postentry_google_fonts'];
$sidebarfont = $foreverwood_options_db['foreverwood_sidebar_google_fonts'];
$menufont = $foreverwood_options_db['foreverwood_menu_google_fonts'];

$fonturl = "//fonts.googleapis.com/css?family=";

$bodyfonturl = $fonturl.$bodyfont;
$headingfonturl = $fonturl.$headingfont;
$headlinefonturl = $fonturl.$headlinefont;
$postentryfonturl = $fonturl.$postentryfont;
$sidebarfonturl = $fonturl.$sidebarfont;
$menufonturl = $fonturl.$menufont;
	// Google Fonts
     if ($bodyfont != 'default' && $bodyfont != ''){
      wp_enqueue_style('foreverwood-google-font1', $bodyfonturl); 
		 }
     if ($headingfont != 'default' && $headingfont != ''){
      wp_enqueue_style('foreverwood-google-font2', $headingfonturl);
		 }
     if ($headlinefont != 'default' && $headlinefont != ''){
      wp_enqueue_style('foreverwood-google-font4', $headlinefonturl); 
		 }
     if ($postentryfont != 'default' && $postentryfont != ''){
      wp_enqueue_style('foreverwood-google-font5', $postentryfonturl); 
		 }
     if ($sidebarfont != 'default' && $sidebarfont != ''){
      wp_enqueue_style('foreverwood-google-font6', $sidebarfonturl);
		 }
     if ($menufont != 'default' && $menufont != ''){
      wp_enqueue_style('foreverwood-google-font8', $menufonturl);
		 }
}
add_action( 'wp_enqueue_scripts', 'foreverwood_fonts_include' );
}

// Additional CSS
function foreverwood_css_include () {
global $foreverwood_options_db;
    if ($foreverwood_options_db['foreverwood_layout_width'] == 'Boxed' ){
			wp_enqueue_style('foreverwood-boxed-layout', get_template_directory_uri().'/css/boxed-layout.css');
		}

		if ($foreverwood_options_db['foreverwood_css'] == 'Green' ){
			wp_enqueue_style('foreverwood-style-green', get_template_directory_uri().'/css/colors/green.css');
		}

		if ($foreverwood_options_db['foreverwood_css'] == 'Red' ){
			wp_enqueue_style('foreverwood-style-red', get_template_directory_uri().'/css/colors/red.css');
		}
}
add_action( 'wp_enqueue_scripts', 'foreverwood_css_include' );

// Display Sidebar on Posts/Pages
function foreverwood_display_sidebar() {
global $foreverwood_options_db;
    $display_sidebar = $foreverwood_options_db['foreverwood_display_sidebar']; 
		if ($display_sidebar == 'Hide') { ?>
		<?php _e('.single .container #main-content, .page .container #main-content, .error404 .container #main-content { width: 100%; }', 'foreverwood'); ?>
<?php } 
}

// Display Sidebar on Archives
function foreverwood_display_sidebar_archives() {
global $foreverwood_options_db;
    $display_sidebar_archives = $foreverwood_options_db['foreverwood_display_sidebar_archives']; 
		if ($display_sidebar_archives == 'Hide') { ?>
		<?php _e('.blog .container #main-content, .archive .container #main-content, .search .container #main-content { width: 100%; } .archive #sidebar { display: none; }', 'foreverwood'); ?>
<?php } 
}

// Header Layout - Wide
function foreverwood_get_header_layout() {
global $foreverwood_options_db;
    $header_layout = $foreverwood_options_db['foreverwood_header_layout']; 
		if ($header_layout == 'Wide') { ?>
		<?php _e('#wrapper-header .site-title { text-align: left; } #wrapper-header .header-logo { margin-left: 0; } .rtl #wrapper-header .site-title { text-align: right; } @media screen and (max-width: 990px) { html #wrapper #wrapper-header .header-content .site-title, html #wrapper #wrapper-header .header-content .header-logo { margin-bottom: 0 !important; } }', 'foreverwood'); ?>
<?php } 
}

// Title Box width
function foreverwood_get_page_title_width() {
global $foreverwood_options_db;
    $page_title_width = $foreverwood_options_db['foreverwood_page_title_width']; 
    $header_layout = $foreverwood_options_db['foreverwood_header_layout'];
		if ($page_title_width != '' && $header_layout == 'Wide') { ?>
		<?php _e('#wrapper #wrapper-header .title-box { width: ', 'foreverwood'); ?><?php echo $page_title_width ?><?php _e(';}', 'foreverwood'); ?>
<?php } 
}

// Menu Box width
function foreverwood_get_header_menu_width() {
global $foreverwood_options_db;
    $header_menu_width = $foreverwood_options_db['foreverwood_header_menu_width']; 
    $header_layout = $foreverwood_options_db['foreverwood_header_layout'];
		if ($header_menu_width != '' && $header_layout == 'Wide') { ?>
		<?php _e('#wrapper #wrapper-header .menu-box { width: ', 'foreverwood'); ?><?php echo $header_menu_width ?><?php _e(';}', 'foreverwood'); ?>
<?php } 
}

// Display Meta Box - post entries styling
function foreverwood_display_meta_post_entry() {
global $foreverwood_options_db;
    $display_meta_post_entry = $foreverwood_options_db['foreverwood_display_meta_post_entry']; 
		if ($display_meta_post_entry == 'Hide') { ?>
		<?php _e('body #main-content .post-entry .post-entry-headline { margin-bottom: 10px; }', 'foreverwood'); ?>
<?php } 
}

// FONTS
// Body font
function foreverwood_get_body_font() {
global $foreverwood_options_db;
    $bodyfont = $foreverwood_options_db['foreverwood_body_google_fonts'];
    if ($bodyfont != 'default' && $bodyfont != '') { ?>
    <?php _e('html body, #wrapper blockquote, #wrapper q, #wrapper .container #comments .comment, #wrapper .container #comments .comment time, #wrapper .container #commentform .form-allowed-tags, #wrapper .container #commentform p, #wrapper input, #wrapper button, #wrapper textarea, #wrapper select, #wrapper #main-content .post-meta { font-family: "', 'foreverwood'); ?><?php echo $bodyfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// Site title font
function foreverwood_get_headings_google_fonts() {
global $foreverwood_options_db;
    $headingfont = $foreverwood_options_db['foreverwood_headings_google_fonts']; 
		if ($headingfont != 'default' && $headingfont != '') { ?>
		<?php _e('#wrapper #wrapper-header .site-title { font-family: "', 'foreverwood'); ?><?php echo $headingfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// Page/post headlines font
function foreverwood_get_headlines_font() {
global $foreverwood_options_db;
    $headlinefont = $foreverwood_options_db['foreverwood_headline_google_fonts'];
    if ($headlinefont != 'default' && $headlinefont != '') { ?>
		<?php _e('#wrapper h1, #wrapper h2, #wrapper h3, #wrapper h4, #wrapper h5, #wrapper h6, #wrapper .container .navigation .section-heading, #wrapper #comments .entry-headline, #wrapper .header-image .header-image-text .header-image-headline { font-family: "', 'foreverwood'); ?><?php echo $headlinefont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// Post entry font
function foreverwood_get_postentry_font() {
global $foreverwood_options_db;
    $postentryfont = $foreverwood_options_db['foreverwood_postentry_google_fonts']; 
		if ($postentryfont != 'default' && $postentryfont != '') { ?>
		<?php _e('#wrapper #main-content .post-entry .post-entry-headline, #wrapper #main-content .grid-entry .grid-entry-headline, #wrapper #main-content .slides li a, #wrapper #main-content .home-list-posts ul li a { font-family: "', 'foreverwood'); ?><?php echo $postentryfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// Sidebar and footer widget headlines font
function foreverwood_get_sidebar_widget_font() {
global $foreverwood_options_db;
    $sidebarfont = $foreverwood_options_db['foreverwood_sidebar_google_fonts'];
    if ($sidebarfont != 'default' && $sidebarfont != '') { ?>
		<?php _e('#wrapper .container #sidebar .sidebar-widget .sidebar-headline, #wrapper #wrapper-footer #footer .footer-widget .footer-headline { font-family: "', 'foreverwood'); ?><?php echo $sidebarfont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// Main Header menu font
function foreverwood_get_menu_font() {
global $foreverwood_options_db;
    $menufont = $foreverwood_options_db['foreverwood_menu_google_fonts']; 
		if ($menufont != 'default' && $menufont != '') { ?>
		<?php _e('#wrapper #wrapper-header .menu-box ul li a, #wrapper #wrapper-header .menu-panel ul li a { font-family: "', 'foreverwood'); ?><?php echo $menufont ?><?php _e('", Arial, Helvetica, sans-serif; }', 'foreverwood'); ?>
<?php } 
}

// User defined CSS.
function foreverwood_get_own_css() {
global $foreverwood_options_db;
    $own_css = $foreverwood_options_db['foreverwood_own_css']; 
		if ($own_css != '') { ?>
		<?php echo esc_attr($own_css); ?>
<?php } 
}

// Display custom CSS.
function foreverwood_custom_styles() { ?>
<?php echo ("<style type='text/css'>"); ?>
<?php foreverwood_get_own_css(); ?>
<?php foreverwood_display_sidebar(); ?>
<?php foreverwood_display_sidebar_archives(); ?>
<?php foreverwood_get_header_layout(); ?>
<?php foreverwood_get_page_title_width(); ?>
<?php foreverwood_get_header_menu_width(); ?>
<?php foreverwood_display_meta_post_entry(); ?>
<?php foreverwood_get_body_font(); ?>
<?php foreverwood_get_headings_google_fonts(); ?>
<?php foreverwood_get_headlines_font(); ?>
<?php foreverwood_get_postentry_font(); ?>
<?php foreverwood_get_sidebar_widget_font(); ?>
<?php foreverwood_get_menu_font(); ?>
<?php echo ("</style>"); ?>
<?php
} 
add_action('wp_enqueue_scripts', 'foreverwood_custom_styles');	?>