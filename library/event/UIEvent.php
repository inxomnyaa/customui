<?php

namespace xenialdan\customui\event;

use pocketmine\event\Event;
use pocketmine\network\mcpe\protocol\DataPacket;
use xenialdan\customui\network\ModalFormResponsePacket;

abstract class UIEvent extends Event{

	public static $handlerList = null;

	/** @var DataPacket|ModalFormResponsePacket $packet*/
	protected $packet;

	public function __construct(DataPacket $packet){
		$this->packet = $packet;
	}

	public function getPacket() : DataPacket{
		return $this->packet;
	}

	public function getID() : int {
		return $this->packet->formId;
	}

}