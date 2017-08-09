<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;
use xenialdan\customui\elements\UIElement;

class Toggle extends UIElement{

	/** @var boolean */
	protected $defaultValue = false;

	/**
	 *
	 * @param string $text
	 * @param bool $value
	 */
	public function __construct($text, bool $value = false){
		$this->text = $text;
		$this->defaultValue = $value;
	}

	/**
	 *
	 * @param bool $value
	 */
	public function setDefaultValue(bool $value){
		$this->defaultValue = $value;
	}

	/**
	 *
	 * @return array
	 */
	final public function getDataToJson(){
		return [
			"type" => "toggle",
			"text" => $this->text,
			"default" => $this->defaultValue
		];
	}

	public function handle($value, Player $player){

	}

}
