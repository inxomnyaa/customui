<?php

namespace xenialdan\customui\elements;

use InvalidArgumentException;
use pocketmine\Player;

class Slider extends UIElement
{

    /** @var float */
    protected $min = 0.0;
    /** @var float */
    protected $max = 0.0;
    /** @var float Only positive numbers */
    protected $step = 0.0;
    /** @var float */
    protected $defaultValue = 0.0;

    /**
     * @param string $text
     * @param float $min
     * @param float $max
     * @param float $step
     * @throws InvalidArgumentException
     */
    public function __construct(string $text, float $min, float $max, float $step = 0.0)
    {
        if ($min > $max) {
            throw new InvalidArgumentException(__METHOD__ . ' Borders are messed up');
        }
        $this->text = $text;
        $this->min = $min;
        $this->max = $max;
        $this->defaultValue = $min;
        $this->setStep($step);
    }

    /**
     *
     * @param float $step
     * @throws InvalidArgumentException
     */
    public function setStep(float $step): void
    {
        if ($step < 0) {
            throw new InvalidArgumentException(__METHOD__ . ' Step should be positive');
        }
        $this->step = $step;
    }

    /**
     * @param float $value
     * @throws InvalidArgumentException
     */
    public function setDefaultValue(float $value): void
    {
        if ($value < $this->min || $value > $this->max) {
            throw new InvalidArgumentException(__METHOD__ . ' Default value out of borders');
        }
        $this->defaultValue = $value;
    }

    final public function jsonSerialize(): array
    {
        $data = [
            'type' => 'slider',
            'text' => $this->text,
            'min' => $this->min,
            'max' => $this->max
        ];
        if ($this->step > 0) {
            $data['step'] = $this->step;
        }
        if ($this->defaultValue !== $this->min) {
            $data['default'] = $this->defaultValue;
        }
        return $data;
    }

    /**
     * Returns the float value it was set to
     *
     * @param null $value
     * @param Player $player
     * @return float
     */
    public function handle($value, Player $player)
    {
        return $value;
    }

}
