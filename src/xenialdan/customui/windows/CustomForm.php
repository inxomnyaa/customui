<?php

namespace xenialdan\customui\windows;

use InvalidArgumentException;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
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

    public function addDropdown(string $text, array $options = []): self
    {
        $this->addElement(new Dropdown($text, $options));
        return $this;
    }

    public function addInput(string $text, string $placeholder = '', string $defaultText = ''): self
    {
        $this->addElement(new Input($text, $placeholder, $defaultText));
        return $this;
    }

    /**
     * @param string $text
     * @param float $min
     * @param float $max
     * @param float $step
     * @return self
     * @throws InvalidArgumentException
     */
    public function addSlider(string $text, float $min, float $max, float $step = 0.0): self
    {
        $this->addElement(new Slider($text, $min, $max, $step));
        return $this;
    }

    /**
     * @param string $text
     * @param string[] $steps
     * @return self
     */
    public function addStepSlider(string $text, array $steps = []): self
    {
        $this->addElement(new StepSlider($text, $steps));
        return $this;
    }
}
