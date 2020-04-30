<?php

namespace xenialdan\customui\windows;

use pocketmine\form\Form;
use pocketmine\Player;
use xenialdan\customui\elements\UIElement;

interface CustomUI extends Form
{

    /**
     * To handle manual closing
     * @param Player $player
     */
    public function close(Player $player): void;

    public function getTitle(): string;

    public function getContent(): array;

    /**
     * @param int $index
     * @return UIElement|null
     * @deprecated
     */
    public function getElement(int $index): ?UIElement;

    /**
     * @param UIElement $element
     * @param int $index
     * @deprecated
     */
    public function setElement(UIElement $element, int $index): void;

    public function setID(int $id): void;

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
