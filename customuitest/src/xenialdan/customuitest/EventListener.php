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

	/**
	 * @group UI Response Handling
	 * @param DataPacketReceiveEvent $ev
	 */
	public function onPacket(DataPacketReceiveEvent $ev){
		$packet = $ev->getPacket();
		$player = $ev->getPlayer();
		switch ($packet::NETWORK_ID){
			case ModalFormResponsePacket::NETWORK_ID: {
				/** @var ModalFormResponsePacket $packet */
				$this->handleModalFormResponse($packet, $player);
				$packet->reset();
				$ev->setCancelled(true);
				break;
			}
		}
	}

	/**
	 * @group UI Response Handling
	 * @param ModalFormResponsePacket $packet
	 * @param Player $player
	 * @return bool
	 */
	public function handleModalFormResponse(ModalFormResponsePacket $packet, Player $player): bool{
		$ev = new UIDataReceiveEvent($packet, $player);
		if (empty($ev->getData())) $ev = new UICloseEvent($packet, $player);
		Server::getInstance()->getPluginManager()->callEvent($ev);
		return true;
	}
}