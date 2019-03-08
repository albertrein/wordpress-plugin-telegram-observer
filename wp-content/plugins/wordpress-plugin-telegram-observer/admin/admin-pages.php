<?php
	add_action('admin_menu','createMenuOptions');

	function createMenuOptions(){
		add_menu_page('Telegram Observer Plugin', 'Telegram Observer', 'manage_options', 'telegram-observer-options', 'renderPageNewActionObserver');
		//add_submenu_page('telegram-observer-options', 'Telegram Observer Plugin', 'Telegram Observer Plugin New Action Observer', 'manage_options', 'new_action_observer_page', 'renderPageNewActionObserver');
		add_submenu_page('telegram-observer-options', 'Telegram Observer Plugin', 'Telegram Observer Plugin - Telegram Info', 'manage_options', 'telegram_information_access_page', 'renderPageTelegramInfo');
	}

	function renderPageNewActionObserver(){ ?>
		<div class="wrap">
			<h1>Telegram Observer - New Action Observer</h1>
			<p class="description">Here you can insert new action to oberver when was activated and receive a message on telegram.</p>
			<div>
				<form action="" method="POST">
					<div style="width: 100%;">
						<input type="text" name="actionName" style="width: 25%; font-size: 20px;" placeholder="Action Name">
						<input type="text" name="message" style="width: 25%;margin: 10px 0px;font-size: 20px;" placeholder="Message to Telegram">
						<input type="submit" style="display: block;background-color: #4CAF50;border: solid #4CAF50;border-radius: 5%; width: 50%; font-size: 16px;color: #fff;">				
					</div>
				</form>
				<?php
					if(isset($_POST['actionName']) && isset($_POST['message'])){
						if(saveDataIntoOptions($_POST['actionName'],$_POST['message'], 'telegram-observer-data'))
							echo "<p style='color: green;'>Save!</p>";
					}
				?>
			</div>
		</div>
	<?php }

	function renderPageTelegramInfo(){ ?>
		<div class="wrap">
			<h1>Telegram Observer - Telegram Informations</h1>
			<p class="description">Here you can insert infomations to API access telegram chat.</p>
			<div>
				<form action="" method="POST">
					<div style="width: 100%;">
						<input type="text" name="chatId" style="width: 25%; font-size: 20px;" placeholder="Chat ID">
						<input type="text" name="botToken" style="width: 25%;margin: 10px 0px;font-size: 20px;" placeholder="BOT Token">
						<input type="submit" style="display: block;background-color: #4CAF50;border: solid #4CAF50;border-radius: 5%; width: 50%; font-size: 16px;color: #fff;">				
					</div>
				</form>
				<?php
					if(isset($_POST['chatId']) && isset($_POST['botToken'])){
						if(saveInformationAccessTelegramAPI($_POST['chatId'],$_POST['botToken']))
							echo "<p style='color: green;'>Save!</p>";
					}
				?>
			</div>
		</div>
	<?php }

	function saveDataIntoOptions($action, $message, $option_name_insert){
		if(!get_option($option_name_insert)){ //Verificando se existe o registro na tabela
			$array = array();
			add_option($option_name_insert,serialize($array));
		}

		$newRow = array( //Creating new data
			'actionName' => $action,
			'message' => $message,
		);

		//Unserializing data from table
		$objetoSerializado = get_option($option_name_insert);
		$objetoDesSerializado = unserialize($objetoSerializado);
		array_push($objetoDesSerializado, $newRow);

		//Resaving register
		update_option($option_name_insert, serialize($objetoDesSerializado));

		return true;
	}

	function saveInformationAccessTelegramAPI($chatId, $botToken){
		update_option('telegram-observer-chatID', $chatId);
		update_option('telegram-observer-botToken', $botToken);

		return true;
	}

?>