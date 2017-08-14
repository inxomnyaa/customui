<?php

namespace xenialdan\customui\network;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\DataPacket;

class ModalFormRequestPacket extends DataPacket{
	const NETWORK_ID = ProtocolInfo::MODAL_FORM_REQUEST_PACKET;

	/** @var int */
	public $formId;
	/** @var string */
	public $formData; //json

	public function decodePayload(){
		$this->formId = $this->getUnsignedVarInt();
		$this->formData = $this->getString();
	}

	public function encodePayload(){
		$this->putUnsignedVarInt($this->formId);
		$this->putString($this->formData);
	}

	public function handle(NetworkSession $session): bool{
		return true;
	}
}