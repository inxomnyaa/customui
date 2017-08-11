<?php

namespace xenialdan\customui\network;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\DataPacket;

class GuiDataPickItemPacket extends DataPacket{
	const NETWORK_ID = ProtocolInfo::GUI_DATA_PICK_ITEM_PACKET;

	/** @var int */
	public $hotbarSlot;

	public function decodePayload(){
		$this->hotbarSlot = $this->getLInt();
	}

	public function encodePayload(){
		$this->putLInt($this->hotbarSlot);
	}

	public function handle(NetworkSession $session) : bool{
		var_dump($this);
		return true;
	}
}