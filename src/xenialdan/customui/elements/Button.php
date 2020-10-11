<?php

namespace xenialdan\customui\elements;

use Exception;
use InvalidArgumentException;
use pocketmine\Player;
use xenialdan\customui\ButtonImage;

class Button extends UIElement
{
    public const IMAGE_TYPE_PATH = 'path';
    public const IMAGE_TYPE_URL = 'url';

    /** @var string May contains 'path' or 'url' */
    protected $image;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    /**
     * Add image to button
     *
     * @param string $imageType
     * @param string $imagePath
     * @throws Exception
     */
    public function addImage(string $imageType, string $imagePath): void
    {
        if ($imageType !== self::IMAGE_TYPE_PATH && $imageType !== self::IMAGE_TYPE_URL) {
            throw new InvalidArgumentException('Invalid image type');
        }
        $this->image = new ButtonImage($imagePath, $imageType);
    }

    final public function jsonSerialize(): array
    {
        $data = [
            'type' => 'button',
            'text' => $this->text
        ];
        if ($this->image !== null) {
            $data['image'] = $this->image;
        }
        return $data;
    }

    /**
     * Returns the text of the button
     * TODO options to get either text or index
     *
     * @param null|int|array $value
     * @param Player $player
     * @return mixed
     */
    public function handle($value, Player $player)
    {
        return $this->text;
    }

}
