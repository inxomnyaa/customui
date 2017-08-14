<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\elements\Button;
use xenialdan\customui\network\ModalFormRequestPacket;
use xenialdan\customui\windows\SimpleForm;

class TestSimpleSubCommand extends SubCommand{

	public function canUse(CommandSender $sender){
		return ($sender instanceof Player) and $sender->hasPermission("cui.command.testsimple");
	}

	public function getUsage(){
		return "testsimple";
	}

	public function getName(){
		return "testsimple";
	}

	public function getDescription(){
		return "test a simple gui";
	}

	public function getAliases(){
		return [];
	}

	/**
	 * @param CommandSender $sender
	 * @param array $args
	 * @return bool
	 */
	public function execute(CommandSender $sender, array $args){
		$player = $sender->getServer()->getPlayer($sender->getName());
		$ui = new SimpleForm('A simple form with buttons only', '');
		$ui->addButton(new Button('Button'));
		$button2 = new Button('ImageButton');
		$button2->addImage(Button::IMAGE_TYPE_URL, 'https://server.wolvesfortress.de/MCPEGUIimages/hd/X.png');
		$ui->addButton($button2);
		$pk = new ModalFormRequestPacket();
		$pk->formId = 1;
		$pk->formData = json_encode($ui);
		var_dump($pk);
		$player->dataPacket($pk);
		return true;
	}
}
