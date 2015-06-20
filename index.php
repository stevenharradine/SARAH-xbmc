<?php
	require_once '../../views/_secureHead.php';
	require_once '../../models/_header.php';
	require_once '../../models/_add.php';
	require_once 'views/_selectRemote.php';

	if( isset ($sessionManager) && $sessionManager->isAuthorized () ) {
		$remote_id = request_isset ('remote_id');
		$name = request_isset ('name');
		$url = request_isset ('url');

		switch ( $page_action ) {
			case 'delete_by_id':
				XbmcRemoteManager::deleteById($remote_id);
				break;
			case 'add_remote':
				XbmcRemoteManager::addRemote($name, $url);
				break;
		}

		$remotes_data = XbmcRemoteManager::getRemotes();
		$remote_url = XbmcRemoteManager::getUrl($remote_id);
		$playerid = XbmcRemoteManager::getActivePlayers($remote_url)['playerid'];
		$volumeLevel = XbmcRemoteManager::getVolume ($remote_url);
		$playerProperties = XbmcRemoteManager::getPlayerProperties ($remote_url, $playerid);
		$runTime = $playerProperties['time'];
		$totalTime = $playerProperties['totaltime'];
		$percentTime = $playerProperties['percentage'];
		$playingItem = XbmcRemoteManager::getPlayingItem ($remote_url, $playerid);

		$dropdownList = SelectRemoteView::render(array (
			'remote_id' => $remote_id,
			'remotes_data' => $remotes_data
		));

		// build header view
		$headerView = new HeaderView ('XBMC Remote');
		$headerView->setLink ('<link rel="stylesheet" type="text/css" href="css/styles.css" />');
		$headerView->setAltMenu (getAddButton() . $dropdownList . ButtonView::render ( new ButtonModel(
				IconView::render( new IconModel ('minus', 'Delete')),	// label with icon
				"./?action=delete_by_id&remote_id=$remote_id",			// link
				'delete'												// class
			))
		);

		// build add view
		$addView = new AddView ('Add', 'add_remote');
		$addView->addRow ('name', 'Name');
		$addView->addRow ('url', 'URL');

		$views_to_load = array();
		$views_to_load[] = '../../views/_add.php';
		$views_to_load[] = '_remote.php';
		$views_to_load[] = '_progress.php';
		
		include '../../views/_generic.php';
	}