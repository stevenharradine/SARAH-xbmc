<?php
	require_once '../../views/_secureHead.php';
	require_once '../../models/_header.php';

	if( isset ($sessionManager) && $sessionManager->getUserType() == 'ADMIN' ) {
		$xbmcRemoteManager = new XbmcRemoteManager ();

		$xbmcRemoteManager->init();

		// build header view
		$headerView = new HeaderView ('Remote | XBMC Remote');
		$headerView->setLink ('<link rel="stylesheet" type="text/css" href="css/styles.css" />');

		$views_to_load = array();

		include '../../views/_generic.php';
	}