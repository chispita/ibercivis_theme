<?php
if(!is_dir(THEMEUPLOAD))
{
	mkdir(THEMEUPLOAD);
}

$wpdb->query("INSERT INTO `wp_options` VALUES(1596, 0, 'pp_contact_info_text', 'You can add informations about yourself, service, pricing here using Theme admin.<br/><br/>@ipeerapong<br/>085.1554023', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1597, 0, 'pp_enable_right_click', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1598, 0, 'pp_right_click_text', 'You can enable or disable image protection via admin panel :)', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1600, 0, 'pp_font', '', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1601, 0, 'pp_h1_size', '40', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1602, 0, 'pp_h2_size', '32', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1603, 0, 'pp_h3_size', '26', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1604, 0, 'pp_h4_size', '24', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1605, 0, 'pp_h5_size', '22', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1606, 0, 'pp_h6_size', '18', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1607, 0, 'pp_menu_font_size', '20', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1608, 0, 'pp_submenu_font_size', '16', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1609, 0, 'pp_active_skin_color', '#f9d20b', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1610, 0, 'pp_font_color', '#888888', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1611, 0, 'pp_link_color', '#000000', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1612, 0, 'pp_hover_link_color', '#f9d20b', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1613, 0, 'pp_h1_font_color', '#222222', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1614, 0, 'pp_button_bg_color', '#000000', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1615, 0, 'pp_button_font_color', '#ffffff', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1616, 0, 'pp_button_border_color', '#111111', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1617, 0, 'pp_menu_font_color', '#000000', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1618, 0, 'pp_active_menu_font_color', '#ffffff', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1619, 0, 'pp_menu_header_font_color', '#ffffff', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1620, 0, 'pp_homepage_music_play', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1621, 0, 'pp_homepage_style', 'kenburns', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1623, 0, 'pp_homepage_slideshow_timer', '4', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1624, 0, 'pp_homepage_slideshow_trans', '1', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1625, 0, 'pp_enable_fit_image', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1626, 0, 'pp_portfolio_slideshow_timer', '10', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1627, 0, 'pp_portfolio_slideshow_trans', '1', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1628, 0, 'pp_social_sharing', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1631, 0, 'pp_contact_form', 's:8:\"s:1:\"1\";\";', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1632, 0, 'pp_contact_enable_captcha', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1644, 0, 'pp_footer_social', 'true', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1645, 0, 'pp_font_family', '', 'yes');");
$wpdb->query("INSERT INTO `wp_options` VALUES(1646, 0, 'pp_contact_form_sort_data', 's:54:\"a:4:{i:0;s:1:\"1\";i:1;s:1:\"5\";i:2;s:1:\"2\";i:3;s:1:\"3\";}\";', 'yes');");


?>