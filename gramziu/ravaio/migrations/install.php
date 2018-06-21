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

			array('config.add', array('ra_head_index_bg', 'transparent')),
			array('config.add', array('ra_head_other_bg', '#1976D2')),
			array('config.add', array('ra_head_bg', '#1976D2')),
			array('config.add', array('ra_sub_head_bg', '#2C3940')),
			array('config.add', array('ra_m_accent', '#1976D2')),
			array('config.add', array('ra_m_accent_b', '#12579B')),
			array('config.add', array('ra_s_accent', '#455A64')),
			array('config.add', array('ra_s_accent_b', '#2C3940')),
			array('config.add', array('ra_t_accent', '#455A64')),
			array('config.add', array('ra_t_accent_b', '#2C3940')),

			array('config.add', array('ra_logo_type', 0)),
			array('config.add', array('ra_logo_text', 'Your logo')),
			array('config.add', array('ra_site_desc', 1)),
			array('config.add', array('ra_head_type', 0)),
			array('config.add', array('ra_head_index_img', 'bg_cover.jpg')),
			array('config.add', array('ra_head_other_img', '')),

			array('config.add', array('ra_sidebar', 1)),
			array('config.add', array('ra_sidebar_index', 1)),
			array('config.add', array('ra_sidebar_cat', 1)),
			array('config.add', array('ra_sidebar_topic', 1)),

			array('config.add', array('ra_foot_type', 0)),
			array('config.add', array('ra_rc_posts', 1)),
			array('config.add', array('ra_rc_posts_num', 4)),
			array('config.add', array('ra_foot_text', 'Powered by <a href="https://www.phpbb.com/">phpBB</a>&reg; Forum Software &copy; phpBB Limited<span class="rside">Ravaio Theme by <a href="http://themeforest.net/user/Gramziu/">Gramziu</a>')),

			array('config.add', array('ra_footer_blocks', 1)),
			array('config.add', array('ra_footer_blocks_count', 2)),
			

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
				'name'		=> '&lt;i class=&quot;fa fa-shopping-basket&quot;&gt;&lt;/i&gt;',
				'url'		=> '#',
				'content'	=> '',
				'mega'		=> 0,
				'position'	=> 1
			),
			array(
				'name'		=> 'Dropdown',
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
				'name'		=> 'Ravaio',
 				'content'	=> 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
				'position'	=> 1
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
