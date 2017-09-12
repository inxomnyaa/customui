<?php

namespace xenialdan\customui\windows;

use Exception;
use pocketmine\Player;
use xenialdan\customui\CustomUI;

class ModalWindow implements CustomUI, \JsonSerializable{

	/** @var string */
	protected $title = '';
	/** @var string */
	protected $content = '';
	/** @var string */
	protected $trueButtonText = '';
	/** @var string */
	protected $falseButtonText = '';
	/** @var int */
	private $id;

	/**
	 * This is a window to show a simple text to the player
	 *
	 * @param string $title
	 * @param string $content
	 * @param string $trueButtonText
	 * @param string $falseButtonText
	 */
	public function __construct($title, $content, $trueButtonText, $falseButtonText){
		$this->title = $title;
		$this->content = $content;
		$this->trueButtonText = $trueButtonText;
		$this->falseButtonText = $falseButtonText;
	}

	final public function jsonSerialize(){
		return [
			'type' => 'modal',
			'title' => $this->title,
			'content' => $this->content,
			'button1' => $this->trueButtonText,
			'button2' => $this->falseButtonText,
		];
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
		print __FILE__ . ': ' . var_export($response, true);
	}

	final public function getTitle(){
		return $this->title;
	}

	public function getContent(): array{
		return [$this->content, $this->trueButtonText, $this->falseButtonText];
	}

	public function setID(int $id){
		$this->id = $id;
	}

	public function getID(): int{
		return $this->id;
	}
}
