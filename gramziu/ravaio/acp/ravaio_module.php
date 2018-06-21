<?php

namespace gramziu\ravaio\acp;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class ravaio_module
{
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $db, $user, $auth, $template, $cache, $phpbb_root_path, $phpbb_admin_path, $phpEx, $table_prefix, $phpbb_container, $request;

		$config_text = $phpbb_container->get('config_text');

		$user->add_lang_ext('gramziu/ravaio', 'info_acp_ravaio');
		$user->add_lang(array('posting'));

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

				$ra_custom_css = request_var('ra_custom_css', $config_text->get('ra_custom_css'));

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

					$config_text->set('ra_custom_css', $ra_custom_css);

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
					'RA_BACK_TO_TOP'	=> $ra_back_to_top,

					'RA_CUSTOM_CSS'		=> $ra_custom_css
					)
				);

				$this->tpl_name = 'ravaio_main';
				$this->page_title = 'ACP_RAVAIO_GENERAL';
			break;

			case 'colours':
				$update_index = (isset($_POST['update_index'])) ? true : false;
				$update_other = (isset($_POST['update_other'])) ? true : false;

				function getVariantVar($name, $mode, $variant) {
					global $config;

					$var = request_var($name, '');

					if ($var != '' && $mode != 'full')
					{
						return $var;
					}
					else
					{
						$var = unserialize($config[$name]);

						switch ($mode)
						{
							case 'full':
								return $var;
							break;

							case 'single':
								$var = $var[$variant];

								return $var;
							break;
						}
					}
				}

				function setVariantVar($name, $variant, $content = '') {
					$var = request_var($name, '');

					if ($var != '')
					{
						$prepared_var = getVariantVar($name, 'full', $variant);
						$prepared_var[$variant] = $var;
						$prepared_var = serialize($prepared_var);

						set_config($name, $prepared_var);
					}
					else
					{
						$prepared_var = getVariantVar($name, 'full', $variant);
						$prepared_var[$variant] = $content;
						$prepared_var = serialize($prepared_var);

						set_config($name, $prepared_var);
					}
				}

				if (!getVariantVar('ra_color_variants', 'full', 3)[3]) {
					setVariantVar('ra_color_variants', 3, $content = 'Quaternary');
				}

				$color_variant = request_var('color_variant', -1);

				if ($color_variant >= 0) {
					if ($submit)
					{
						if (!check_form_key($form_name))
						{
							trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
						}

						$error = array();

						$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];
						$log = 'ACP_RAVAIO_LOG_COLOURS';

						function toHSL($color) {
							$r = $color[0] / 255;
							$g = $color[1] / 255;
							$b = $color[2] / 255;
							$min = min($r, $g, $b);
							$max = max($r, $g, $b);
							$L = ($min + $max) / 2;
							if ($min == $max) {
								$S = $H = 0;
							} else {
								if ($L < 0.5)
									$S = ($max - $min)/($max + $min);
								else
									$S = ($max - $min)/(2.0 - $max - $min);
								if ($r == $max) $H = ($g - $b)/($max - $min);
								elseif ($g == $max) $H = 2.0 + ($b - $r)/($max - $min);
								elseif ($b == $max) $H = 4.0 + ($r - $g)/($max - $min);
							}
							$out = array(
								($H < 0 ? $H + 6 : $H)*60,
								$S*100,
								$L*100,
							);
							if (count($color) > 3) $out[] = $color[3]; // copy alpha
							return $out;
						}

						function coerceColor($value) {
							$colorStr = substr($value[0], 0);
							$num = hexdec($colorStr);
							$width = strlen($colorStr) == 2 ? 16 : 256;
							for ($i = 2; $i > -1; $i--) { // 3 2 1
								$t = $num % $width;
								$num /= $width;
								$c[$i] = $t * (256/$width) + $t * floor(16/$width);
							}
							return $c;
						}

						function clamp($v, $max = 1, $min = 0) {
							return min($max, max($min, $v));
						}

						function darken_color($color, $percentage) {
							$color = toHSL(coerceColor(array($color)));
							$color[2] = clamp($color[2] - $percentage, 100);

							$color[0] /= 360;
							$color[1] /= 100;
							$color[2] /= 100;

							$color = HSLToRGB($color[0], $color[1], $color[2]);

							return 'rgb('.floor($color['r']).', '.floor($color['g']).', '.floor($color['b']).')';
						}

						function HSLToRGB($h, $s, $l) {

							$r = $l;
							$g = $l;
							$b = $l;
							$v = ($l <= 0.5) ? ($l * (1.0 + $s)) : ($l + $s - $l * $s);
							if ($v > 0){
									$m;
									$sv;
									$sextant;
									$fract;
									$vsf;
									$mid1;
									$mid2;

									$m = $l + $l - $v;
									$sv = ($v - $m ) / $v;
									$h *= 6.0;
									$sextant = floor($h);
									$fract = $h - $sextant;
									$vsf = $v * $sv * $fract;
									$mid1 = $m + $vsf;
									$mid2 = $v - $vsf;

									switch ($sextant)
									{
										case 0:
												$r = $v;
												$g = $mid1;
												$b = $m;
												break;
										case 1:
												$r = $mid2;
												$g = $v;
												$b = $m;
												break;
										case 2:
												$r = $m;
												$g = $v;
												$b = $mid1;
												break;
										case 3:
												$r = $m;
												$g = $mid2;
												$b = $v;
												break;
										case 4:
												$r = $mid1;
												$g = $m;
												$b = $v;
												break;
										case 5:
												$r = $v;
												$g = $m;
												$b = $mid2;
												break;
									}
							}
							return array('r' => $r * 255.0, 'g' => $g * 255.0, 'b' => $b * 255.0);
						}

						$ra_head_index_bg = getVariantVar('ra_head_index_bg', 'single', $color_variant);
						$ra_head_other_bg = getVariantVar('ra_head_other_bg', 'single', $color_variant);
						$ra_head_index_sticky_bg = getVariantVar('ra_head_index_sticky_bg', 'single', $color_variant);
						$ra_head_other_sticky_bg = getVariantVar('ra_head_other_sticky_bg', 'single', $color_variant);

						$ra_head_index_img = getVariantVar('ra_head_index_img', 'single', $color_variant);
						$ra_head_other_img = getVariantVar('ra_head_other_img', 'single', $color_variant);

						$ra_s_head_index_img = getVariantVar('ra_s_head_index_img', 'single', $color_variant);
						$ra_s_head_other_img = getVariantVar('ra_s_head_other_img', 'single', $color_variant);

						$ra_main_accent = getVariantVar('ra_main_accent', 'single', $color_variant);
						$ra_secondary_accent = getVariantVar('ra_secondary_accent', 'single', $color_variant);
						$ra_main_text = getVariantVar('ra_main_text', 'single', $color_variant);
						$ra_secondary_text = getVariantVar('ra_secondary_text', 'single', $color_variant);
						$ra_site_background = getVariantVar('ra_site_background', 'single', $color_variant);
						$ra_main_background = getVariantVar('ra_main_background', 'single', $color_variant);
						$ra_main_border = getVariantVar('ra_main_border', 'single', $color_variant);

						$ra_main_accent_darken = darken_color($ra_main_accent, 12);
						$ra_secondary_accent_darken = darken_color($ra_secondary_accent, 12);
						$ra_main_text_darken = darken_color($ra_main_text, 26);
						$ra_site_background_darken = darken_color($ra_site_background, 5);
						$ra_main_background_darken = darken_color($ra_main_background, 2);
						$ra_main_background_x_darken = darken_color($ra_main_background, 7);
						$ra_main_border_darken = darken_color($ra_main_border, 10);
						$ra_main_border_x_darken = darken_color($ra_main_border, 17);

						$css_output = file_get_contents($phpbb_root_path . 'ext/gramziu/ravaio/assets/color_variables.min.css');

						$search = array(
							'{ra_head_index_bg}',
							'{ra_head_other_bg}',
							'{ra_head_index_sticky_bg}',
							'{ra_head_other_sticky_bg}',
							'{ra_head_index_img}',
							'{ra_head_other_img}',
							'{ra_main_accent}',
							'{ra_secondary_accent}',
							'{ra_main_text}',
							'{ra_secondary_text}',
							'{ra_site_background}',
							'{ra_main_background}',
							'{ra_main_border}',
							'{ra_main_accent_darken}',
							'{ra_secondary_accent_darken}',
							'{ra_main_text_darken}',
							'{ra_site_background_darken}',
							'{ra_main_background_darken}',
							'{ra_main_background_x_darken}',
							'{ra_main_border_darken}',
							'{ra_main_border_x_darken}'
						);

						$replace = array(
							$ra_head_index_bg,
							$ra_head_other_bg,
							$ra_head_index_sticky_bg,
							$ra_head_other_sticky_bg,
							$ra_head_index_img,
							$ra_head_other_img,
							$ra_main_accent,
							$ra_secondary_accent,
							$ra_main_text,
							$ra_secondary_text,
							$ra_site_background,
							$ra_main_background,
							$ra_main_border,
							$ra_main_accent_darken,
							$ra_secondary_accent_darken,
							$ra_main_text_darken,
							$ra_site_background_darken,
							$ra_main_background_darken,
							$ra_main_background_x_darken,
							$ra_main_border_darken,
							$ra_main_border_x_darken
						);

						$fs = new Filesystem();

						$css_output = str_replace($search, $replace, $css_output);

						try {
							if ($color_variant == 0) {
								$fs->dumpFile($phpbb_root_path . 'ext/gramziu/ravaio/assets/colors.min.css', $css_output);
							} else if ($color_variant == 1) {
								$fs->dumpFile($phpbb_root_path . 'ext/gramziu/ravaio/assets/colors_secondary.min.css', $css_output);
							} else if ($color_variant == 2) {
								$fs->dumpFile($phpbb_root_path . 'ext/gramziu/ravaio/assets/colors_tertiary.min.css', $css_output);
							} else if ($color_variant == 3) {
								$fs->dumpFile($phpbb_root_path . 'ext/gramziu/ravaio/assets/colors_quaternary.min.css', $css_output);
							}
						} catch (IOExceptionInterface $e) {
							echo "An error occurred while creating your file at ".$e->getPath();
						}

						$ra_head_index_bg = setVariantVar('ra_head_index_bg', $color_variant);
						$ra_head_other_bg = setVariantVar('ra_head_other_bg', $color_variant);
						$ra_head_index_sticky_bg = setVariantVar('ra_head_index_sticky_bg', $color_variant);
						$ra_head_other_sticky_bg = setVariantVar('ra_head_other_sticky_bg', $color_variant);

						$ra_main_accent = setVariantVar('ra_main_accent', $color_variant);
						$ra_secondary_accent = setVariantVar('ra_secondary_accent', $color_variant);
						$ra_main_text = setVariantVar('ra_main_text', $color_variant);
						$ra_secondary_text = setVariantVar('ra_secondary_text', $color_variant);
						$ra_site_background = setVariantVar('ra_site_background', $color_variant);
						$ra_main_background = setVariantVar('ra_main_background', $color_variant);
						$ra_main_border = setVariantVar('ra_main_border', $color_variant);
						$ra_main_background_darken = setVariantVar('ra_main_background_darken', $color_variant, $ra_main_background_darken);

						add_log('admin', $log . '_EXP');
						trigger_error($message . adm_back_link($this->u_action . '&color_variant=' . $color_variant));
					}

					if ($update_index)
					{
						if (!check_form_key($form_name))
						{
							trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
						}

						$error = array();

						$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];
						$log = 'ACP_RAVAIO_LOG_COLOURS';

						$ra_s_head_index_img = getVariantVar('ra_s_head_index_img', 'single', $color_variant);

						if (!$ra_s_head_index_img)
						{
							$ra_s_head_index_img = setVariantVar('ra_s_head_index_img', $color_variant);

							$prepared_var = getVariantVar('ra_head_index_img', 'full', $color_variant);
							$prepared_var[$color_variant] = 0;
							$prepared_var = serialize($prepared_var);

							set_config('ra_head_index_img', $prepared_var);
						}
						else
						{
							$ra_s_head_index_img = setVariantVar('ra_s_head_index_img', $color_variant);

							$this->uploadVariantImage('ra_head_index_img', $color_variant);
						}

						add_log('admin', $log . '_EXP');
					}
					else if ($update_other)
					{
						if (!check_form_key($form_name))
						{
							trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
						}

						$error = array();

						$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];
						$log = 'ACP_RAVAIO_LOG_COLOURS';

						$ra_s_head_other_img = getVariantVar('ra_s_head_other_img', 'single', $color_variant);

						if (!$ra_s_head_other_img)
						{
							$ra_s_head_other_img = setVariantVar('ra_s_head_other_img', $color_variant);

							$prepared_var = getVariantVar('ra_head_other_img', 'full', $color_variant);
							$prepared_var[$color_variant] = 0;
							$prepared_var = serialize($prepared_var);

							set_config('ra_head_other_img', $prepared_var);
						}
						else
						{
							$ra_s_head_other_img = setVariantVar('ra_s_head_other_img', $color_variant);

							$this->uploadVariantImage('ra_head_other_img', $color_variant);
						}

						add_log('admin', $log . '_EXP');
					}

					$template->assign_vars(array(
						'S_COLOR_VARIANT'	=> true,
						'S_COLOURS'			=> true,

						'RA_COLOR_VARIANT'	=> $color_variant,

						'RA_HEAD_INDEX_BG'		=> getVariantVar('ra_head_index_bg', 'single', $color_variant),
						'RA_HEAD_OTHER_BG'		=> getVariantVar('ra_head_other_bg', 'single', $color_variant),
						'RA_HEAD_INDEX_STICKY_BG'	=> getVariantVar('ra_head_index_sticky_bg', 'single', $color_variant),
						'RA_HEAD_OTHER_STICKY_BG'	=> getVariantVar('ra_head_other_sticky_bg', 'single', $color_variant),

						'RA_HEAD_INDEX_IMG'		=> getVariantVar('ra_head_index_img', 'single', $color_variant) . '?r=' . rand(0, 99999),
						'RA_HEAD_OTHER_IMG'		=> getVariantVar('ra_head_other_img', 'single', $color_variant) . '?r=' . rand(0, 99999),

						'RA_S_HEAD_INDEX_IMG'		=> getVariantVar('ra_s_head_index_img', 'single', $color_variant),
						'RA_S_HEAD_OTHER_IMG'		=> getVariantVar('ra_s_head_other_img', 'single', $color_variant),

						'RA_MAIN_ACCENT'		=> getVariantVar('ra_main_accent', 'single', $color_variant),
						'RA_SECONDARY_ACCENT'	=> getVariantVar('ra_secondary_accent', 'single', $color_variant),
						'RA_MAIN_TEXT'			=> getVariantVar('ra_main_text', 'single', $color_variant),
						'RA_SECONDARY_TEXT'		=> getVariantVar('ra_secondary_text', 'single', $color_variant),
						'RA_SITE_BACKGROUND'	=> getVariantVar('ra_site_background', 'single', $color_variant),
						'RA_MAIN_BACKGROUND'	=> getVariantVar('ra_main_background', 'single', $color_variant),
						'RA_MAIN_BORDER'		=> getVariantVar('ra_main_border', 'single', $color_variant),

						'U_ACTION'				=> $this->u_action . '&color_variant=' . $color_variant,
						)
					);
				} else {
					$ra_color_variants = unserialize($config['ra_color_variants']);
					$ra_s_variants = request_var('ra_s_variants', $config['ra_s_variants']);
					$ra_variant_default = request_var('ra_variant_default', $config['ra_variant_default']);
					$ra_variant_enabled = unserialize($config['ra_variant_enabled']);
	
					if ($submit)
					{
						if (!check_form_key($form_name))
						{
							trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
						}

						$error = array();

						$ra_color_variants = utf8_normalize_nfc(request_var('ra_color_variants', array(0 => 'Main', 1 => 'Secondary', 2 => 'Tertiary'), true));
						$ra_color_variants = serialize($ra_color_variants);
						$ra_variant_enabled = request_var('ra_variant_enabled', array(0 => 1, 1 => 0, 2 => 0));
						$ra_variant_enabled = serialize($ra_variant_enabled);

						set_config('ra_color_variants', $ra_color_variants);
						set_config('ra_s_variants', $ra_s_variants);
						set_config('ra_variant_default', $ra_variant_default);
						set_config('ra_variant_enabled', $ra_variant_enabled);

						$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];
						$log = 'ACP_RAVAIO_LOG_COLOURS';

						add_log('admin', $log . '_EXP');
						trigger_error($message . adm_back_link($this->u_action));
					}

					foreach ($ra_color_variants as $i => $variant)
					{
						$template->assign_block_vars('color_variants', array(
							'NAME'		=> $variant,
							'URL'		=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=colours&amp;color_variant='.$i),
							'INDEX'		=> $i,
							'STATUS'	=> $ra_variant_enabled[$i],
							'DELETE'	=> append_sid($phpbb_admin_path.'index.'.$phpEx, 'i=-gramziu-ravaio-acp-ravaio_module&amp;mode=colours&amp;ra_delete='.$i)
						));
					}

					$template->assign_vars(array(
						'S_COLOR_VARIANT'	=> false,
						'S_COLOURS'			=> true,
						'RA_S_VARIANTS'		=> $ra_s_variants,
						'RA_VARIANT_DEFAULT'	=> $ra_variant_default,
						)
					);
				}

				$this->tpl_name = 'ravaio_main';
				$this->page_title = 'ACP_RAVAIO_COLOURS';
			break;

			case 'header':
				$update_logo = (isset($_POST['update_logo'])) ? true : false;

				$ra_logo = $config['ra_logo'] . '?r=' . rand(0, 99999);
				$ra_logo_width = request_var('ra_logo_width', $config['ra_logo_width']);
				$ra_logo_height = request_var('ra_logo_height', $config['ra_logo_height']);
				$ra_logo_type = request_var('ra_logo_type', $config['ra_logo_type']);
				$ra_logo_text = utf8_normalize_nfc(request_var('ra_logo_text', $config['ra_logo_text'], true));
				$ra_site_desc = request_var('ra_site_desc', $config['ra_site_desc']);
				$ra_site_desc_text_align = request_var('ra_site_desc_text_align', $config['ra_site_desc_text_align']);
				$ra_site_desc_ref_point = request_var('ra_site_desc_ref_point', $config['ra_site_desc_ref_point']);
				$ra_site_desc_pos_top = request_var('ra_site_desc_pos_top', $config['ra_site_desc_pos_top']);
				$ra_site_desc_pos_left = request_var('ra_site_desc_pos_left', $config['ra_site_desc_pos_left']);
				$ra_site_desc_pos_right = request_var('ra_site_desc_pos_right', $config['ra_site_desc_pos_right']);
				$ra_site_desc_pos_bottom = request_var('ra_site_desc_pos_bottom', $config['ra_site_desc_pos_bottom']);
				$ra_head_index_text = request_var('ra_head_index_text', $config['ra_head_index_text']);
				$ra_head_type = request_var('ra_head_type', $config['ra_head_type']);

				if ($update_logo)
				{
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
					}

					$error = array();

					$message = $user->lang['ACP_RAVAIO_LOG_COLOURS'];
					$log = 'ACP_RAVAIO_LOG_COLOURS';

					$form_name = 'ra_logo';

					$files_factory = new \phpbb\files\factory($phpbb_container);

					$upload = $files_factory->get('files.upload')
						->set_allowed_extensions(array('jpg', 'jpeg', 'svg', 'png', 'gif'));

					$upload_dir = 'ext/gramziu/ravaio/assets';

					$form_upload_name = $request->file($form_name);
					$form_upload_name = $form_upload_name['name'];

					if ($form_upload_name != '')
					{
						if (!is_writable($phpbb_root_path . $upload_dir))
						{
							trigger_error('Assets directory not writable' . adm_back_link($this->u_action), E_USER_WARNING);
						}

						$file = $upload->handle_upload('files.types.form', $form_name);

						if ($file->get('error'))
						{
							trigger_error(implode('<br />', $file->get('error')) . adm_back_link($this->u_action), E_USER_WARNING);
						}
						else
						{
							if ($file->get('extension') == 'svg')
							{
								$xml = simplexml_load_file($file->get('filename'));
								$attr = $xml->attributes();

								$ra_logo_width = $attr->width . 'px';
								$ra_logo_height = $attr->height . 'px';
								set_config('ra_logo_width', $ra_logo_width);
								set_config('ra_logo_height', $ra_logo_height);
							}
							else
							{
								$imagesize = getimagesize($request->file($form_name)['tmp_name']);
								$ra_logo_width = $imagesize[0] . 'px';
								$ra_logo_height = $imagesize[1] . 'px';
								set_config('ra_logo_width', $ra_logo_width);
								set_config('ra_logo_height', $ra_logo_height);
							}

							$file->move_file($upload_dir, true, false, CHMOD_ALL);
							chmod($file->get('destination_file'), 0644);

							$ra_logo_path = $phpbb_root_path . $upload_dir . '/';
							$ra_logo_ext = pathinfo($ra_logo_path . $file->get('realname'), PATHINFO_EXTENSION);
							$ra_logo = 'site_logo.' . $ra_logo_ext;

							rename($ra_logo_path . $file->get('realname'), $ra_logo_path . $ra_logo);

							set_config('ra_logo', $ra_logo);
						}
					}
					else
					{
						trigger_error($user->lang['EMPTY_FILEUPLOAD'] . adm_back_link($this->u_action), E_USER_WARNING);
					}

					add_log('admin', $log . '_EXP');
				}

				if ($submit)
				{
					if (!check_form_key($form_name))
					{
						trigger_error($user->lang['FORM_INVALID']. adm_back_link($this->u_action), E_USER_WARNING);
					}

					$error = array();

					$message = $user->lang['ACP_RAVAIO_LOG_HEADER'];
					$log = 'ACP_RAVAIO_LOG_HEADER';

					$ra_site_desc_pos_prepared = 'top: ' . $ra_site_desc_pos_top . '; left: ' . $ra_site_desc_pos_left . '; right: ' . $ra_site_desc_pos_right . '; bottom: ' . $ra_site_desc_pos_bottom . ';';

					$site_desc_text_align_map = array(
						0 => 'center',
						1 => 'left',
						2 => 'right'
					);

					$ra_site_desc_pos_prepared .= ' text-align: ' . $site_desc_text_align_map[$ra_site_desc_text_align] . ';';
					$ra_site_desc_pos_prepared .= ($ra_site_desc_ref_point) ? ' transform: none;' : '';

					set_config('ra_logo_width', $ra_logo_width);
					set_config('ra_logo_height', $ra_logo_height);
					set_config('ra_logo_type', $ra_logo_type);
					set_config('ra_logo_text', $ra_logo_text);
					set_config('ra_site_desc', $ra_site_desc);
					set_config('ra_site_desc_text_align', $ra_site_desc_text_align);
					set_config('ra_site_desc_ref_point', $ra_site_desc_ref_point);
					set_config('ra_site_desc_pos_top', $ra_site_desc_pos_top);
					set_config('ra_site_desc_pos_left', $ra_site_desc_pos_left);
					set_config('ra_site_desc_pos_right', $ra_site_desc_pos_right);
					set_config('ra_site_desc_pos_bottom', $ra_site_desc_pos_bottom);
					set_config('ra_head_index_text', $ra_head_index_text);
					set_config('ra_head_type', $ra_head_type);

					set_config('ra_site_desc_pos_prepared', $ra_site_desc_pos_prepared);

					add_log('admin', $log . '_EXP');
					trigger_error($message . adm_back_link($this->u_action));
				}

				$template->assign_vars(array(
					'S_HEADER'					=> true,

					'RA_LOGO'					=> $ra_logo,
					'RA_LOGO_WIDTH'				=> $ra_logo_width,
					'RA_LOGO_HEIGHT'			=> $ra_logo_height,
					'RA_LOGO_TYPE'				=> $ra_logo_type,
					'RA_LOGO_TEXT'				=> $ra_logo_text,
					'RA_SITE_DESC'				=> $ra_site_desc,
					'RA_SITE_DESC_TEXT_ALIGN'	=> $ra_site_desc_text_align,
					'RA_SITE_DESC_REF_POINT'	=> $ra_site_desc_ref_point,
					'RA_SITE_DESC_POS_TOP'		=> $ra_site_desc_pos_top,
					'RA_SITE_DESC_POS_LEFT'		=> $ra_site_desc_pos_left,
					'RA_SITE_DESC_POS_RIGHT'	=> $ra_site_desc_pos_right,
					'RA_SITE_DESC_POS_BOTTOM'	=> $ra_site_desc_pos_bottom,
					'RA_HEAD_INDEX_TEXT'		=> $ra_head_index_text,
					'RA_HEAD_TYPE'				=> $ra_head_type,

					'SITENAME'					=> $config['sitename'],
					'SITE_DESCRIPTION'			=> $config['site_desc']
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

	public function uploadVariantImage($form_name, $variant)
	{
		global $request, $user, $phpbb_root_path, $phpEx, $phpbb_container;

		$files_factory = new \phpbb\files\factory($phpbb_container);

		$upload = $files_factory->get('files.upload')
			->set_allowed_extensions(array('jpg', 'jpeg', 'svg', 'png', 'gif'));

		$upload_dir = 'ext/gramziu/ravaio/assets';

		$form_upload_name = $request->file($form_name);
		$form_upload_name = $form_upload_name['name'];

		if ($form_upload_name != '')
		{
			if (!is_writable($phpbb_root_path . $upload_dir))
			{
				trigger_error('Assets directory not writable' . adm_back_link($this->u_action . '&color_variant=' . $variant), E_USER_WARNING);
			}

			$file = $upload->handle_upload('files.types.form', $form_name);

			if ($file->get('error'))
			{
				trigger_error(implode('<br />', $file->get('error')) . adm_back_link($this->u_action . '&color_variant=' . $variant), E_USER_WARNING);
			}
			else
			{
				$new_path = $phpbb_root_path . $upload_dir . '/';
				$new_extension = pathinfo($new_path . $file->get('realname'), PATHINFO_EXTENSION);
				$new_name = $form_name . '_' . $variant . '.' . $new_extension;

				$file->move_file($upload_dir, true, false, CHMOD_ALL);
				chmod($file->get('destination_file'), 0644);

				rename($new_path . $file->get('realname'), $new_path . $new_name);

				setVariantVar($form_name, $variant, $new_name);
			}
		}
		else
		{
			trigger_error($user->lang['EMPTY_FILEUPLOAD'] . adm_back_link($this->u_action . '&color_variant=' . $variant), E_USER_WARNING);
		}
	}
}

?>
