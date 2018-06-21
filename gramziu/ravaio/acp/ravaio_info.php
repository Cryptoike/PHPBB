<?php

namespace gramziu\ravaio\acp;

class ravaio_info
{
	function module()
	{
		return array(
			'filename'	=> '\gramziu\ravaio\acp\ravaio_module',
			'title'		=> 'ACP_RAVAIO',
			'modes'		=> array(
				'general'		=> array(
					'title'	=> 'ACP_RAVAIO_GENERAL',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'colours'		=> array(
					'title'	=> 'ACP_RAVAIO_COLOURS',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'header'		=> array(
					'title'	=> 'ACP_RAVAIO_HEADER',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'header_menu'	=> array(
					'title'	=> 'ACP_RAVAIO_HEADER_MENU',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'sidebar'		=> array(
					'title'	=> 'ACP_RAVAIO_SIDEBAR',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'footer'		=> array(
					'title'	=> 'ACP_RAVAIO_FOOTER',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'footer_blocks'	=> array(
					'title'	=> 'ACP_RAVAIO_FOOTER_BLOCKS',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				),
				'footer_menu'	=> array(
					'title'	=> 'ACP_RAVAIO_FOOTER_MENU',
					'auth'	=> 'acl_a_board',
					'cat'	=> array('ACP_RAVAIO')
				)
			)
		);
	}
}
