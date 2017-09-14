<?php

namespace xenialdan\customui;

use pocketmine\Player;

interface CustomUI{

	public function handle($response, Player $player);

	public function jsonSerialize();

	/**
	 * To handle manual closing
	 * @param Player $player
	 */
	public function close(Player $player);

	public function getTitle();

	public function getContent(): array;

	public function setID(int $id);

	public function getID(): int;
}
