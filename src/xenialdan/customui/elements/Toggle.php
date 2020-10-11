<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

class Toggle extends UIElement
{

    /** @var bool */
    protected $defaultValue = false;

    public function __construct(string $text, bool $value = false)
    {
        $this->text = $text;
        $this->defaultValue = $value;
    }

    public function setDefaultValue(bool $value): void
    {
        $this->defaultValue = $value;
    }

    public function jsonSerialize(): array
    {
        return [
            'type' => 'toggle',
            'text' => $this->text,
            'default' => $this->defaultValue
        ];
    }

    /**
     * @param null $value
     * @param Player $player
     * @return bool
     */
    public function handle($value, Player $player)
    {
        return $value;
    }

}
