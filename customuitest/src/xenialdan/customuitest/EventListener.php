<?php

namespace xenialdan\customuitest;

use pocketmine\block\Block;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\Item;
use pocketmine\nbt\tag\ListTag;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use pocketmine\tile\ItemFrame;
use pocketmine\utils\TextFormat;
use xenialdan\customui\event\UICloseEvent;
use xenialdan\customui\event\UIDataReceiveEvent;
use xenialdan\customui\network\ModalFormResponsePacket;

class EventListener implements Listener{
	/** @var Loader */
	public $owner;

	public function __construct(Plugin $plugin){
		$this->owner = $plugin;
	}

	public function onPacket(DataPacketReceiveEvent $ev){
		$packet = $ev->getPacket();
		switch ($packet::NETWORK_ID){
			case ModalFormResponsePacket::NETWORK_ID: {
				/** @var ModalFormResponsePacket $packet */
				$this->handleModalFormResponse($packet);
				$packet->reset();
				$ev->setCancelled(true);
				break;
			}
		}
	}

	public function handleModalFormResponse(ModalFormResponsePacket $packet): bool{
		$ev = new UIDataReceiveEvent($packet);
		if(empty($ev->getData())) $ev = new UICloseEvent($packet);
		else{
			//DO ANYTHING WITH THE DATA
			//simple returns the button index
			//modal returns true|false
			//custom returns the data of all fields that have been requested
			var_dump($ev->getData());
		}
		Server::getInstance()->getPluginManager()->callEvent($ev);
		return true;
	}
}