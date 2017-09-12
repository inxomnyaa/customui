<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\API;
use xenialdan\customuitest\Loader;

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
		API::showUIbyID($this->getPlugin(), Loader::$simpleUI, $sender);
		return true;
	}
}
