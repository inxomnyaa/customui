<?php

namespace xenialdan\customui\windows;

use Exception;
use pocketmine\Player;
use xenialdan\customui\CustomUI;
use xenialdan\customui\elements\simpleForm\Button;

class SimpleForm implements CustomUI{

	/** @var string */
	protected $title = '';
	/** @var string */
	protected $content = '';
	/** @var Button[] */
	protected $buttons = [];
	/** @var string */
	protected $json = '';

	/**
	 *
	 * @param string $title
	 * @param string $content
	 */
	public function __construct($title, $content){
		$this->title = $title;
		$this->content = $content;
	}

	/**
	 * Add button to form
	 *
	 * @param Button $button
	 */
	public function addButton(Button $button){
		$this->buttons[] = $button;
		$this->json = '';
	}

	/**
	 * Convert class to JSON string
	 *
	 * @return string
	 */
	final public function toJSON(){//serialize
		if ($this->json != ''){
			return $this->json;
		}
		$data = [
			'type' => 'form',
			'title' => $this->title,
			'content' => $this->content,
			'buttons' => []
		];
		foreach ($this->buttons as $button){
			$data['buttons'][] = $button->getDataToJson();
		}
		return $this->json = json_encode($data);
	}

	/**
	 * To handle manual closing
	 * @param Player $player
	 */
	public function close(Player $player){
	}

	/**
	 *
	 *
	 * @param int $response Button index
	 * @param Player $player
	 * @throws Exception
	 */
	final public function handle($response, Player $player){
		if (isset($this->buttons[$response])){
			$this->buttons[$response]->handle(true, $player);
		} else{
			error_log(__CLASS__ . '::' . __METHOD__ . " Button with index {$response} doesn't exists.");
		}
	}
}
