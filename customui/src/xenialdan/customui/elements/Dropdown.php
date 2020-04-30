<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

class Dropdown extends UIElement
{

    /** @var string[] */
    protected $options = [];
    /** @var int */
    protected $defaultOptionIndex = 0;

    /**
     * @param string $text
     * @param string[] $options
     */
    public function __construct(string $text, array $options = [])
    {
        $this->text = $text;
        $this->options = $options;
    }

    public function addOption(string $optionText, bool $isDefault = false): void
    {
        if ($isDefault) {
            $this->defaultOptionIndex = count($this->options);
        }
        $this->options[] = $optionText;
    }

    public function setOptionAsDefault(string $optionText): bool
    {
        $index = array_search($optionText, $this->options, true);
        if ($index === false) {
            return false;
        }
        $this->defaultOptionIndex = $index;
        return true;
    }

    /**
     * Replaces all options
     *
     * @param string[] $options
     */
    public function setOptions(array $options): void
    {
        $this->options = $options;
    }

    final public function jsonSerialize(): array
    {
        return [
            'type' => 'dropdown',
            'text' => $this->text,
            'options' => $this->options,
            'default' => $this->defaultOptionIndex
        ];
    }

    /**
     * Returns the value of the selected option
     * TODO options to get either text or index
     *
     * @param null $value
     * @param Player $player
     * @return string
     */
    public function handle($value, Player $player)
    {
        return $this->options[$value];
    }

}