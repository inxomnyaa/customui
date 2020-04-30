<?php

namespace xenialdan\customui;

use InvalidArgumentException;
use pocketmine\OfflinePlayer;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use xenialdan\customui\windows\CustomUI;

class API
{
    /** @var array(CustomUI[]) */
    private static $UIs = [];

    /**
     * @param Plugin $plugin
     * @param CustomUI $ui
     * @return int id
     */
    public static function addUI(Plugin $plugin, CustomUI $ui): int
    {
        $ui->setID(count(self::$UIs[$plugin->getName()] ?? []));
        $id = $ui->getID();
        self::$UIs[$plugin->getName()][$id] = $ui;
        return $id;
    }

    public static function resetUIs(Plugin $plugin): void
    {
        self::$UIs[$plugin->getName()] = [];
    }

    /**
     * @return array(CustomUI[])
     */
    public static function getAllUIs(): array
    {
        return self::$UIs;
    }

    /**
     * @param Plugin $plugin
     * @return CustomUI[]
     */
    public static function getPluginUIs(Plugin $plugin): array
    {
        return self::$UIs[$plugin->getName()];
    }

    /**
     * @param Plugin $plugin
     * @param int $id
     * @return CustomUI
     */
    public static function getPluginUI(Plugin $plugin, int $id): CustomUI
    {
        return self::$UIs[$plugin->getName()][$id];
    }

    public static function handle(Plugin $plugin, int $id, $response, Player $player): string
    {
        $ui = self::getPluginUIs($plugin)[$id];
        return $ui->handle($response, $player) ?? '';
    }

    /**
     * @param CustomUI $ui
     * @param Player $player
     * @throws InvalidArgumentException
     */
    public static function showUI(CustomUI $ui, Player $player): void
    {
        $player->sendForm($ui);
    }

    /**
     * @param Plugin $plugin
     * @param int $id
     * @param Player $player
     * @throws InvalidArgumentException
     */
    public static function showUIbyID(Plugin $plugin, int $id, Player $player): void
    {
        $ui = self::getPluginUIs($plugin)[$id];
        $player->sendForm($ui);
    }

    /**
     * @param Player[]|OfflinePlayer[] $players
     * @return array
     */
    public static function playerArrayToNameArray(array $players): array
    {
        $return = array_map(static function ($player) {
            /** @var OfflinePlayer|Player $player */
            return $player->getName();
        }, $players);
        sort($return, SORT_NATURAL);
        return $return;
    }
}
