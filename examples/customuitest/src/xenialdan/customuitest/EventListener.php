<?php

namespace xenialdan\customuitest;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use xenialdan\customui\API;
use xenialdan\customui\API as UIAPI;
use xenialdan\customui\event\UICloseEvent;
use xenialdan\customui\event\UIDataReceiveEvent;
use xenialdan\customui\network\ModalFormResponsePacket;
use xenialdan\customui\network\ServerSettingsRequestPacket;
use xenialdan\customui\network\ServerSettingsResponsePacket;
use xenialdan\customui\windows\CustomForm;

/*
 *  MAKE SURE YOU HAVE THIS AS UIAPI!
 */

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
			case ServerSettingsRequestPacket::NETWORK_ID: {
				/** @var ServerSettingsRequestPacket $packet */
				$this->handleServerSettingsRequestPacket($packet, $player);
				$packet->reset();
				$ev->setCancelled(true);
				break;
			}
			case ServerSettingsResponsePacket::NETWORK_ID: {
				/** @var ServerSettingsResponsePacket $packet */
				$this->handleServerSettingsResponsePacket($packet, $player);
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
		$ev = new UIDataReceiveEvent($this->owner, $packet, $player);
		if (is_null($ev->getData())) $ev = new UICloseEvent($this->owner, $packet, $player);
		Server::getInstance()->getPluginManager()->callEvent($ev);
		return true;
	}

	/**
	 * @group UI Response Handling
	 * @param ServerSettingsResponsePacket $packet
	 * @param Player $player
	 * @return bool
	 */
	public function handleServerSettingsResponsePacket(ServerSettingsResponsePacket $packet, Player $player): bool{
		$ev = new UIDataReceiveEvent($this->owner, $packet, $player);
		if (is_null($ev->getData())) $ev = new UICloseEvent($this->owner, $packet, $player);
		Server::getInstance()->getPluginManager()->callEvent($ev);
		return true;
	}


	/**
	 * @group UI Response Handling
	 * @param ServerSettingsRequestPacket $packet
	 * @param Player $player
	 * @return bool
	 */
	public function handleServerSettingsRequestPacket(ServerSettingsRequestPacket $packet, Player $player): bool{
		// TODO create API for this
		$ui = UIAPI::getPluginUI($this->owner, Loader::$uis['serverSettingsUI']);
		$pk = new ServerSettingsResponsePacket();
		$pk->formId = Loader::$uis['serverSettingsUI'];
		$pk->formData = json_encode($ui);
		$player->dataPacket($pk);
		return true;
	}

	/**
	 * @param UIDataReceiveEvent $event
	 */
	public function onUIDataReceiveEvent(UIDataReceiveEvent $event){
		/* This makes sure that only events for this plugin are handled */
		if($event->getPlugin() !== $this->owner) return;
		print "TESTER!".PHP_EOL;
		switch ($id = $event->getID()){
			case Loader::$uis['modalUI']:
			case Loader::$uis['customUI']:
			case Loader::$uis['serverSettingsUI']: {
				/** @var CustomForm $ui */
				// Create an useful array
				$data = $event->getData();
				// Player
				$ui = UIAPI::getPluginUI($this->owner, $id);
				$response = $ui->handle($data, $event->getPlayer());
				// Now, do whatever you want with the response
				var_dump($response); // Look at the var_dumps and learn from them :)
				break;
			}
			case Loader::$uis['simpleUI']: {
				/** @var CustomForm $ui */
				// Create an useful array
				$data = $event->getData();
				// Player
				$ui = UIAPI::getPluginUI($this->owner, $id);
				$response = $ui->handle($data, $event->getPlayer());
				// Now, do whatever you want with the response
				var_dump($response); // In this case it returns the text of the clicked button :)
				switch ($response){
					case 'Button': {
						// an example for running commands
						$command = "say i clicked the button 'Button'";
						$this->owner->getServer()->getCommandMap()->dispatch($event->getPlayer(), $command);
						break;
					}
					case 'ImageButton': {
						$command = "say i clicked the button 'ImageButton'";
						$this->owner->getServer()->getCommandMap()->dispatch($event->getPlayer(), $command);
						break;
					}
				}
				break;
			}
			default: {
				print 'Any other formId' . PHP_EOL;
				var_dump(API::handle($event->getPlugin(), $event->getID(), $event->getData(), $event->getPlayer()));
				break;
			}
		}
	}
}