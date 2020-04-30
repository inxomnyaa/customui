<?php

namespace xenialdan\customui\windows;

use Exception;
use pocketmine\form\FormValidationException;
use pocketmine\Player;
use xenialdan\customui\ButtonImage;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\UIElement;

class SimpleForm implements CustomUI
{
    use CallableTrait;

    /** @var string */
    protected $title = '';
    /** @var string */
    protected $content = '';
    /** @var Button[] */
    protected $buttons = [];
    /** @var int */
    private $id;

    /**
     * SimpleForm only consists of clickable buttons
     *
     * @param string $title
     * @param string $content
     */
    public function __construct($title, $content = '')
    {
        $this->title = $title;
        $this->content = $content;
    }

    /**
     * Add button to form
     *
     * @param Button $button
     */
    public function addButton(Button $button): void
    {
        $this->buttons[] = $button;
    }

    /**
     * Add button to form
     *
     * @param string $text
     * @param ButtonImage|null $image
     * @throws Exception
     */
    public function addButtonEasy(string $text, ?ButtonImage $image = null): void//TODO rename or remove
    {
        $button = new Button($text);
        if ($image !== null)
            $button->addImage($image->getType(), $image->getData());
        $this->buttons[] = $button;
    }

    final public function jsonSerialize()
    {
        $data = [
            'type' => 'form',
            'title' => $this->title,
            'content' => $this->content,
            'buttons' => []
        ];
        foreach ($this->buttons as $button) {
            $data['buttons'][] = $button;
        }
        return $data;
    }

    final public function getTitle(): string
    {
        return $this->title;
    }

    public function getContent(): array
    {
        return [$this->content, $this->buttons];
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
     * @return Button
     */
    public function getElement(int $index): ?UIElement
    {
        return $this->buttons[$index];
    }

    public function setElement(UIElement $element, int $index): void
    {
        if (!$element instanceof Button) return;
        $this->buttons[$index] = $element;
    }

    /**
     * Handles a form response from a player.
     *
     * @param Player $player
     * @param mixed $data
     *
     * @throws FormValidationException if the data could not be processed
     */
    public function handleResponse(Player $player, $data): void
    {
        if ($data === null) {
            $this->close($player);
            return;
        } else if (is_int($data)) {
            $return = '';
            if (isset($this->buttons[$data])) {
                if (($value = $this->buttons[$data]->handle($data, $player)) !== null) $return = $value;
            } else {
                throw new FormValidationException("Option $data does not exist");
            }
        } else {
            throw new FormValidationException('Expected int or null, got ' . gettype($data));
        }

        $callable = $this->getCallable();
        if ($callable !== null) {
            $callable($player, $return);
        }
    }
}
