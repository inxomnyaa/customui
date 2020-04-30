<?php

namespace xenialdan\customui\windows;

use pocketmine\form\FormValidationException;
use pocketmine\Player;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\elements\UIElement;

class CustomForm implements CustomUI
{
    use CallableTrait;

    /** @var string */
    protected $title = '';
    /** @var UIElement[] */
    protected $elements = [];
    /** @var int */
    private $id;

    /**
     * CustomForm is a totally custom and dynamic form
     * @param $title
     */
    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * Add element to form
     * @param UIElement $element
     */
    public function addElement(UIElement $element): void
    {
        $this->elements[] = $element;
    }

    public function jsonSerialize()
    {
        $data = [
            'type' => 'custom_form',
            'title' => $this->title,
            'content' => []
        ];
        foreach ($this->elements as $element) {
            $data['content'][] = $element;
        }
        return $data;
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return $this->elements;
    }

    public function setID(int $id): void
    {
        $this->id = $id;
    }

    public function getID(): int
    {
        return $this->id;
    }

    /**
     * @param int $index
     * @return UIElement|null
     */
    public function getElement(int $index): ?UIElement
    {
        return $this->elements[$index];
    }

    public function setElement(UIElement $element, int $index): void
    {
        if ($element instanceof Button) return;
        $this->elements[$index] = $element;
    }

    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $this->close($player);
            return;
        } else if (is_array($data)) {
            $return = [];
            foreach ($data as $elementKey => $elementValue) {
                if (isset($this->elements[$elementKey])) {
                    if (($value = $this->elements[$elementKey]->handle($elementValue, $player)) !== null) $return[] = $value;
                } else {
                    throw new FormValidationException("Element with index {$elementKey} does not exist");
                }
            }
        } else {
            throw new FormValidationException('Expected array or null, got ' . gettype($data));
        }

        $callable = $this->getCallable();
        if ($callable !== null) {
            $callable($player, $return);
        }
    }

    public function addLabel(string $text): self
    {
        $this->addElement(new Label($text));
        return $this;
    }

    public function addToggle(string $text, bool $value = false): self
    {
        $this->addElement(new Toggle($text, $value));
        return $this;
    }
}
