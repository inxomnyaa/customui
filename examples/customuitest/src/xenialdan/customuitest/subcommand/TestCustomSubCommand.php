<?php

namespace xenialdan\customuitest\subcommand;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use xenialdan\customui\API as UIAPI;
use xenialdan\customuitest\Loader;

class TestCustomSubCommand extends SubCommand
{

    public function canUse(CommandSender $sender)
    {
        return ($sender instanceof Player) and $sender->hasPermission("cui.command.testcustom");
    }

    public function getUsage()
    {
        return "testcustom";
    }

    public function getName()
    {
        return "testcustom";
    }

    public function getDescription()
    {
        return "test a custom gui";
    }

    public function getAliases()
    {
        return [];
    }

    /**
     * @param CommandSender $sender
     * @param array $args
     * @return bool
     * @throws \Exception
     */
    public function execute(CommandSender $sender, array $args)
    {
        // if you want to reload dynamic fields (for example a player list in a dropdown), you also need a reloadUIs call
        $this->getPlugin()->reloadUIs();
        // it does not hurt to call the resetUIs, but might be useless if an UI never changes :)
        UIAPI::showUIbyID($this->getPlugin(), Loader::$uis['customUI'], $sender);
        return true;
    }
}
