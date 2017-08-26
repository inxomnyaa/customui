<?php

namespace xenialdan\customuitest;

use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\plugin\PluginBase;
use xenialdan\customui\network\ModalFormRequestPacket;
use xenialdan\customui\network\ModalFormResponsePacket;
use xenialdan\customui\network\ServerSettingsRequestPacket;
use xenialdan\customui\network\ServerSettingsResponsePacket;

class Loader extends PluginBase{

	public function onEnable(){
		$this->getServer()->getCommandMap()->register(Commands::class, new Commands($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		PacketPool::registerPacket(new ModalFormRequestPacket());
		PacketPool::registerPacket(new ModalFormResponsePacket());
		PacketPool::registerPacket(new ServerSettingsRequestPacket());
		PacketPool::registerPacket(new ServerSettingsResponsePacket());
	}
}