<?php

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_RAVAIO'					=> 'Ravaio configuration',

	'ACP_RAVAIO_GENERAL'			=> 'General',
	'ACP_RAVAIO_COLOURS'			=> 'Colours',
	'ACP_RAVAIO_HEADER'				=> 'Header',
	'ACP_RAVAIO_HEADER_MENU'		=> 'Header menu',
	'ACP_RAVAIO_SIDEBAR'			=> 'Sidebar',
	'ACP_RAVAIO_FOOTER'				=> 'Footer',
	'ACP_RAVAIO_FOOTER_BLOCKS'		=> 'Footer blocks',
	'ACP_RAVAIO_FOOTER_MENU'		=> 'Footer menu',

	'ACP_RAVAIO_GENERAL_EXP'		=> 'Generic style settings.',
	'ACP_RAVAIO_COLOURS_EXP'		=> 'Style colours and background images settings. Please purge phpBB cache if you don\'t see colour picker after clicking on any colour input',
	'ACP_RAVAIO_HEADER_EXP'			=> 'Headers settings.',
	'ACP_RAVAIO_HEADER_MENU_EXP'	=> 'Header menu items.',
	'ACP_RAVAIO_SIDEBAR_EXP'		=> 'Sidebar items.',
	'ACP_RAVAIO_FOOTER_EXP'			=> 'Footer settings.',
	'ACP_RAVAIO_FOOTER_BLOCKS_EXP'	=> 'Footer custom blocks. Up to 5 blocks when \'Statistics position\' is other than \'Default\' and up to 2 blocks when \'Statistics position\' is \'Default\'.',
	'ACP_RAVAIO_FOOTER_MENU_EXP'	=> 'Footer menu items.',

	'ACP_RAVAIO_SUBMIT'				=> 'Submit changes',

	/* General - Begin */
	'ACP_RA_LAYOUT'					=> 'Layout',
	'ACP_RA_LAYOUT_EXP'				=> 'Choose wide or boxed layout.',
	'ACP_RA_LAYOUT_WIDE'			=> 'Wide',
	'ACP_RA_LAYOUT_BOXED'			=> 'Boxed',

	'ACP_RA_WIDTH'					=> 'Width',
	'ACP_RA_WIDTH_EXP'				=> 'Max width of your forum. Percentage values also allowed.',

	'ACP_RA_STAT_POS'				=> 'Statistics position',
	'ACP_RA_STAT_POS_EXP'			=> 'Choose where do you want to display board statistics: in site footer, sidebar or in boxes under above footer.',
	'ACP_RA_STAT_POS_DEFAULT'		=> 'Default',
	'ACP_RA_STAT_POS_BOXED'			=> 'Boxed',
	'ACP_RA_STAT_POS_SIDEBAR'		=> 'Sidebar',

	'ACP_RA_AV_STYLE'				=> 'Avatars style',
	'ACP_RA_AV_STYLE_EXP'			=> 'Round avatars, square avatars with round corners or avatars without any styling.',
	'ACP_RA_AV_STYLE_ROUND'			=> 'Round',
	'ACP_RA_AV_STYLE_SQUARE'		=> 'Square',
	'ACP_RA_AV_STYLE_RECTANGLE'		=> 'Rectangle',

	'ACP_RA_POSTER_STYLE'			=> 'Poster informations style',
	'ACP_RA_POSTER_STYLE_EXP'		=> 'Display poster informations in dropdown or under his avatar. Does not apply to pm author column.',
	'ACP_RA_POSTER_STYLE_DROP'		=> 'Dropdown',
	'ACP_RA_POSTER_STYLE_UNDER'		=> 'Under avatar',

	'ACP_RA_POSTER_COLUMN'			=> 'Separate poster column',
	'ACP_RA_POSTER_COLUMN_EXP'		=> 'Display poster column outside post block.',

	'ACP_RA_POSTER_WIDTH'			=> 'Poster width',
	'ACP_RA_POSTER_WIDTH_EXP'		=> 'Set how wide poster column is. Does not apply to pm author column.',

	'ACP_RA_BACK_TO_TOP'			=> 'Display back to top floating button',
	'ACP_RA_BACK_TO_TOP_EXP'		=> 'This button will be visible after scrolling down your page.',

	'ACP_RA_CUSTOM_CSS'				=> 'Set your custom CSS rules here',

	'ACP_RAVAIO_LOG_GENERAL'		=> 'General style configuration updated successfully.',
	'ACP_RAVAIO_LOG_GENERAL_EXP'	=> '<strong>Altered general style configuration</strong>',
	/* General - End */

	/* Colours - Begin */
	'ACP_RA_BG_COLOURS'				=> 'Background colours',
	
	'ACP_RA_HEAD_INDEX_BG'			=> 'Header background on front page',
	'ACP_RA_HEAD_INDEX_EXP'			=> 'This will take effect only if standard or small site descriptin option is enabled.',

	'ACP_RA_DARK'					=> 'Dark preset',
	'ACP_RA_DARK_EXP'				=> 'Control over tables and menus preset usefull for sites with dark backgrounds.',

	'ACP_RA_HEAD_OTHER_BG'			=> 'Header background on pages other than front page',
	'ACP_RA_HEAD_OTHER_EXP'			=> 'Set it to transparent if you want to see header background image.',

	'ACP_RA_HEAD_BG'				=> 'Header background',
	'ACP_RA_HEAD_EXP'				=> 'This background is used by sticky header.',

	'ACP_RA_SUB_HEAD_BG'			=> 'Subheader background',
	'ACP_RA_SUB_HEAD_BG_EXP'		=> 'Set it to transparent if you want to see header background image.',

	'ACP_RA_M_ACCENT'				=> 'Main background accent',
	'ACP_RA_M_ACCENT_B'				=> 'Main background accent darken',
	'ACP_RA_S_ACCENT'				=> 'Secondary background accent',
	'ACP_RA_S_ACCENT_B'				=> 'Secondary background accent darken',

	'ACP_RA_BG_F'					=> 'First level background',
	'ACP_RA_BG_S'					=> 'Second level background',

	'ACP_RA_TXT_COLOURS'			=> 'Text colours',

	'ACP_RA_T'						=> 'Text color',
	'ACP_RA_T_ACCENT'				=> 'Text color accent',
	'ACP_RA_T_ACCENT_B'				=> 'Text color accent darken',

	'ACP_RAVAIO_LOG_COLOURS'		=> 'Style colours configuration updated successfully.',
	'ACP_RAVAIO_LOG_COLOURS_EXP'	=> '<strong>Altered style colours configuration</strong>',
	/* Colours - End */

	/* Header - Begin */
	'ACP_RA_LOGO_TYPE'					=> 'Logo type',
	'ACP_RA_LOGO_TEXT'					=> 'Text logo',
	'ACP_RA_LOGO_TEXT_EXP'				=> 'Set your logo text - this will take effect only if text logo is enabled.',
	'ACP_RA_SITE_DESC'					=> 'Site description on front page',
	'ACP_RA_SITE_DESC_EXP'				=> 'Standard and small site description will allow you to set separate header background on front page.',
	'ACP_RA_SITE_DESC_STANDARD'			=> 'Standard',
	'ACP_RA_SITE_DESC_SMALL'			=> 'Small',
	'ACP_RA_SITE_DESC_TEXT_ALIGN'		=> 'Site description text align',
	'ACP_RA_SITE_DESC_REF_POINT'		=> 'Align site description from its center',
	'ACP_RA_SITE_DESC_REF_POINT_EXP'	=> 'This option allows you to place site description in the center.',
	'ACP_RA_SITE_DESC_POSITION'			=> 'Site description position',
	'ACP_RA_SITE_DESC_POSITION_EXP'		=> 'Set site description distance from each edge of header box.<br>You can leave some fields blank to achieve desired effect.',
	'ACP_RA_HEAD_INDEX_TEXT'		=> 'Display head text on index page',
	'ACP_RA_HEAD_INDEX_TEXT_EXP'	=> 'Show your site name and site description over your head index image.',
	'ACP_RA_HEAD_TYPE'				=> 'Header type',

	'ACP_RA_HEAD_INDEX_IMG'			=> 'Header image on front page',
	'ACP_RA_HEAD_INDEX_IMG_EXP'		=> 'Image name with extension from ravaio/theme/images directory. You can leave it blank.',

	'ACP_RA_HEAD_OTHER_IMG'			=> 'Header image on pages other than front page',
	'ACP_RA_HEAD_OTHER_IMG_EXP'		=> 'Set \'Header background on pages other than front page\' and \'Subheader background\' to transparent to see this image.',

	'ACP_RAVAIO_LOG_HEADER'			=> 'Style header configuration updated successfully.',
	'ACP_RAVAIO_LOG_HEADER_EXP'		=> '<strong>Altered style header configuration</strong>',
	/* Header - End */

	/* Header menu - Begin */
	'ACP_RA_HEADER_MENU_ENABLE'			=> 'Enable header menu',

	'ACP_RA_HEADER_MENU_ITEM'			=> 'Header menu item',
	'ACP_RA_HEADER_MENU_NAME'			=> 'Header menu item title',
	'ACP_RA_HEADER_MENU_NAME_EXP'		=> 'You can use <a href="https://fortawesome.github.io/Font-Awesome/icons">Font Awesome Icon</a> as a title - just paste Font Awesome Icon code here.<br>If you want to have visible text next to the icon ony in responsive view please follow this example:<br>&lt;i class=&quot;fa fa-shopping-basket&quot;&gt;&lt;/i&gt;&lt;span class=&quot;re-md&quot;&gt;Responsive text&lt;span&gt;',

	'ACP_RA_HEADER_MENU_URL'			=> 'Header menu item URL',
	'ACP_RA_HEADER_MENU_URL_EXP'		=> 'You can use links without protocols here.',

	'ACP_RA_HEADER_MENU_CONTENT'		=> 'Header menu item additional content',
	'ACP_RA_HEADER_MENU_CONTENT_EXP'	=> 'This field is used for custom dropdown boxes. Leave it blank if you don\'t want to use dropdown menu.',

	'ACP_RA_HEADER_MENU_MEGA'			=> 'Enable mega menu',

	'ACP_RAVAIO_LOG_HEADER_MENU'		=> 'Style header menu configuration updated successfully.',
	'ACP_RAVAIO_LOG_HEADER_MENU_EXP'	=> '<strong>Altered style header menu configuration</strong>',
	/* Header menu - End */

	/* Sidebar - Begin */
	'ACP_RA_SIDEBAR'					=> 'Enable sidebar',
	'ACP_RA_SIDEBAR_INDEX'				=> 'Display sidebar on front page',
	'ACP_RA_SIDEBAR_CAT'				=> 'Display sidebar on forum category page',
	'ACP_RA_SIDEBAR_TOPIC'				=> 'Dssplay sidebar on topic page',

	'ACP_RA_SIDEBAR_BLOCK_NAME'			=> 'Sidebar item title',
	'ACP_RA_SIDEBAR_BLOCK_NAME_EXP'		=> 'You can use <a href="https://fortawesome.github.io/Font-Awesome/icons">Font Awesome Icon</a> as a title - just paste Font Awesome Icon code here.',

	'ACP_RA_SIDEBAR_BLOCK_CONTENT'		=> 'Sidebar item content',
	'ACP_RA_SIDEBAR_BLOCK_CONTENT_EXP'	=> 'Any HTML code.',

	'ACP_RAVAIO_LOG_SIDEBAR'			=> 'Style sidebar configuration updated successfully.',
	'ACP_RAVAIO_LOG_SIDEBAR_EXP'		=> '<strong>Altered style sidebar configuration</strong>',
	/* Sidebar - End */

	/* Footer - Begin */
	'ACP_RA_FOOT_TYPE'					=> 'Footer type',

	'ACP_RA_RC_POSTS'					=> 'Recent posts in footer',
	'ACP_RA_RC_POSTS_EXP'				=> 'Your board need to have at least 4 posts if you want to display recent posts in footer.',

	'ACP_RA_RC_POSTS_NUM'				=> 'Display recent posts it two rows',

	'ACP_RA_FOOT_TEXT'					=> 'Custom text below footer menu',
	'ACP_RA_FOOT_TEXT_EXP'				=> 'Place your thext in &lt;span class=&quot;rside&quot;&gt;&lt;/span&gt; if you want to have it on right side.',

	'ACP_RAVAIO_LOG_FOOTER'				=> 'Style footer configuration updated successfully.',
	'ACP_RAVAIO_LOG_FOOTER_EXP'			=> '<strong>Altered style footer configuration</strong>',
	/* Footer - End */

	/* Footer blocks - Begin */
	'ACP_RA_FOOTER_BLOCKS_ENABLE'		=> 'Enable footer blocks',

	'ACP_RA_FOOTER_BLOCKS_ITEM'			=> 'Footer block',
	'ACP_RA_FOOTER_BLOCKS_NAME'			=> 'Footer block title',
	'ACP_RA_FOOTER_BLOCKS_NAME_EXP'		=> 'You can use <a href="https://fortawesome.github.io/Font-Awesome/icons">Font Awesome Icon</a> as a title - just paste Font Awesome Icon code here.',

	'ACP_RA_FOOTER_BLOCKS_URL'			=> 'Footer block URL',
	'ACP_RA_FOOTER_BLOCKS_URL_EXP'		=> 'You can use links without protocols here. You can leave it blank',

	'ACP_RA_FOOTER_BLOCKS_CONTENT'		=> 'Footer block content',
	'ACP_RA_FOOTER_BLOCKS_CONTENT_EXP'	=> 'Any HTML code.',

	'ACP_RAVAIO_LOG_FOOTER_BLOCKS'		=> 'Style footer blocks configuration updated successfully.',
	'ACP_RAVAIO_LOG_FOOTER_BLOCKS_EXP'	=> '<strong>Altered style footer blocks configuration</strong>',
	/* Footer blocks - End */

	/* Footer menu - Begin */
	'ACP_RA_FOOTER_MENU_ENABLE'			=> 'Enable footer menu',

	'ACP_RA_FOOTER_MENU_ITEM'			=> 'Footer menu item',
	'ACP_RA_FOOTER_MENU_NAME'			=> 'Footer menu item title',
	'ACP_RA_FOOTER_MENU_NAME_EXP'		=> 'You can use <a href="https://fortawesome.github.io/Font-Awesome/icons">Font Awesome Icon</a> as a title - just paste Font Awesome Icon code here.',

	'ACP_RA_FOOTER_MENU_URL'			=> 'Footer menu item URL',
	'ACP_RA_FOOTER_MENU_URL_EXP'		=> 'You can use links without protocols here.',

	'ACP_RA_FOOTER_MENU_ALIGN'			=> 'Footer menu item align',
	'ACP_RA_FOOTER_MENU_ALIGN_EXP'		=> 'Select on what side do you want to display your item.',
	'ACP_RA_FOOTER_MENU_ALIGN_LEFT'		=> 'Left',
	'ACP_RA_FOOTER_MENU_ALIGN_RIGHT'	=> 'Right',

	'ACP_RAVAIO_LOG_FOOTER_MENU'		=> 'Style footer menu configuration updated successfully.',
	'ACP_RAVAIO_LOG_FOOTER_MENU_EXP'	=> '<strong>Altered style footer menu configuration</strong>'
	/* Footer menu - End */
));
