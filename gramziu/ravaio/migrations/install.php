<?php

namespace gramziu\ravaio\migrations;

class install extends \phpbb\db\migration\migration
{
	public function update_schema()
	{
		return array(
			'add_tables' => array(
				$this->table_prefix . 'ra_header_menu'		=> array(
					'COLUMNS'		=> array(
						'name'		=> array('VCHAR', ''),
						'url'		=> array('VCHAR', ''),
						'content'	=> array('TEXT', ''),
						'mega'		=> array('UINT:1', 0),
						'position'	=> array('UINT:255', null, 'auto_increment'),
					),
					'PRIMARY_KEY'	=> 'position'
				),

				$this->table_prefix . 'ra_sidebar'			=> array(
					'COLUMNS'		=> array(
						'name'		=> array('VCHAR', ''),
						'url'		=> array('VCHAR', ''),
						'content'	=> array('TEXT', ''),
						'position'	=> array('UINT:255', null, 'auto_increment'),
					),
					'PRIMARY_KEY'	=> 'position'
				),

				$this->table_prefix . 'ra_footer_blocks'	=> array(
					'COLUMNS'		=> array(
						'name'		=> array('VCHAR', ''),
						'url'		=> array('VCHAR', ''),
						'content'	=> array('TEXT', ''),
						'position'	=> array('UINT:255', null, 'auto_increment'),
					),
					'PRIMARY_KEY'	=> 'position'
				),

				$this->table_prefix . 'ra_footer_menu'		=> array(
					'COLUMNS'		=> array(
						'name'		=> array('VCHAR', ''),
						'url'		=> array('VCHAR', ''),
						'align'		=> array('UINT:1', 0),
						'position'	=> array('UINT:255', null, 'auto_increment'),
					),
					'PRIMARY_KEY'	=> 'position'
				)
			),

			'add_columns' => array(
				$this->table_prefix . 'users' => array(
					'ra_variant'	=> array('UINT:1', 9),
				),
			)
		);
	}

	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'insert_sample_data'))),

			array('config.add', array('ra_enable', 1)),

			array('config.add', array('ra_layout', 1)),
			array('config.add', array('ra_width', '1200px')),
			array('config.add', array('ra_stat_pos', 0)),
			array('config.add', array('ra_av_style', 0)),
			array('config.add', array('ra_poster_style', 0)),
			array('config.add', array('ra_poster_column', 1)),
			array('config.add', array('ra_poster_width', '98px')),
			array('config.add', array('ra_back_to_top', '1')),

			array('config_text.add', array('ra_custom_css', '#theme-variant-0:before {
	background-color: #EBEBEB;
}

#theme-variant-1:before {
	background-color: #455A64;
}

#theme-variant-2:before {
	background-color: #2F2F2F;
}')),

			array('config.add', array('ra_color_variants', 'a:3:{i:0;s:4:"Main";i:1;s:9:"Secondary";i:2;s:8:"Tertiary";}')),

			array('config.add', array('ra_main_accent', 'a:3:{i:0;s:7:"#1976D2";i:1;s:7:"#1976D2";i:2;s:7:"#1976D2";}')),

			array('config.add', array('ra_secondary_accent', 'a:3:{i:0;s:7:"#455A64";i:1;s:7:"#374C56";i:2;s:7:"#444444";}')),

			array('config.add', array('ra_main_text', 'a:3:{i:0;s:7:"#FAFAFA";i:1;s:7:"#FAFAFA";i:2;s:7:"#FAFAFA";}')),

			array('config.add', array('ra_secondary_text', 'a:3:{i:0;s:7:"#5A5A5A";i:1;s:7:"#CCCCCC";i:2;s:7:"#CCCCCC";}')),

			array('config.add', array('ra_site_background', 'a:3:{i:0;s:7:"#F8F8F8";i:1;s:7:"#263238";i:2;s:7:"#2A2A2A";}')),

			array('config.add', array('ra_main_background', 'a:3:{i:0;s:7:"#FFFFFF";i:1;s:7:"#2E3A40";i:2;s:7:"#2F2F2F";}')),

			array('config.add', array('ra_main_border', 'a:3:{i:0;s:7:"#EAEAEA";i:1;s:7:"#222D32";i:2;s:7:"#222222";}')),

			array('config.add', array('ra_head_index_bg', 'a:3:{i:0;s:11:"transparent";i:1;s:11:"transparent";i:2;s:11:"transparent";}')),
			array('config.add', array('ra_head_other_bg', 'a:3:{i:0;s:7:"#1976D2";i:1;s:7:"#1976D2";i:2;s:7:"#1976D2";}')),
			array('config.add', array('ra_head_index_sticky_bg', 'a:3:{i:0;s:7:"#1976D2";i:1;s:7:"#1976D2";i:2;s:7:"#1976D2";}')),
			array('config.add', array('ra_head_other_sticky_bg', 'a:3:{i:0;s:7:"#1976D2";i:1;s:7:"#1976D2";i:2;s:7:"#1976D2";}')),

			array('config.add', array('ra_head_index_img', 'a:3:{i:0;s:23:"ra_head_index_img_0.png";i:1;s:23:"ra_head_index_img_1.png";i:2;s:23:"ra_head_index_img_2.png";}')),
			array('config.add', array('ra_head_other_img', 'a:3:{i:0;s:23:"ra_head_other_img_0.png";i:1;s:23:"ra_head_other_img_1.png";i:2;s:23:"ra_head_other_img_2.png";}')),

			array('config.add', array('ra_s_head_index_img', 'a:3:{i:0;i:1;i:1;i:1;i:2;i:1;}')),
			array('config.add', array('ra_s_head_other_img', 'a:3:{i:0;i:1;i:1;i:1;i:2;i:1;}')),

			array('config.add', array('ra_main_background_darken', 'a:3:{i:0;s:18:"rgb(249, 249, 249)";i:1;s:15:"rgb(41, 52, 58)";i:2;s:15:"rgb(41, 41, 41)";}')),

			array('config.add', array('ra_variant_default', 0)),
			array('config.add', array('ra_variant_enabled', 'a:3:{i:0;i:1;i:1;i:1;i:2;i:1;}')),
			array('config.add', array('ra_s_variants', 1)),

			array('config.add', array('ra_logo', 'site_logo.svg')),
			array('config.add', array('ra_logo_type', 0)),
			array('config.add', array('ra_logo_width', '26px')),
			array('config.add', array('ra_logo_height', '36px')),
			array('config.add', array('ra_logo_text', 'Your logo')),
			array('config.add', array('ra_site_desc', 1)),
			array('config.add', array('ra_site_desc_text_align', 0)),
			array('config.add', array('ra_site_desc_ref_point', 0)),
			array('config.add', array('ra_site_desc_pos_top', '50%')),
			array('config.add', array('ra_site_desc_pos_left', '50%')),
			array('config.add', array('ra_site_desc_pos_right', 'auto')),
			array('config.add', array('ra_site_desc_pos_bottom', 'auto')),
			array('config.add', array('ra_head_type', 0)),

			array('config.add', array('ra_site_desc_pos_prepared', 'top: 50%; left: 50%; right: auto; bottom: auto; text-align: center;')),

			array('config.add', array('ra_sidebar', 1)),
			array('config.add', array('ra_sidebar_index', 1)),
			array('config.add', array('ra_sidebar_cat', 1)),
			array('config.add', array('ra_sidebar_topic', 1)),

			array('config.add', array('ra_foot_type', 0)),
			array('config.add', array('ra_rc_posts', 1)),
			array('config.add', array('ra_rc_posts_num', 4)),
			array('config.add', array('ra_foot_text', 'Powered by &lt;a href=&quot;https://www.phpbb.com/&quot;&gt;phpBB&lt;/a&gt;® Forum Software © phpBB Limited&lt;span class=&quot;rside&quot;&gt;Ravaio Theme by &lt;a href=&quot;https://themeforest.net/user/Gramziu/&quot;&gt;Gramziu&lt;/a&gt;&lt;/span&gt;')),

			array('config.add', array('ra_footer_blocks', 1)),
			array('config.add', array('ra_footer_blocks_count', 2)),

			array('config.add', array('ra_head_index_text', 0)),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_RAVAIO'
			)),

			array('module.add', array(
				'acp',
				'ACP_RAVAIO',
				array(
					'module_basename'	=> '\gramziu\ravaio\acp\ravaio_module',
					'modes'				=> array(
						'general',
						'colours',
						'header',
						'header_menu',
						'sidebar',
						'footer',
						'footer_blocks',
						'footer_menu'
					)
				)
			))
		);
	}

	public function insert_sample_data()
	{
		$sample_ra_header_menu = array(
			array(
				'name'		=> 'Menu',
				'url'		=> '#',
				'content'	=> '&lt;ul class=&quot;dropdown-box&quot;&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;
			&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
			Example
		&lt;/a&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;  class=&quot;w-drop&quot;&gt;
			&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
			Example
		&lt;/a&gt;
		&lt;ul class=&quot;dropdown-box&quot;&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot;  class=&quot;w-drop&quot;&gt;
					&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
					Example
				&lt;/a&gt;
				&lt;ul class=&quot;dropdown-box&quot;&gt;
					&lt;li&gt;
						&lt;a href=&quot;#&quot;&gt;
							&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
							Example
						&lt;/a&gt;
					&lt;/li&gt;
				&lt;/ul&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot;&gt;
					&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
					Example
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot;&gt;
					&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
					Example
				&lt;/a&gt;
			&lt;/li&gt;
		&lt;/ul&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;
			&lt;i class=&quot;fa fa-tachometer&quot;&gt;&lt;/i&gt;
			Example
		&lt;/a&gt;
	&lt;/li&gt;
&lt;/ul&gt;',
				'mega'		=> 0,
				'position'	=> 1
			),
			array(
				'name'		=> '&lt;i class=&quot;fa fa-shopping-basket&quot;&gt;&lt;/i&gt;&lt;span&gt;Menu #2&lt;/span&gt;',
				'url'		=> '#',
				'content'	=> '&lt;div class=&quot;dropdown-mega&quot;&gt;
	&lt;div class=&quot;chunk-inner&quot;&gt;
		&lt;div class=&quot;chunk-25&quot;&gt;
			&lt;h6&gt;Your title&lt;/h6&gt;
			&lt;p&gt;
				Here you can see mega dropdown example!
				&lt;br&gt;&lt;br&gt;
				It can acts like a normal space and it supports site grid.
			&lt;/p&gt;
		&lt;/div&gt;
		&lt;div class=&quot;chunk-25&quot;&gt;
			&lt;h6&gt;Your title&lt;/h6&gt;
			&lt;img src=&quot;http://gramziu.pl/images/buy_it.png&quot; alt=&quot;Buy it now!&quot; style=&quot;border-radius: 2px; display: block;&quot;&gt;
		&lt;/div&gt;
		&lt;div class=&quot;chunk-25&quot;&gt;
			&lt;h6&gt;Your title&lt;/h6&gt;
			&lt;ul&gt;&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;First dropdown item&quot;&gt;First dropdown item&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;&lt;ul&gt;
			&lt;button class=&quot;button&quot;&gt;Example&lt;/button&gt;&lt;button class=&quot;button-flat&quot;&gt;Example&lt;/button&gt;&lt;button class=&quot;button-round&quot;&gt;&lt;i class=&quot;fa fa-bomb&quot;&gt;&lt;/i&gt;&lt;/button&gt;
		&lt;/div&gt;
		&lt;div class=&quot;chunk-25&quot;&gt;
			&lt;h6&gt;Your title&lt;/h6&gt;
			&lt;ul&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;First dropdown item&quot;&gt;First dropdown item&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;li&gt;
				&lt;a href=&quot;#&quot; title=&quot;Second dropdown item&quot;&gt;
					&lt;i class=&quot;fa fa-rocket&quot;&gt;&lt;/i&gt;
					Second dropdown item
				&lt;/a&gt;
			&lt;/li&gt;
			&lt;ul&gt;
		&lt;/div&gt;
	&lt;/div&gt;
	&lt;div class=&quot;chunk&quot;&gt;
		&lt;div class=&quot;info-box&quot;&gt;
			Mega Menu Info Box
		&lt;/div&gt;
	&lt;/div&gt;
&lt;/div&gt;',
				'mega'		=> 1,
				'position'	=> 2
			)
		);

		$sample_ra_sidebar = array(
			array(
				'name'		=> 'Recent topics',
 				'content'	=> '&lt;div id=&quot;sidebar-recent-topics&quot; class=&quot;loading&quot;&gt;&lt;/div&gt;',
				'position'	=> 1
			),
			array(
				'name'		=> 'Theme variants',
 				'content'	=> '&lt;form method=&quot;post&quot; id=&quot;theme-variants&quot;&gt;&lt;/form&gt;',
				'position'	=> 2
			)
		);

		$sample_ra_footer_blocks = array(
			array(
				'name'		=> 'Important links',
				'content'	=> '&lt;ul&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;Our Rules&lt;/a&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;Frequently Asked Questions&lt;/a&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;BBCode Examples&lt;/a&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;Empty Link&lt;/a&gt;
	&lt;/li&gt;
	&lt;li&gt;
		&lt;a href=&quot;#&quot;&gt;Creating an account&lt;/a&gt;
	&lt;/li&gt;
&lt;/ul&gt;',
				'position'	=> 1
			),
			array(
				'name'		=> 'About us',
				'content'	=> '&lt;p&gt;Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.&lt;br&gt;&lt;br&gt;Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.&lt;/p&gt;',
				'position'	=> 2
			)
		);

		$sample_ra_footer_menu = array(
			array(
				'name'		=> '&lt;i class=&quot;fa fa-shopping-basket&quot;&gt;&lt;/i&gt;',
				'url'		=> '#',
				'align'		=> 1,
				'position'	=> 1
			)
		);

		$this->db->sql_multi_insert($this->table_prefix . 'ra_header_menu', $sample_ra_header_menu);
		$this->db->sql_multi_insert($this->table_prefix . 'ra_sidebar', $sample_ra_sidebar);
		$this->db->sql_multi_insert($this->table_prefix . 'ra_footer_blocks', $sample_ra_footer_blocks);
		$this->db->sql_multi_insert($this->table_prefix . 'ra_footer_menu', $sample_ra_footer_menu);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'ra_header_menu',
				$this->table_prefix . 'ra_sidebar',
				$this->table_prefix . 'ra_footer_blocks',
				$this->table_prefix . 'ra_footer_menu'
			)
		);
	}
}
