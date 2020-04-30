<?php

namespace xenialdan\customui\elements;

use pocketmine\Player;

class StepSlider extends UIElement
{

    /** @var string[] */
    protected $steps = [];
    /** @var int Step index */
    protected $defaultStepIndex = 0;

    /**
     *
     * @param string $text
     * @param string[] $steps
     */
    public function __construct(string $text, array $steps = [])
    {
        $this->text = $text;
        $this->steps = $steps;
    }

    public function addStep(string $stepText, $setAsDefault = false): void
    {
        if ($setAsDefault) {
            $this->defaultStepIndex = count($this->steps);
        }
        $this->steps[] = $stepText;
    }

    public function setStepAsDefault(string $stepText): bool
    {
        $index = array_search($stepText, $this->steps, true);
        if ($index === false) {
            return false;
        }
        $this->defaultStepIndex = $index;
        return true;
    }

    /**
     * Replaces all steps
     *
     * @param string[] $steps
     */
    public function setSteps(array $steps): void
    {
        $this->steps = $steps;
    }

    final public function jsonSerialize(): array
    {
        return [
            'type' => 'step_slider',
            'text' => $this->text,
            'steps' => array_map('strval', $this->steps),
            'default' => $this->defaultStepIndex
        ];
    }

    /**
     * TODO options to get either text or index or value
     * @param null $value
     * @param Player $player
     * @return mixed
     */
    public function handle($value, Player $player)
    {
        return $this->steps[$value];
    }

}
