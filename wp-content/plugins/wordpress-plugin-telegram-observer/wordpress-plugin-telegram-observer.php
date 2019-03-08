<?php
	/*
		Plugin Name: Telegram Observer
		Description: Observer wordpress actions with telegram.
		author: albertrein
		version: 0.0.6
	*/

	// define('plugin-path',plugin_dir_path(__FILE__));	
	define('plugin-path','wp-content/plugins/plugin-5'); //for local tests
	
	//requires
	require_once("telegram-api/telegram-api-class.php");
	require_once("admin/admin-pages.php");
	


	$arrayActions = unserialize(get_option('telegram-observer-data'));

	if(!get_option('telegram-observer-chatID') && !get_option('telegram-observer-botToken')){
		//No data information telegram was saved
		return 0;
	}

	if(!$arrayActions){
		//No data actions was saved yet!
		return 0;
	}

	foreach ($arrayActions as $key => $value) {
		$messageToSend = $value['message'];
		add_action($value['actionName'],function() use ($messageToSend){
			TelegramApi::sendMessage(get_option('telegram-observer-chatID'), $messageToSend, get_option('telegram-observer-botToken'));			
		},10);
	}

?>