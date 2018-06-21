<?php

namespace gramziu\ravaio\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{

	private $template;
	private $config;
	private $config_text;
	private $db;
	private $request;
	private $auth;
	private $user;
	private $root_path;
	private $php_ext;
	private $cache;

	private $ra_header_menu_table;
	private $ra_sidebar_table;
	private $ra_footer_blocks_table;
	private $ra_footer_menu_table;

	public function __construct(
		\phpbb\template\template $template,
		\phpbb\config\config $config,
		\phpbb\config\db_text $config_text,
		\phpbb\db\driver\factory $db,
		\phpbb\request\request $request,
		\phpbb\auth\auth $auth,
		\phpbb\user $user,
		$root_path,
		$php_ext,
		\phpbb\cache\driver\driver_interface $cache,
		$ra_header_menu_table,
		$ra_sidebar_table,
		$ra_footer_blocks_table,
		$ra_footer_menu_table)
	{
		$this->template		= $template;
		$this->config		= $config;
		$this->config_text	= $config_text;
		$this->db			= $db;
		$this->request		= $request;
		$this->auth			= $auth;
		$this->user			= $user;
		$this->root_path	= $root_path;
		$this->php_ext		= $php_ext;
		$this->cache		= $cache;

		$this->ra_header_menu_table		= $ra_header_menu_table;
		$this->ra_sidebar_table			= $ra_sidebar_table;
		$this->ra_footer_blocks_table	= $ra_footer_blocks_table;
		$this->ra_footer_menu_table		= $ra_footer_menu_table;
	}

	static public function getSubscribedEvents()
	{
		return array(
			'core.search_modify_tpl_ary'			=> 'add_avatars_to_search',
			'core.mcp_topic_review_modify_row'		=> 'add_avatars_to_mcp',
			'core.mcp_post_template_data'			=> 'add_avatars_to_mcp_post_details',
			'core.topic_review_modify_row'			=> 'add_avatars_to_topic_review',
			'core.page_header_after'				=> 'ravaio_main',
			'core.ucp_prefs_personal_data'			=> 'ucp_variant_get',
			'core.ucp_prefs_personal_update_data'	=> 'ucp_variant_set',
		);
	}

	public function add_avatars_to_search($event)
	{
		if (array_key_exists('poster_id', $event['row']))
		{
			$tpl_ary = $event['tpl_ary'];

			$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $event['row']['poster_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$tpl_ary['POSTER_AVATAR'] = phpbb_get_user_avatar($row);

			$event['tpl_ary'] = $tpl_ary;
		}
	}

	public function add_avatars_to_mcp($event)
	{
		
		if ($event['row']['poster_id'])
		{
			$post_row = $event['post_row'];

			$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $event['row']['poster_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$post_row['POSTER_AVATAR'] = phpbb_get_user_avatar($row);

			$event['post_row'] = $post_row;
		}
	}

	public function add_avatars_to_mcp_post_details($event)
	{
		
		if ($event['post_info']['user_id'])
		{
			$mcp_post_template_data = $event['mcp_post_template_data'];

			$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $event['post_info']['user_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$mcp_post_template_data['POSTER_AVATAR'] = phpbb_get_user_avatar($row);

			$event['mcp_post_template_data'] = $mcp_post_template_data;
		}
	}

	public function add_avatars_to_topic_review($event)
	{
		if ($event['row']['user_id'])
		{
			$post_row = $event['post_row'];

			$sql = 'SELECT user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
					FROM ' . USERS_TABLE . '
					WHERE user_id = ' . $event['row']['user_id'];
			$result = $this->db->sql_query($sql);
			$row = $this->db->sql_fetchrow($result);

			$post_row['POSTER_AVATAR'] = phpbb_get_user_avatar($row);

			$event['post_row'] = $post_row;
		}
	}

	public function ravaio_main($event)
	{
		$ra_enable = $this->config['ra_enable'];

		$ra_layout = $this->config['ra_layout'];
		$ra_width = $this->config['ra_width'];
		$ra_stat_pos = $this->config['ra_stat_pos'];
		$ra_av_style = $this->config['ra_av_style'];
		$ra_poster_style = $this->config['ra_poster_style'];
		$ra_poster_column = $this->config['ra_poster_column'];
		$ra_poster_width = $this->config['ra_poster_width'];
		$ra_back_to_top = $this->config['ra_back_to_top'];

		$ra_custom_css = $this->config_text->get('ra_custom_css');

		$ra_logo = $this->config['ra_logo'];
		$ra_logo_width = $this->config['ra_logo_width'];
		$ra_logo_height = $this->config['ra_logo_height'];
		$ra_logo_type = $this->config['ra_logo_type'];
		$ra_logo_text = $this->config['ra_logo_text'];
		$ra_site_desc = $this->config['ra_site_desc'];
		$ra_head_index_text = $this->config['ra_head_index_text'];
		$ra_head_type = $this->config['ra_head_type'];

		$ra_site_desc_pos_prepared = $this->config['ra_site_desc_pos_prepared'];

		$ra_sidebar = $this->config['ra_sidebar'];
		$ra_sidebar_index = $this->config['ra_sidebar_index'];
		$ra_sidebar_cat = $this->config['ra_sidebar_cat'];
		$ra_sidebar_topic = $this->config['ra_sidebar_topic'];

		$ra_foot_type = $this->config['ra_foot_type'];
		$ra_rc_posts = $this->config['ra_rc_posts'];
		$ra_rc_posts_num = $this->config['ra_rc_posts_num'];
		$ra_foot_text = htmlspecialchars_decode($this->config['ra_foot_text']);

		$ra_footer_blocks = $this->config['ra_footer_blocks'];
		$ra_footer_blocks_count = $this->config['ra_footer_blocks_count'];

		$ra_header_menu = $this->config['ra_header_menu'];
		$ra_footer_menu = $this->config['ra_footer_menu'];

		$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : './';
		$phpEx = substr(strrchr(__FILE__, '.'), 1);

		$user_id = $this->user->data['user_id'];

		function getVariantData($name, $variant) {
			$name = unserialize($name);

			return $name[$variant];
		}

		if ($this->auth->acl_gets('a_'))
		{
			$ra_variant = (int) request_var('ra_variant', $this->user->data['ra_variant']);

			$ra_variant_default = $this->config['ra_variant_default'];
			$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

			if ($ra_variant == 9)
			{
				$ra_variant = $ra_variant_default;
			}

			if (!isset($ra_variant_enabled[$ra_variant]))
			{
				$ra_variant = $ra_variant_default;
			}

			if (($this->request->server('REQUEST_METHOD') === 'POST') && $this->request->is_set('ra_variant'))
			{
				$sql = 'UPDATE ' . USERS_TABLE . ' 
						SET ra_variant = ' . $ra_variant . ' 
						WHERE user_id = ' . $user_id;
				$this->db->sql_query($sql);
			}

			$ra_s_variants = true;
		}
		else if ($user_id != ANONYMOUS)
		{
			$ra_s_variants = $this->config['ra_s_variants'];
			$ra_variant_default = $this->config['ra_variant_default'];

			if ($ra_s_variants)
			{
				if ($this->request->is_set_post('ra_variant'))
				{
					$ra_variant = (int) $this->request->variable('ra_variant', 9);

					$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

					if ($ra_variant == 9)
					{
						$ra_variant = $ra_variant_default;
					}

					if (isset($ra_variant_enabled[$ra_variant]))
					{
						if ($ra_variant_enabled[$ra_variant] == 0)
						{
							$ra_variant = $ra_variant_default;
						}
					}
					else
					{
						$ra_variant = $ra_variant_default;
					}

					$sql = 'UPDATE ' . USERS_TABLE . ' 
							SET ra_variant = ' . $ra_variant . ' 
							WHERE user_id = ' . $user_id;
					$this->db->sql_query($sql);
				}
				else
				{
					$ra_variant = $this->user->data['ra_variant'];

					$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

					if ($ra_variant == 9)
					{
						$ra_variant = $ra_variant_default;
					}

					if (isset($ra_variant_enabled[$ra_variant]))
					{
						if ($ra_variant_enabled[$ra_variant] == 0)
						{
							$ra_variant = $ra_variant_default;
						}
					}
					else
					{
						$ra_variant = $ra_variant_default;
					}
				}
			}
			else
			{
				$ra_variant = $ra_variant_default;
			}
		}
		else
		{
			$ra_s_variants = $this->config['ra_s_variants'];
			$ra_variant_default = $this->config['ra_variant_default'];

			if ($ra_s_variants)
			{
				if ($this->request->is_set_post('ra_variant'))
				{
					$ra_variant = (int) $this->request->variable('ra_variant', 9);

					$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

					if ($ra_variant == 9)
					{
						$ra_variant = $ra_variant_default;
					}

					if (isset($ra_variant_enabled[$ra_variant]))
					{
						if ($ra_variant_enabled[$ra_variant] == 0)
						{
							$ra_variant = $ra_variant_default;
						}
					}
					else
					{
						$ra_variant = $ra_variant_default;
					}

					$this->user->set_cookie('ra_variant', $ra_variant, 0);
				}
				else if ($this->request->is_set($this->config['cookie_name'] . '_' . 'ra_variant', 3, true))
				{
					$ra_variant = $this->request->variable($this->config['cookie_name'] . '_' . 'ra_variant', $ra_variant_default, false, 3);

					$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

					if ($ra_variant == 9)
					{
						$ra_variant = $ra_variant_default;
					}

					if (isset($ra_variant_enabled[$ra_variant]))
					{
						if ($ra_variant_enabled[$ra_variant] == 0)
						{
							$ra_variant = $ra_variant_default;
						}
					}
					else
					{
						$ra_variant = $ra_variant_default;
					}
				}
				else
				{
					$ra_variant = $ra_variant_default;
				}
			}
			else
			{
				$ra_variant = $ra_variant_default;
			}
		}

		$ra_main_background = getVariantData($this->config['ra_main_background'], $ra_variant);
		$ra_main_border = getVariantData($this->config['ra_main_border'], $ra_variant);
		$ra_main_background_darken = getVariantData($this->config['ra_main_background_darken'], $ra_variant);

		$ra_head_index_img = getVariantData($this->config['ra_head_index_img'], $ra_variant);
		$ra_head_other_img = getVariantData($this->config['ra_head_other_img'], $ra_variant);

		$ra_s_variants = $this->config['ra_s_variants'];

		$ra_variant_list = array();

		if ($ra_s_variants) {
			$ra_color_variants = unserialize($this->config['ra_color_variants']);
			$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

			foreach ($ra_color_variants as $i => $variant)
			{
				if ($ra_variant_enabled[$i])
				{
					$ra_variant_list[] = array($variant,  $i, $ra_variant);
				}
			}

			$ra_variant_list = json_encode($ra_variant_list);
		}

		$this->template->assign_vars(
			array(
				'RA_ENABLE'			=> $ra_enable,

				'RA_LAYOUT'			=> $ra_layout,
				'RA_WIDTH'			=> $ra_width,
				'RA_STAT_POS'		=> $ra_stat_pos,
				'RA_AV_STYLE'		=> $ra_av_style,
				'RA_POSTER_STYLE'	=> $ra_poster_style,
				'RA_POSTER_COLUMN'	=> $ra_poster_column,
				'RA_POSTER_WIDTH'	=> $ra_poster_width,
				'RA_BACK_TO_TOP'	=> $ra_back_to_top,

				'RA_CUSTOM_CSS'		=> htmlspecialchars_decode($ra_custom_css),

				'RA_LOGO'				=> $ra_logo,
				'RA_LOGO_WIDTH'			=> $ra_logo_width,
				'RA_LOGO_HEIGHT'		=> $ra_logo_height,
				'RA_LOGO_TYPE'			=> $ra_logo_type,
				'RA_LOGO_TEXT'			=> $ra_logo_text,
				'RA_SITE_DESC'			=> $ra_site_desc,
				'RA_HEAD_INDEX_TEXT'	=> $ra_head_index_text,
				'RA_HEAD_TYPE'			=> $ra_head_type,

				'RA_SITE_DESC_POS_PREPARED'	=> $ra_site_desc_pos_prepared,

				'RA_SIDEBAR'		=> $ra_sidebar,
				'RA_SIDEBAR_INDEX'	=> $ra_sidebar_index,
				'RA_SIDEBAR_CAT'	=> $ra_sidebar_cat,
				'RA_SIDEBAR_TOPIC'	=> $ra_sidebar_topic,

				'RA_FOOT_TYPE'		=> $ra_foot_type,
				'RA_RC_POSTS'		=> $ra_rc_posts,
				'RA_FOOT_TEXT'		=> $ra_foot_text,

				'RA_FOOTER_BLOCKS'			=> $ra_footer_blocks,
				'RA_FOOTER_BLOCKS_COUNT'	=> $ra_footer_blocks_count,

				'RA_VARIANT'		=> $ra_variant,
				'RA_S_VARIANTS'		=> $ra_s_variants,
				'RA_VARIANT_LIST'	=> $ra_variant_list,

				'RA_MAIN_BACKGROUND'		=> $ra_main_background,
				'RA_MAIN_BORDER'			=> $ra_main_border,
				'RA_MAIN_BACKGROUND_DARKEN'	=> $ra_main_background_darken,

				'RA_HEAD_INDEX_IMG'	=> $ra_head_index_img,
				'RA_HEAD_OTHER_IMG'	=> $ra_head_other_img,

				'BODY_CLASS'		=> 'variant-' . ($ra_variant + 1),
			)
		);

		if ($ra_header_menu)
		{
			$ra_header_menu_cache = $this->cache->get('_ra_header_menu_cache');

			if ($ra_header_menu_cache === false)
			{
				$ra_header_menu_cache = array();

				$sql = 'SELECT name, url, content, mega FROM ' . $this->ra_header_menu_table;
				$result = $this->db->sql_query($sql);

				while($row = $this->db->sql_fetchrow($result))
				{
					$ra_header_menu_cache[] = $row;
				}
				$this->db->sql_freeresult($result);

				$this->cache->put('_ra_header_menu_cache', $ra_header_menu_cache);
			}

			foreach ($ra_header_menu_cache as $row)
			{
				$this->template->assign_block_vars('ra_header_menu', array(
					'NAME'		=> htmlspecialchars_decode($row['name']),
					'URL'		=> htmlspecialchars_decode($row['url']),
					'CONTENT'	=> htmlspecialchars_decode($row['content']),
					'MEGA'		=> $row['mega']
				));
			}
		}

		if ($ra_sidebar)
		{
			$ra_sidebar_cache = $this->cache->get('_ra_sidebar_cache');

			if ($ra_sidebar_cache === false)
			{
				$ra_sidebar_cache = array();

				$sql = 'SELECT name, url, content FROM ' . $this->ra_sidebar_table;
				$result = $this->db->sql_query($sql);

				while($row = $this->db->sql_fetchrow($result))
				{
					$ra_sidebar_cache[] = $row;
				}
				$this->db->sql_freeresult($result);	

				$this->cache->put('_ra_sidebar_cache', $ra_sidebar_cache);
			}

			foreach ($ra_sidebar_cache as $row)
			{
				$this->template->assign_block_vars('ra_sidebar', array(
					'NAME'		=> htmlspecialchars_decode($row['name']),
					'URL'		=> htmlspecialchars_decode($row['url']),
					'CONTENT'	=> htmlspecialchars_decode($row['content'])
				));
			}
		}

		if ($ra_footer_blocks)
		{
			$ra_footer_blocks_cache = $this->cache->get('_ra_footer_blocks_cache');

			if ($ra_footer_blocks_cache === false)
			{
				$ra_footer_blocks_cache = array();

				$sql = 'SELECT name, url, content FROM ' . $this->ra_footer_blocks_table;
				$result = $this->db->sql_query($sql);

				while($row = $this->db->sql_fetchrow($result))
				{
					$ra_footer_blocks_cache[] = $row;
				}
				$this->db->sql_freeresult($result);

				$this->cache->put('_ra_footer_blocks_cache', $ra_footer_blocks_cache);
			}

			foreach ($ra_footer_blocks_cache as $row)
			{
				$this->template->assign_block_vars('ra_footer_blocks', array(
					'NAME'		=> htmlspecialchars_decode($row['name']),
					'URL'		=> htmlspecialchars_decode($row['url']),
					'CONTENT'	=> htmlspecialchars_decode($row['content'])
				));
			}
		}

		if ($ra_footer_menu)
		{
			$ra_footer_menu_cache = $this->cache->get('_ra_footer_menu_cache');

			if ($ra_footer_menu_cache === false)
			{
				$ra_footer_menu_cache = array();

				$sql = 'SELECT name, url, align FROM ' . $this->ra_footer_menu_table;
				$result = $this->db->sql_query($sql);

				while($row = $this->db->sql_fetchrow($result))
				{
					$ra_footer_menu_cache[] = $row;
				}
				$this->db->sql_freeresult($result);

				$this->cache->put('_ra_footer_menu_cache', $ra_footer_menu_cache);
			}

			foreach ($ra_footer_menu_cache as $row)
			{
				$this->template->assign_block_vars('ra_footer_menu', array(
					'NAME'	=> htmlspecialchars_decode($row['name']),
					'URL'	=> htmlspecialchars_decode($row['url']),
					'ALIGN'	=> $row['align']
				));
			}
		}

		if ($ra_rc_posts)
		{
			$forum_ary = array();
			$forum_read_ary = $this->auth->acl_getf('!f_read');

			foreach ($forum_read_ary as $forum_id => $not_allowed)
			{
				if ($not_allowed['f_read'])
				{
					$forum_ary[] = (int) $forum_id;
				}
			}

			$forum_ary = array_unique($forum_ary);
			$forum_sql = (sizeof($forum_ary)) ? 'AND ' . $this->db->sql_in_set('forum_id', $forum_ary, true) : '';

			$sql = 'SELECT ' . POSTS_TABLE . '.post_time, ' . POSTS_TABLE . '.post_subject, ' . POSTS_TABLE . '.post_text, ' . POSTS_TABLE . '.post_id, ' . POSTS_TABLE . '.forum_id, ' . POSTS_TABLE . '.bbcode_uid, ' . POSTS_TABLE . '.bbcode_bitfield, ' . POSTS_TABLE . '.enable_bbcode, ' . POSTS_TABLE . '.enable_smilies, ' . POSTS_TABLE . '.enable_magic_url, ' . USERS_TABLE . '.user_id, ' . USERS_TABLE . '.username, ' . USERS_TABLE . '.user_avatar, ' . USERS_TABLE . '.user_avatar_type, ' . USERS_TABLE . '.user_avatar_width, ' . USERS_TABLE . '.user_avatar_height
			FROM ' . POSTS_TABLE . ' 
			JOIN ' . USERS_TABLE . ' 
			ON ' . POSTS_TABLE . '.poster_id = ' . USERS_TABLE . '.user_id ' . $forum_sql . ' AND ' . POSTS_TABLE . '.post_visibility = 1 
			ORDER BY post_id DESC
			LIMIT ' . $ra_rc_posts_num;
			$result = $this->db->sql_query($sql);

			while($row = $this->db->sql_fetchrow($result))
			{
				$row['bbcode_options'] = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) + (($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) + (($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);

				strip_bbcode($row['post_text'], $row['bbcode_uid']);

				$this->template->assign_block_vars('ra_posts', array(
					'TITLE'			=> truncate_string(censor_text($row['post_subject']), 30, 255, false, $this->user->lang['ELLIPSIS']),
					'TEXT'			=> truncate_string(censor_text($row['post_text']), 120, 140, 1, ''),
					'POSTER'		=> $row['username'],
					'URL'			=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'p=' . $row['post_id']) . '#p' . $row['post_id'],
					'TIME'			=> $this->user->format_date($row['post_time']),
					'AVATAR'		=> get_user_avatar($row['user_avatar'], $row['user_avatar_type'], $row['user_avatar_width'], $row['user_avatar_height'])
				));
			}

			$this->db->sql_freeresult($result);
		}
	}

	public function ucp_variant_get($event)
	{
		$ra_s_variants = $this->config['ra_s_variants'];

		if ($ra_s_variants) {
			$ra_color_variants = unserialize($this->config['ra_color_variants']);
			$ra_variant_enabled = unserialize($this->config['ra_variant_enabled']);

			foreach ($ra_color_variants as $i => $variant)
			{
				$this->template->assign_block_vars('color_variants', array(
					'NAME'		=> $variant,
					'INDEX'		=> $i,
					'STATUS'	=> $ra_variant_enabled[$i]
				));
			}

			$this->template->assign_vars(array(
				'RA_VARIANT'	=> $this->user->data['ra_variant'],
				)
			);
		}
	}

	public function ucp_variant_set($event)
	{
		$ra_s_variants = $this->config['ra_s_variants'];

		if ($ra_s_variants) {
			$sql_ary = $event['sql_ary'];
			$sql_ary['ra_variant'] = request_var('ra_variant', (int) $this->user->data['ra_variant']);
			$event['sql_ary'] = $sql_ary;
		}
	}
}
