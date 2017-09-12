<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\API;
use xenialdan\customuitest\Loader;

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
		API::showUIbyID($this->getPlugin(), Loader::$customUI, $sender);
		return true;
	}
}
