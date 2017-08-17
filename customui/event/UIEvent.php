<?php

namespace xenialdan\customui\event;

use pocketmine\event\Event;
use pocketmine\network\mcpe\protocol\DataPacket;
use pocketmine\Player;
use xenialdan\customui\network\ModalFormResponsePacket;

abstract class UIEvent extends Event{

	public static $handlerList = null;

	/** @var DataPacket|ModalFormResponsePacket $packet */
	protected $packet;
	/** @var Player */
	protected $player;

	public function __construct(DataPacket $packet, Player $player){
		$this->packet = $packet;
		$this->player = $player;
	}

	public function getPacket(): DataPacket{
		return $this->packet;
	}

	public function getPlayer(): Player{
		return $this->player;
	}

	public function getID(): int{
		return $this->packet->formId;
	}

}