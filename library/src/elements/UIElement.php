<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

abstract class UIElement {
	
	protected $text = '';
	
	/**
	 * @return array
	 */
	abstract public function getDataToJson();

	/**
	 * @param $value
	 * @param Player $player
	 * @return
	 */
	abstract public function handle($value, Player $player);
	
}
