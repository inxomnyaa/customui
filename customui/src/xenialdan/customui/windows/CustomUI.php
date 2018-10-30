<?php

namespace xenialdan\customui\windows;

use pocketmine\form\Form;
use pocketmine\Player;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\UIElement;

interface CustomUI extends Form
{

    /**
     * To handle manual closing
     * @param Player $player
     */
    public function close(Player $player);

    public function getTitle();

    public function getContent(): array;

    /**
     * @param int $index
     * @return UIElement|Button|null
     */
    public function getElement(int $index);

    public function setElement(UIElement $element, int $index);

    public function setID(int $id);

    public function getID(): int;

    /**
     * @return null|callable
     */
    public function getCallable(): ?callable;

    /**
     * @param null|callable $callable
     */
    public function setCallable($callable): void;
}
