<?php
/**
 * Kinder skin file for theme.
 */


//------------------------------------------------------------------------------
// Skin's fonts
//------------------------------------------------------------------------------

// Add skin fonts in the used fonts list
add_filter('theme_skin_use_fonts', 'theme_skin_use_fonts_kinder');
function theme_skin_use_fonts_kinder($theme_fonts) {
	$theme_fonts['Bree Serif'] = 1;
	$theme_fonts['Roboto Slab'] = 1;
	return $theme_fonts;
}

// Add skin fonts in the main fonts list
add_filter('theme_skin_list_fonts', 'theme_skin_list_fonts_kinder');
function theme_skin_list_fonts_kinder($list) {
	//$list['Advent Pro'] = array('family'=>'sans-serif', 'link'=>'Advent+Pro:100,100italic,300,300italic,400,400italic,500,500italic,700,700italic,900,900italic&subset=latin,latin-ext,cyrillic,cyrillic-ext');
	if (!isset($list['Bree Serif']))	$list['Bree Serif'] = array('family'=>'serif',);
	if (!isset($list['Roboto Slab']))	$list['Roboto Slab'] = array('family'=>'sans-serif');
	return $list;
}


//------------------------------------------------------------------------------
// Skin's stylesheets
//------------------------------------------------------------------------------

// Add skin stylesheets
add_action('theme_skin_add_stylesheets', 'theme_skin_add_stylesheets_kinder');
function theme_skin_add_stylesheets_kinder() {
	themerex_enqueue_style( 'theme-skin', themerex_get_file_url('/skins/kinder/kinder.css'), array('main-style'), null );
}

// Add skin responsive styles
add_action('theme_skin_add_responsive', 'theme_skin_add_responsive_kinder');
function theme_skin_add_responsive_kinder() {
	if (file_exists(themerex_get_file_dir('/skins/kinder/kinder-responsive.css'))) 
		themerex_enqueue_style( 'theme-skin-responsive', themerex_get_file_url('/skins/kinder/kinder-responsive.css'), array('theme-skin'), null );
}

// Add skin responsive inline styles
add_filter('theme_skin_add_responsive_inline', 'theme_skin_add_responsive_inline_kinder');
function theme_skin_add_responsive_inline_kinder($custom_style) {
	return $custom_style;	
}


//------------------------------------------------------------------------------
// Skin's scripts
//------------------------------------------------------------------------------

// Add skin scripts
add_action('theme_skin_add_scripts', 'theme_skin_add_scripts_kinder');
function theme_skin_add_scripts_kinder() {
	if (file_exists(themerex_get_file_dir('/skins/kinder/kinder.js')))
		themerex_enqueue_script( 'theme-skin-script', themerex_get_file_url('/skins/kinder/kinder.js'), array('main-style'), null );
}

// Add skin scripts inline
add_action('theme_skin_add_scripts_inline', 'theme_skin_add_scripts_inline_kinder');
function theme_skin_add_scripts_inline_kinder() {
	?>
	if (THEMEREX_theme_font=='') THEMEREX_theme_font = 'Roboto Slab';

	// Add skin custom colors in custom styles
	function theme_skin_set_theme_color(custom_style, clr) {
		custom_style += 
			'.topWrap .topMenuStyleLine ul#mainmenu .menu-panel .item_placeholder .item_title a:hover,.topWrap .topMenuStyleLine ul#mainmenu .menu-panel.thumb .item_placeholder .item_title a:hover'
			+' { color: '+clr+' !important; }'
			+'.sliderHomeBullets .order a,.usermenu_area,.twitBlock,.twitBlockWrap,.twitBlock .sc_slider .flex-direction-nav li'
			+' { background-color: '+clr+'; }'
			+'.topWrap .openRightMenu:hover,.topWrap .search:not(.searchOpen):hover,.sliderHomeBullets .order a'
			+' {border-color: '+clr+'; }';
		return custom_style;
	}

	// Add skin's main menu (top panel) back color in the custom styles
	function theme_skin_set_menu_bgcolor(custom_style, clr) {
		return custom_style;
	}

	// Add skin top panel colors in custom styles
	function theme_skin_set_menu_color(custom_style, clr) {
		custom_style += 
			'.theme_skin_kinder.responsive_menu .menuTopWrap > ul > li > a,.theme_skin_kinder.responsive_menu .menuTopWrap li.menu-item-has-children:before'
			+' { color: '+clr+'; }';
		return custom_style;
	}

	// Add skin's user menu (user panel) back color in the custom styles
	function theme_skin_set_user_menu_bgcolor(custom_style, clr) {
		return custom_style;
	}

	// Add skin's user menu (user panel) fore colors in the custom styles
	function theme_skin_set_user_menu_color(custom_style, clr) {
		return custom_style;
	}
	<?php
}


//------------------------------------------------------------------------------
// Get/Set skin's main (accent) theme color
//------------------------------------------------------------------------------

// Return main theme color (if not set in the theme options)
add_filter('theme_skin_get_theme_color', 'theme_skin_get_theme_color_kinder', 10, 1);
function theme_skin_get_theme_color_kinder($clr) {
	return empty($clr) ? '#069eed' : $clr;
}

// Return main theme bg color
add_filter('theme_skin_get_theme_bgcolor', 'theme_skin_get_theme_bgcolor_kinder', 10, 1);
function theme_skin_get_theme_bgcolor_kinder($clr) {
	return '#ffffff';
}

// Add skin's specific theme colors in the custom styles
add_filter('theme_skin_set_theme_color', 'theme_skin_set_theme_color_kinder', 10, 2);
function theme_skin_set_theme_color_kinder($custom_style, $clr) {
	$custom_style .= '
		.topWrap .topMenuStyleLine ul#mainmenu .menu-panel .item_placeholder .item_title a:hover,
		.topWrap .topMenuStyleLine ul#mainmenu .menu-panel.thumb .item_placeholder .item_title a:hover
		{ color:'.$clr.' !important; }
		
		.sliderHomeBullets .order a,
		.usermenu_area,
		.twitBlock,
		.twitBlockWrap
		{ background-color:'.$clr.'; }
		
		.topWrap .openRightMenu:hover,
		.topWrap .search:not(.searchOpen):hover,
		.sliderHomeBullets .order a
		{ border-color:'.$clr.'; }
		';
	return $custom_style;
}


//------------------------------------------------------------------------------
// Get/Set skin's main menu (top panel) color
//------------------------------------------------------------------------------

// Return skin's main menu (top panel) background color (if not set in the theme options)
add_filter('theme_skin_get_menu_bgcolor', 'theme_skin_get_menu_bgcolor_kinder', 10, 1);
function theme_skin_get_menu_bgcolor_kinder($clr) {
	return empty($clr) ? '#ffffff' : $clr;
}

// Add skin's main menu (top panel) background color in the custom styles
add_filter('theme_skin_set_menu_bgcolor', 'theme_skin_set_menu_bgcolor_kinder', 10, 2);
function theme_skin_set_menu_bgcolor_kinder($custom_style, $clr) {
	return $custom_style;
}

// Add skin's main menu (top panel) fore colors in custom styles
add_filter('theme_skin_set_menu_color', 'theme_skin_set_menu_color_kinder', 10, 2);
function theme_skin_set_menu_color_kinder($custom_style, $clr) {
	$custom_style .= '
		.theme_skin_kinder.responsive_menu .menuTopWrap > ul > li > a,.theme_skin_kinder.responsive_menu .menuTopWrap li.menu-item-has-children:before
		{ color: '.$clr.';	}
		';
	return $custom_style;
}


//------------------------------------------------------------------------------
// Get/Set skin's user menu (user panel) color
//------------------------------------------------------------------------------

// Return skin's user menu color (if not set in the theme options)
add_filter('theme_skin_get_user_menu_bgcolor', 'theme_skin_get_user_menu_bgcolor_kinder', 10, 1);
function theme_skin_get_user_menu_bgcolor_kinder($clr) {
	return empty($clr) ? '#069eed' : $clr;
}

// Add skin's user menu (user panel) background color in the custom styles
add_filter('theme_skin_set_user_menu_bgcolor', 'theme_skin_set_user_menu_bgcolor_kinder', 10, 2);
function theme_skin_set_user_menu_bgcolor_kinder($custom_style, $clr) {
	return $custom_style;
}

// Add skin's user menu (user panel) fore colors in custom styles
add_filter('theme_skin_set_user_menu_color', 'theme_skin_set_user_menu_color_kinder', 10, 2);
function theme_skin_set_user_menu_color_kinder($custom_style, $clr) {
	return $custom_style;
}
?>