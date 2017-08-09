<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

abstract class UIElement implements \JsonSerializable{

	protected $text = '';

	/**
	 * Returns an array of item stack properties that can be serialized to json.
	 *
	 * @return array
	 */
	final public function jsonSerialize(){
		return [];
	}

	/**
	 * @param $value
	 * @param Player $player
	 * @return
	 */
	abstract public function handle($value, Player $player);

}
