<?php

namespace xenialdan\customui\network;

#include <rules/DataPacket.h>

use pocketmine\network\mcpe\NetworkSession;
use pocketmine\network\mcpe\protocol\DataPacket;

class ServerSettingsRequestPacket extends DataPacket{
	const NETWORK_ID = ProtocolInfo::SERVER_SETTINGS_REQUEST_PACKET;

	public function decodePayload(){
		//No payload
	}

	public function encodePayload(){
		//No payload
	}

	public function handle(NetworkSession $session): bool{
		return true;
	}
}