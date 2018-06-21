<?php



namespace gramziu\ravaio\acp;



class ravaio_module

{

	public $u_action;



	public function main($id, $mode)

	{

		global $config, $db, $user, $auth, $template, $cache, $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix;



		$user->add_lang_ext('gramziu/ravaio', 'info_acp_ravaio');



		$action = request_var('action', '');

		$submit = (isset($_POST['submit'])) ? true : false;

		$add = (isset($_POST['add'])) ? true : false;

		$delete = (isset($_POST['delete'])) ? true : false;

		$ra_delete = (isset($_GET['ra_delete'])) ? isset($_GET['ra_delete']) : 0;



		$form_name = 'ravaio_main';

		add_form_key($form_name);



		switch ($mode)

		{

			case 'general':

				$ra_enable = request_var('ra_enable', $config['ra_enable']);

				$ra_layout = request_var('ra_layout', $config['ra_layout']);

				$ra_width = request_var('ra_width', $config['ra_width']);

				$ra_stat_pos = request_var('ra_stat_pos', $config['ra_stat_pos']);

				$ra_av_style = request_var('ra_av_style', $config['ra_av_style']);

				$ra_poster_style = request_var('ra_poster_style', $config['ra_poster_style']);

				$ra_poster_column = request_var('ra_poster_column', $config['ra_poster_column']);

				$ra_poster_width = request_var('ra_poster_width', $config['ra_poster_width']);

				$ra_back_to_top = request_var('ra_back_to_top', $config['ra_back_to_top']);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_GENERAL'];

					$log = 'ACP_RAVAIO_LOG_GENERAL';



					set_config('ra_enable', $ra_enable);

					set_config('ra_layout', $ra_layout);

					set_config('ra_width', $ra_width);

					set_config('ra_stat_pos', $ra_stat_pos);

					set_config('ra_av_style', $ra_av_style);

					set_config('ra_poster_style', $ra_poster_style);

					set_config('ra_poster_column', $ra_poster_column);

					set_config('ra_poster_width', $ra_poster_width);

					set_config('ra_back_to_top', $ra_back_to_top);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_GENERAL'			=> true,



					'RA_ENABLE'			=> $ra_enable,

					'RA_LAYOUT'			=> $ra_layout,

					'RA_WIDTH'			=> $ra_width,

					'RA_STAT_POS'		=> $ra_stat_pos,

					'RA_AV_STYLE'		=> $ra_av_style,

					'RA_POSTER_STYLE'	=> $ra_poster_style,

					'RA_POSTER_COLUMN'	=> $ra_poster_column,

					'RA_POSTER_WIDTH'	=> $ra_poster_width,

					'RA_BACK_TO_TOP'	=> $ra_back_to_top

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_GENERAL';

			break;



			case 'colours':

				$ra_head_index_bg = request_var('ra_head_index_bg', $config['ra_head_index_bg']);

				$ra_head_other_bg = request_var('ra_head_other_bg', $config['ra_head_other_bg']);

				$ra_head_bg = request_var('ra_head_bg', $config['ra_head_bg']);

				$ra_sub_head_bg = request_var('ra_sub_head_bg', $config['ra_sub_head_bg']);

				$ra_m_accent = request_var('ra_m_accent', $config['ra_m_accent']);

				$ra_m_accent_b = request_var('ra_m_accent_b', $config['ra_m_accent_b']);

				$ra_s_accent = request_var('ra_s_accent', $config['ra_s_accent']);

				$ra_s_accent_b = request_var('ra_s_accent_b', $config['ra_s_accent_b']);

				$ra_t_accent = request_var('ra_t_accent', $config['ra_t_accent']);

				$ra_t_accent_b = request_var('ra_t_accent_b', $config['ra_t_accent_b']);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];

					$log = 'ACP_RAVAIO_LOG_COLOURS';



					set_config('ra_head_index_bg', $ra_head_index_bg);

					set_config('ra_head_other_bg', $ra_head_other_bg);

					set_config('ra_head_bg', $ra_head_bg);

					set_config('ra_sub_head_bg', $ra_sub_head_bg);

					set_config('ra_m_accent', $ra_m_accent);

					set_config('ra_m_accent_b', $ra_m_accent_b);

					set_config('ra_s_accent', $ra_s_accent);

					set_config('ra_s_accent_b', $ra_s_accent_b);

					set_config('ra_t_accent', $ra_t_accent);

					set_config('ra_t_accent_b', $ra_t_accent_b);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_COLOURS'			=> true,



					'RA_HEAD_INDEX_BG'	=> $ra_head_index_bg,

					'RA_HEAD_OTHER_BG'	=> $ra_head_other_bg,

					'RA_HEAD_BG'		=> $ra_head_bg,

					'RA_SUB_HEAD_BG'	=> $ra_sub_head_bg,

					'RA_M_ACCENT'		=> $ra_m_accent,

					'RA_M_ACCENT_B'		=> $ra_m_accent_b,

					'RA_S_ACCENT'		=> $ra_s_accent,

					'RA_S_ACCENT_B'		=> $ra_s_accent_b,

					'RA_T_ACCENT'		=> $ra_t_accent,

					'RA_T_ACCENT_B'		=> $ra_t_accent_b

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_COLOURS';

			break;



			case 'header':

				$ra_logo_type = request_var('ra_logo_type', $config['ra_logo_type']);

				$ra_logo_text = utf8_normalize_nfc(request_var('ra_logo_text', $config['ra_logo_text'], true));

				$ra_site_desc = request_var('ra_site_desc', $config['ra_site_desc']);

				$ra_head_type = request_var('ra_head_type', $config['ra_head_type']);

				$ra_head_index_img = request_var('ra_head_index_img', $config['ra_head_index_img']);

				$ra_head_other_img = request_var('ra_head_other_img', $config['ra_head_other_img']);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_HEADER'];

					$log = 'ACP_RAVAIO_LOG_HEADER';



					set_config('ra_logo_type', $ra_logo_type);

					set_config('ra_logo_text', $ra_logo_text);

					set_config('ra_site_desc', $ra_site_desc);

					set_config('ra_head_type', $ra_head_type);

					set_config('ra_head_index_img', $ra_head_index_img);

					set_config('ra_head_other_img', $ra_head_other_img);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_HEADER'			=> true,



					'RA_LOGO_TYPE'		=> $ra_logo_type,

					'RA_LOGO_TEXT'		=> $ra_logo_text,

					'RA_SITE_DESC'		=> $ra_site_desc,

					'RA_HEAD_TYPE'		=> $ra_head_type,

					'RA_HEAD_INDEX_IMG'	=> $ra_head_index_img,

					'RA_HEAD_OTHER_IMG'	=> $ra_head_other_img

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_HEADER';

			break;



			case 'header_menu':

				$ra_header_menu = request_var('ra_header_menu', $config['ra_header_menu']);



				$sql = 'SELECT * FROM ' . $table_prefix . 'ra_header_menu';

				$result = $db->sql_query($sql);

				while($row = $db->sql_fetchrow($result))

				{

					$template->assign_block_vars('ra_header_menu', array(

						'NAME'		=> $row['name'],

						'POSITION'	=> $row['position'],

						'CONTENT'	=> $row['content'],

						'URL'		=> $row['url'],

						'MEGA'		=> $row['mega'],

						'DELETE'	=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=header_menu&amp;ra_delete='.$row['position'])

					));

				}

				$db->sql_freeresult($result);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$cache->destroy('_ra_header_menu_cache');



					set_config('ra_header_menu', $ra_header_menu);



					$position = request_var('position', array(0));



					$name = utf8_normalize_nfc(request_var('name', array(0 => ''), true));

					$url = request_var('url', array(0 => ''));

					$content = utf8_normalize_nfc(request_var('content', array(0 => ''), true));

					$mega = request_var('mega', array(0));



					$message = $user->lang['ACP_RAVAIO_LOG_HEADER_MENU'];

					$log = 'ACP_RAVAIO_LOG_HEADER_MENU';



					foreach ($position as $key => &$value)

					{

						$sql_ary = array(

							'name'		=> $name[$key],

							'url'		=> $url[$key],

							'content'	=> $content[$key],

							'mega'		=> $mega[$value]

						);



						$sql = 'UPDATE ' . $table_prefix . 'ra_header_menu' . '

								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '

								WHERE position = ' . $value;

						$db->sql_query($sql);

					}



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($add)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_HEADER_MENU'];

					$log = 'ACP_RAVAIO_LOG_HEADER_MENU';



					$sql_ary = array(

						'name'		=> '',

						'url'		=> '',

						'content'	=> '',

						'mega'	=> 0,

						'position'	=> NULL,

					);



					$sql = 'INSERT INTO ' . $table_prefix . 'ra_header_menu' . ' ' . $db->sql_build_array('INSERT', $sql_ary);

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($ra_delete)

				{

					$error = array();



					$cache->destroy('_ra_header_menu_cache');



					$message = $user->lang['ACP_RAVAIO_LOG_HEADER_MENU'];

					$log = 'ACP_RAVAIO_LOG_HEADER_MENU';



					$position = request_var('ra_delete', 0);



					$sql = 'DELETE FROM ' . $table_prefix . 'ra_header_menu' . ' 

							WHERE position = ' . (int) $position;

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_HEADER_MENU'			=> true,



					'RA_HEADER_MENU'		=> $ra_header_menu

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_HEADER_MENU';

			break;



			case 'sidebar':

				$sql = 'SELECT * FROM ' . $table_prefix . 'ra_sidebar';

				$result = $db->sql_query($sql);

				while($row = $db->sql_fetchrow($result))

				{

					$template->assign_block_vars('ra_sidebar', array(

						'NAME'		=> $row['name'],

						'CONTENT'	=> $row['content'],

						'POSITION'	=> $row['position'],

						'DELETE'	=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=sidebar&amp;ra_delete='.$row['position'])

					));

				}

				$db->sql_freeresult($result);

	

				$ra_sidebar = request_var('ra_sidebar', $config['ra_sidebar']);

				$ra_sidebar_index = request_var('ra_sidebar_index', $config['ra_sidebar_index']);

				$ra_sidebar_cat = request_var('ra_sidebar_cat', $config['ra_sidebar_cat']);

				$ra_sidebar_topic = request_var('ra_sidebar_topic', $config['ra_sidebar_topic']);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$cache->destroy('_ra_sidebar_cache');



					$message = $user->lang['ACP_RAVAIO_LOG_SIDEBAR'];

					$log = 'ACP_RAVAIO_LOG_SIDEBAR';



					$name = utf8_normalize_nfc(request_var('name', array(0 => ''), true));

					$content = utf8_normalize_nfc(request_var('content', array(0 => ''), true));

					$position = request_var('position', array(0));



					foreach ($position as $key => &$value)

					{

						$sql_ary = array(

							'name'		=> $name[$key],

							'content'	=> $content[$key]

						);



						$sql = 'UPDATE ' . $table_prefix . 'ra_sidebar' . '

								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '

								WHERE position = ' . $value;

						$db->sql_query($sql);

					}



					set_config('ra_sidebar', $ra_sidebar);

					set_config('ra_sidebar_index', $ra_sidebar_index);

					set_config('ra_sidebar_cat', $ra_sidebar_cat);

					set_config('ra_sidebar_topic', $ra_sidebar_topic);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($add)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_SIDEBAR'];

					$log = 'ACP_RAVAIO_LOG_SIDEBAR';



					$sql_ary = array(

						'name'		=> '',

						'content'	 => '',

					);



					$sql = 'INSERT INTO ' . $table_prefix . 'ra_sidebar' . ' ' . $db->sql_build_array('INSERT', $sql_ary);

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($ra_delete)

				{

					$error = array();



					$cache->destroy('_ra_sidebar_cache');



					$message = $user->lang['ACP_RAVAIO_LOG_SIDEBAR'];

					$log = 'ACP_RAVAIO_LOG_SIDEBAR';



					$position = request_var('ra_delete', 0);



					$sql = 'DELETE FROM ' . $table_prefix . 'ra_sidebar' . ' 

							WHERE position = ' . (int) $position;

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_SIDEBAR'			=> true,



					'RA_SIDEBAR'		=> $ra_sidebar,

					'RA_SIDEBAR_INDEX'	=> $ra_sidebar_index,

					'RA_SIDEBAR_CAT'	=> $ra_sidebar_cat,

					'RA_SIDEBAR_TOPIC'	=> $ra_sidebar_topic

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_SIDEBAR';

			break;



			case 'footer':

				$ra_foot_type = request_var('ra_foot_type', $config['ra_foot_type']);

				$ra_rc_posts = request_var('ra_rc_posts', $config['ra_rc_posts']);

				$ra_rc_posts_num = request_var('ra_rc_posts_num', $config['ra_rc_posts_num']);

				$ra_foot_text = utf8_normalize_nfc(request_var('ra_foot_text', $config['ra_foot_text'], true));



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER'];

					$log = 'ACP_RAVAIO_LOG_FOOTER';



					set_config('ra_foot_type', $ra_foot_type);

					set_config('ra_rc_posts', $ra_rc_posts);

					set_config('ra_rc_posts_num', $ra_rc_posts_num);

					set_config('ra_foot_text', $ra_foot_text);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_FOOTER'			=> true,



					'RA_FOOT_TYPE'		=> $ra_foot_type,

					'RA_RC_POSTS'		=> $ra_rc_posts,

					'RA_RC_POSTS_NUM'	=> $ra_rc_posts_num,

					'RA_FOOT_TEXT'		=> $ra_foot_text

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_FOOTER';

			break;



			case 'footer_blocks':

				$ra_footer_blocks = request_var('ra_footer_blocks', $config['ra_footer_blocks']);

				$ra_footer_blocks_count = request_var('ra_footer_blocks_count', $config['ra_footer_blocks_count']);



				$sql = 'SELECT * FROM ' . $table_prefix . 'ra_footer_blocks';

				$result = $db->sql_query($sql);

				while($row = $db->sql_fetchrow($result))

				{

					$template->assign_block_vars('ra_footer_blocks', array(

						'NAME'		=> $row['name'],

						'POSITION'	=> $row['position'],

						'CONTENT'	=> $row['content'],

						'URL'		=> $row['url'],

						'DELETE'	=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=footer_blocks&amp;ra_delete='.$row['position'])

					));

				}

				$db->sql_freeresult($result);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$cache->destroy('_ra_footer_blocks_cache');



					set_config('ra_footer_blocks', $ra_footer_blocks);



					$position = request_var('position', array(0));



					$name = utf8_normalize_nfc(request_var('name', array(0 => ''), true));

					$url = request_var('url', array(0 => ''));

					$content = utf8_normalize_nfc(request_var('content', array(0 => ''), true));



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_BLOCKS'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_BLOCKS';



					foreach ($position as $key => &$value)

					{

						$sql_ary = array(

							'name'		=> $name[$key],

							'url'		=> $url[$key],

							'content'	=> $content[$key]

						);



						$sql = 'UPDATE ' . $table_prefix . 'ra_footer_blocks' . '

								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '

								WHERE position = ' . $value;

						$db->sql_query($sql);

					}



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($add)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_BLOCKS'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_BLOCKS';



					set_config('ra_footer_blocks_count', ++$ra_footer_blocks_count);



					$sql_ary = array(

						'name'		=> '',

						'url'		=> '',

						'content'	=> '',

						'position'	=> NULL,

					);



					$sql = 'INSERT INTO ' . $table_prefix . 'ra_footer_blocks' . ' ' . $db->sql_build_array('INSERT', $sql_ary);

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($ra_delete)

				{

					$error = array();



					$cache->destroy('_ra_footer_blocks_cache');



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_BLOCKS'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_BLOCKS';



					set_config('ra_footer_blocks_count', --$ra_footer_blocks_count);



					$position = request_var('ra_delete', 0);



					$sql = 'DELETE FROM ' . $table_prefix . 'ra_footer_blocks' . ' 

							WHERE position = ' . (int) $position;

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_FOOTER_BLOCKS'		=> true,



					'RA_FOOTER_BLOCKS'		=> $ra_footer_blocks,

					'RA_FOOTER_BLOCKS_COUNT'		=> $ra_footer_blocks_count

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_FOOTER_BLOCKS';

			break;



			case 'footer_menu':

				$ra_footer_menu = request_var('ra_footer_menu', $config['ra_footer_menu']);



				$sql = 'SELECT * FROM ' . $table_prefix . 'ra_footer_menu';

				$result = $db->sql_query($sql);

				while($row = $db->sql_fetchrow($result))

				{

					$template->assign_block_vars('ra_footer_menu', array(

						'NAME'		=> $row['name'],

						'POSITION'	=> $row['position'],

						'ALIGN'		=> $row['align'],

						'URL'		=> $row['url'],

						'DELETE'	=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=footer_menu&amp;ra_delete='.$row['position'])

					));

				}

				$db->sql_freeresult($result);



				if ($submit)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$cache->destroy('_ra_footer_menu_cache');



					set_config('ra_footer_menu', $ra_footer_menu);



					$position = request_var('position', array(0));



					$name = utf8_normalize_nfc(request_var('name', array(0 => ''), true));

					$url = request_var('url', array(0 => ''));

					$align = request_var('align', array(0));



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_MENU'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_MENU';



					foreach ($position as $key => &$value)

					{

						$sql_ary = array(

							'name'		=> $name[$key],

							'url'		=> $url[$key],

							'align'		=> $align[$value]

						);



						$sql = 'UPDATE ' . $table_prefix . 'ra_footer_menu' . '

								SET ' . $db->sql_build_array('UPDATE', $sql_ary) . '

								WHERE position = ' . $value;

						$db->sql_query($sql);

					}



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($add)

				{

					if (!check_form_key($form_name))

					{

						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);

					}



					$error = array();



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_MENU'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_MENU';



					$sql_ary = array(

						'name'		=> '',

						'url'		=> '',

						'align'		=> 1,

						'position'	=> NULL,

					);



					$sql = 'INSERT INTO ' . $table_prefix . 'ra_footer_menu' . ' ' . $db->sql_build_array('INSERT', $sql_ary);

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				if ($ra_delete)

				{

					$error = array();



					$cache->destroy('_ra_footer_menu_cache');



					$message = $user->lang['ACP_RAVAIO_LOG_FOOTER_MENU'];

					$log = 'ACP_RAVAIO_LOG_FOOTER_MENU';



					$position = request_var('ra_delete', 0);



					$sql = 'DELETE FROM ' . $table_prefix . 'ra_footer_menu' . ' 

							WHERE position = ' . (int) $position;

					$db->sql_query($sql);



					add_log('admin', $log . '_EXP');

					trigger_error($message . adm_back_link($this->u_action));

				}



				$template->assign_vars(array(

					'S_FOOTER_MENU'			=> true,



					'RA_FOOTER_MENU'		=> $ra_footer_menu

					)

				);



				$this->tpl_name = 'ravaio_main';

				$this->page_title = 'ACP_RAVAIO_FOOTER_MENU';

			break;



			default:

				trigger_error('NO_MODE', E_USER_ERROR);

			break;

		}

	}

}



?>