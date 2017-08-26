<?php

namespace xenialdan\customui\windows;

use Exception;
use pocketmine\Player;
use customui\CustomUI;
use customui\elements\Button;

class SimpleForm implements CustomUI, \JsonSerializable{

	/** @var string */
	protected $title = '';
	/** @var string */
	protected $content = '';
	/** @var Button[] */
	protected $buttons = [];

	/**
	 * SimpleForm only consists of clickable buttons
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
	}

	final public function jsonSerialize(){
		$data = [
			'type' => 'form',
			'title' => $this->title,
			'content' => $this->content,
			'buttons' => []
		];
		foreach ($this->buttons as $button){
			$data['buttons'][] = $button;
		}
		return $data;
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
		print __FILE__ . ': ' . var_dump($response);
		if (isset($this->buttons[$response])){
			$this->buttons[$response]->handle(true, $player);
		} else{
			error_log(__CLASS__ . '::' . __METHOD__ . " Button with index {$response} doesn't exists.");
		}
	}

	final public function getTitle(){
		return $this->title;
	}

	public function getContent(): array{
		return [$this->content, $this->buttons];
	}
}
