<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\network\ModalFormRequestPacket;
use xenialdan\customui\windows\CustomForm;

class TestCustomSubCommand extends SubCommand{

	public function canUse(CommandSender $sender){
		return ($sender instanceof Player) and $sender->hasPermission("cui.command.testcustom");
	}

	public function getUsage(){
		return "testcustom";
	}

	public function getName(){
		return "testcustom";
	}

	public function getDescription(){
		return "test a custom gui";
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
		$ui = new CustomForm('Testwindow');
		$ui->addElement(new Label('Label'));
		$ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
		$ui->addElement(new Input('Input', 'text'));
		$ui->addElement(new Slider('Slider', 5, 10, 0.5));
		$ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
		$ui->addElement(new Toggle('Toggle'));
		$pk = new ModalFormRequestPacket();
		$pk->formId = 1;
		$pk->formData = json_encode($ui);
		var_dump($pk);
		$player->dataPacket($pk);
		return true;
	}
}
