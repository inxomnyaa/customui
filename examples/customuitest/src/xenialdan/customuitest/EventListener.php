<?php

namespace xenialdan\customuitest;

use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\Server;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\event\UICloseEvent;
use xenialdan\customui\event\UIDataReceiveEvent;
use xenialdan\customui\network\ModalFormResponsePacket;
use xenialdan\customui\network\ServerSettingsRequestPacket;
use xenialdan\customui\network\ServerSettingsResponsePacket;
use xenialdan\customui\windows\CustomForm;

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
	 * @param ServerSettingsRequestPacket $packet
	 * @param Player $player
	 * @return bool
	 */
	public function handleServerSettingsRequestPacket(ServerSettingsRequestPacket $packet, Player $player): bool{
		// TODO maybe add event
		$ui = new CustomForm('Server settings'); // TODO figure out how to add an image in the settings gui
		$ui->addElement(new Label('Label'));
		$ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
		$ui->addElement(new Input('Input', 'text'));
		$ui->addElement(new Slider('Slider', 5, 10, 0.5));
		$ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
		$ui->addElement(new Toggle('Toggle'));
		$pk = new ServerSettingsResponsePacket();
		$pk->formId = 0;
		$pk->formData = json_encode($ui);
		var_dump($pk);
		$player->dataPacket($pk);
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
	 * @param UIDataReceiveEvent $event
	 */
	public function onUIDataReceiveEvent(UIDataReceiveEvent $event){
		switch ($event->getID()){
			case '0': {
				print 'ServerSettingsResponsePacket' . PHP_EOL . var_export($event->getData(), true);
				break;
			}
			case '1': {
				print 'ModalFormResponsePacket' . PHP_EOL . var_export($event->getData(), true);
				break;
			}
			default: {
				print 'Any other formId' . PHP_EOL . var_export($event->getData(), true);
				break;
			}
		}
	}
}