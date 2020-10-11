<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

class Label extends UIElement
{

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    final public function jsonSerialize(): array
    {
        return [
            'type' => 'label',
            'text' => $this->text
        ];
    }

    /**
     * Returns the labels text, labels always send null
     *
     * @param null $value
     * @param Player $player
     * @return string
     */
    final public function handle($value, Player $player): string
    {
        return $this->text;
    }

}
