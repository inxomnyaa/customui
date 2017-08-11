<?php

namespace xenialdan\customuitest;

use pocketmine\entity\Entity;
use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\plugin\PluginBase;
use xenialdan\customui\network\GuiDataPickItemPacket;
use xenialdan\customui\network\ModalFormRequestPacket;
use xenialdan\customui\network\ModalFormResponsePacket;
use xenialdan\customui\network\ServerSettingsRequestPacket;
use xenialdan\customui\network\ServerSettingsResponsePacket;
use xenialdan\Gadges\entities\mounts\Mount;
use xenialdan\Gadges\entities\mounts\MountChicken;
use xenialdan\Gadges\entities\mounts\MountHorse;
use xenialdan\Gadges\entities\mounts\MountUnicorn;
use xenialdan\Gadges\entities\other\CustomItemProjectile;
use xenialdan\Gadges\entities\other\EtheralPearl;
use xenialdan\Gadges\entities\other\FlameThrower;
use xenialdan\Gadges\entities\other\PaintballProjectile;
use xenialdan\Gadges\entities\other\ThrowableTNT;

class Loader extends PluginBase{

	public function onEnable(){
		$this->getServer()->getCommandMap()->register(Commands::class, new Commands($this));
		PacketPool::registerPacket(new GuiDataPickItemPacket());
		PacketPool::registerPacket(new ModalFormRequestPacket());
		PacketPool::registerPacket(new ModalFormResponsePacket());
		PacketPool::registerPacket(new ServerSettingsRequestPacket());
		PacketPool::registerPacket(new ServerSettingsResponsePacket());
	}
}