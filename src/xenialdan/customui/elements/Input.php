<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

class Input extends UIElement
{

    /** @var string Placeholder text that shows when input is empty */
    protected $placeholder = '';
    /** @var string Default text for input */
    protected $defaultText = '';

    /**
     *
     * @param string $text
     * @param string $placeholder
     * @param string $defaultText
     */
    public function __construct(string $text, string $placeholder = '', string $defaultText = '')
    {
        $this->text = $text;
        $this->placeholder = $placeholder;
        $this->defaultText = $defaultText;
    }

    final public function jsonSerialize(): array
    {
        return [
            'type' => 'input',
            'text' => $this->text,
            'placeholder' => $this->placeholder,
            'default' => $this->defaultText
        ];
    }

    /**
     * @param null $value
     * @param Player $player
     * @return string
     */
    public function handle($value, Player $player)
    {
        return $value;
    }

}
