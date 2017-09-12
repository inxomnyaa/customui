<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\API;
use xenialdan\customuitest\Loader;

class TestModalSubCommand extends SubCommand{

	public function canUse(CommandSender $sender){
		return ($sender instanceof Player) and $sender->hasPermission("cui.command.testmodal");
	}

	public function getUsage(){
		return "testmodal";
	}

	public function getName(){
		return "testmodal";
	}

	public function getDescription(){
		return "test a modal gui";
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
		API::showUIbyID($this->getPlugin(), Loader::$modalUI, $sender);
		return true;
	}
}
