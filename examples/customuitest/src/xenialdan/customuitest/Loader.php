<?php

namespace xenialdan\customuitest;

use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use xenialdan\customui\API as UIAPI;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\windows\CustomForm;
use xenialdan\customui\windows\ModalForm;
use xenialdan\customui\windows\ServerForm;
use xenialdan\customui\windows\SimpleForm;

class Loader extends PluginBase
{

    /** @var int[] */
    public static $uis;

    public function onEnable()
    {
        $this->getServer()->getCommandMap()->register(Commands::class, new Commands($this));
        try {
            $this->reloadUIs();
        } catch (\Exception $e) {
        }
    }

    /**
     * This function now is called reloadUIs and public to enable reloading dynamic fields/values
     * @throws \Exception
     */
    public function reloadUIs()
    {
        UIAPI::resetUIs($this);
        $ui = new SimpleForm('A simple form with buttons only', '');
        $ui->addButton(new Button('Button'));
        $button2 = new Button('ImageButton');
        $button2->addImage(Button::IMAGE_TYPE_URL, 'https://server.wolvesfortress.de/MCPEGUIimages/hd/X.png');
        $ui->addButton($button2);
        $ui->setCallable(function (Player $player, $data) {
            $player->sendMessage(print_r($data, true));
        });
        $ui->setCallableClose(function (Player $player) {
            $player->sendMessage("Closed the UI");
        });
        self::$uis['simpleUI'] = UIAPI::addUI($this, $ui);
        /* ********* */
        $ui = new CustomForm('Testwindow');
        $ui->addElement(new Label('Label'));
        $ui->addElement(new Label('Label2'));
        $ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
        $ui->addElement(new Input('Input', 'text'));
        $ui->addElement(new Slider('Slider', 5, 10, 0.5));
        $ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
        $ui->addElement(new Toggle('Toggle'));
        $ui->setCallable(function (Player $player, $data) use ($ui) {
            $player->sendMessage(print_r($data, true));
            $player->sendMessage(print_r($ui->getContent(), true));
        });
        $ui->setCallableClose(function (Player $player) {
            $player->sendMessage("Closed the UI");
        });
        self::$uis['customUI'] = UIAPI::addUI($this, $ui);
        /* ********* */
        $ui = new ModalForm('Minecraft', 'Enable spacebar heating?', 'Yes', 'No');
        $ui->setCallable(function (Player $player, $data) {
            $player->sendMessage($data ? "True" : "False");
        });
        $ui->setCallableClose(function (Player $player) {
            $player->sendMessage("Closed the UI");
        });
        self::$uis['modalUI'] = UIAPI::addUI($this, $ui);
        /* ********* */
        $ui = new ServerForm('Server Settings Test');
        $ui->addElement(new Label('Label'));
        $ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
        $ui->addElement(new Input('Input', 'text'));
        $ui->addElement(new Slider('Slider', 5, 10, 0.5));
        $ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
        $ui->addElement(new Toggle('Toggle'));
        $ui->setIconURL('https://server.wolvesfortress.de/MCPEGUIimages/hd/X.png');
        $ui->setCallable(function (Player $player, $data) {
            $player->sendMessage(print_r($data, true));
        });
        $ui->setCallableClose(function (Player $player) {
            $player->sendMessage("Closed the UI");
        });
        self::$uis['serverSettingsUI'] = UIAPI::addUI($this, $ui);
    }
}