<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

/**
 * @internal
 * @deprecated
 */
class Image extends UIElement
{
//TODO! Blame Mojang, doesn't work yet
    public $texture;
    public $width;
    public $height;

    public function __construct($texture, $width = 0, $height = 0)
    {
        $this->texture = $texture;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     *
     * @return array
     */
    final public function jsonSerialize(): array
    {
        return [
            'text' => 'sign',
            'type' => 'image',
            'texture' => $this->texture,
            'size' => [$this->width, $this->height]
        ];
    }

    /**
     * TODO
     *
     * @param null $value
     * @param Player $player
     * @return mixed
     */
    public function handle($value, Player $player)
    {
        return null;
    }

}
