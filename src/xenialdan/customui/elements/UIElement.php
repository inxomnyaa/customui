<?php

namespace xenialdan\customui\elements;

use JsonSerializable;
use pocketmine\Player;

abstract class UIElement implements JsonSerializable
{

    /** @var string */
    protected $text = '';

    public function jsonSerialize(): array
    {
        return [];
    }

    /**
     * @param $value
     * @param Player $player
     * @return mixed
     */
    abstract public function handle($value, Player $player);

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

}
