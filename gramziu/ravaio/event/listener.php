<?php



namespace gramziu\ravaio\event;



use Symfony\Component\EventDispatcher\EventSubscriberInterface;



class listener implements EventSubscriberInterface

{



	private $template;

	private $config;

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

			'core.page_header_after'		=> 'ravaio_main',

		);

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



		$ra_head_index_bg = $this->config['ra_head_index_bg'];

		$ra_head_other_bg = $this->config['ra_head_other_bg'];

		$ra_head_bg = $this->config['ra_head_bg'];

		$ra_sub_head_bg = $this->config['ra_sub_head_bg'];

		$ra_m_accent = $this->config['ra_m_accent'];

		$ra_m_accent_b = $this->config['ra_m_accent_b'];

		$ra_s_accent = $this->config['ra_s_accent'];

		$ra_s_accent_b = $this->config['ra_s_accent_b'];

		$ra_t_accent = $this->config['ra_t_accent'];

		$ra_t_accent_b = $this->config['ra_t_accent_b'];



		$ra_logo_type = $this->config['ra_logo_type'];

		$ra_logo_text = $this->config['ra_logo_text'];

		$ra_site_desc = $this->config['ra_site_desc'];

		$ra_head_type = $this->config['ra_head_type'];

		$ra_head_index_img = $this->config['ra_head_index_img'];

		$ra_head_other_img = $this->config['ra_head_other_img'];



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



				'RA_HEAD_INDEX_BG'	=> $ra_head_index_bg,

				'RA_HEAD_OTHER_BG'	=> $ra_head_other_bg,

				'RA_HEAD_BG'		=> $ra_head_bg,

				'RA_SUB_HEAD_BG'	=> $ra_sub_head_bg,

				'RA_M_ACCENT'		=> $ra_m_accent,

				'RA_M_ACCENT_B'		=> $ra_m_accent_b,

				'RA_S_ACCENT'		=> $ra_s_accent,

				'RA_S_ACCENT_B'		=> $ra_s_accent_b,

				'RA_T_ACCENT'		=> $ra_t_accent,

				'RA_T_ACCENT_B'		=> $ra_t_accent_b,



				'RA_LOGO_TYPE'		=> $ra_logo_type,

				'RA_LOGO_TEXT'		=> $ra_logo_text,

				'RA_SITE_DESC'		=> $ra_site_desc,

				'RA_HEAD_TYPE'		=> $ra_head_type,

				'RA_HEAD_INDEX_IMG'	=> $ra_head_index_img,

				'RA_HEAD_OTHER_IMG'	=> $ra_head_other_img,



				'RA_SIDEBAR'		=> $ra_sidebar,

				'RA_SIDEBAR_INDEX'	=> $ra_sidebar_index,

				'RA_SIDEBAR_CAT'	=> $ra_sidebar_cat,

				'RA_SIDEBAR_TOPIC'	=> $ra_sidebar_topic,



				'RA_FOOT_TYPE'		=> $ra_foot_type,

				'RA_RC_POSTS'		=> $ra_rc_posts,

				'RA_FOOT_TEXT'		=> $ra_foot_text,



				'RA_FOOTER_BLOCKS'	=> $ra_footer_blocks,

				'RA_FOOTER_BLOCKS_COUNT'	=> $ra_footer_blocks_count

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

					'NAME'		=> htmlspecialchars_decode($row['name']."*"),

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



			$sql = 'SELECT ' . POSTS_TABLE . '.post_time, ' . POSTS_TABLE . '.post_text, ' . POSTS_TABLE . '.post_id, ' . POSTS_TABLE . '.forum_id, ' . POSTS_TABLE . '.bbcode_uid, ' . POSTS_TABLE . '.bbcode_bitfield, ' . POSTS_TABLE . '.enable_bbcode, ' . POSTS_TABLE . '.enable_smilies, ' . POSTS_TABLE . '.enable_magic_url, ' . USERS_TABLE . '.user_id, ' . USERS_TABLE . '.username

			FROM ' . POSTS_TABLE . ' 

			JOIN ' . USERS_TABLE . ' 

			ON ' . POSTS_TABLE . '.poster_id = ' . USERS_TABLE . '.user_id ' . $forum_sql . '

			ORDER BY post_id DESC

			LIMIT ' . $ra_rc_posts_num;

			$result = $this->db->sql_query($sql);



			while($row = $this->db->sql_fetchrow($result))

			{

				$row['bbcode_options'] = (($row['enable_bbcode']) ? OPTION_FLAG_BBCODE : 0) + (($row['enable_smilies']) ? OPTION_FLAG_SMILIES : 0) + (($row['enable_magic_url']) ? OPTION_FLAG_LINKS : 0);



				strip_bbcode($row['post_text'], $row['bbcode_uid']);



				$this->template->assign_block_vars('ra_posts', array(

					'TEXT'			=> truncate_string($row['post_text'], 120, 140, 1, ''),

					'POSTER'		=> $row['username'],

					'URL'			=> append_sid("{$phpbb_root_path}viewtopic.$phpEx", 'p=' . $row['post_id']) . '#p' . $row['post_id'],

					'TIME'			=> $this->user->format_date($row['post_time'])

				));

			}



			$this->db->sql_freeresult($result);

		}

	}

}

