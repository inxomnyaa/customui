<?php

namespace xenialdan\customui;

use pocketmine\Player;

interface CustomUI {

	public function handle($response, Player $player);
	
	public function toJSON();

	/**
	 * To handle manual closing
	 * @param Player $player
	 */
	public function close(Player $player);
}
