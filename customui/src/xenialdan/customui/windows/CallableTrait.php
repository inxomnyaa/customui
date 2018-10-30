<?php

declare(strict_types=1);

namespace xenialdan\customui\windows;

use pocketmine\Player;

trait CallableTrait
{
    /** @var null|callable */
    private $callable;
    /** @var null|callable */
    private $callableClose;

    /**
     * @return null|callable
     */
    public function getCallable(): ?callable
    {
        return $this->callable;
    }

    /**
     * @param null|callable $callable
     */
    public function setCallable($callable = null): void
    {
        $this->callable = $callable;
    }

    /**
     * @return callable|null
     */
    public function getCallableClose(): ?callable
    {
        return $this->callableClose;
    }

    /**
     * @param callable|null $callableClose
     */
    public function setCallableClose($callableClose = null): void
    {
        $this->callableClose = $callableClose;
    }

    /**
     * To handle manual closing
     * @param Player $player
     */
    final public function close(Player $player)
    {
        $callable = $this->getCallableClose();
        if ($callable !== null) {
            $callable($player);
        }
    }

}