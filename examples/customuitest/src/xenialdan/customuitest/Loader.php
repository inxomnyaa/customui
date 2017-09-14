<?php

namespace xenialdan\customuitest;

use pocketmine\network\mcpe\protocol\PacketPool;
use pocketmine\plugin\PluginBase;
use xenialdan\customui\API as UIAPI;
use xenialdan\customui\elements\Button;
use xenialdan\customui\elements\Dropdown;
use xenialdan\customui\elements\Input;
use xenialdan\customui\elements\Label;
use xenialdan\customui\elements\Slider;
use xenialdan\customui\elements\StepSlider;
use xenialdan\customui\elements\Toggle;
use xenialdan\customui\network\ModalFormRequestPacket;
use xenialdan\customui\network\ModalFormResponsePacket;
use xenialdan\customui\network\ServerSettingsRequestPacket;
use xenialdan\customui\network\ServerSettingsResponsePacket;
use xenialdan\customui\windows\CustomForm;
use xenialdan\customui\windows\ModalWindow;
use xenialdan\customui\windows\SimpleForm;

class Loader extends PluginBase{

	/** @var int[] */
	public static $uis;

	public function onEnable(){
		$this->getServer()->getCommandMap()->register(Commands::class, new Commands($this));
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		PacketPool::registerPacket(new ModalFormRequestPacket());
		PacketPool::registerPacket(new ModalFormResponsePacket());
		PacketPool::registerPacket(new ServerSettingsRequestPacket());
		PacketPool::registerPacket(new ServerSettingsResponsePacket());
		/** call this AFTER registering packets! */
		$this->reloadUIs();
	}

	/**
	 * This function now is called reloadUIs and public to enable reloading dynamic fields/values
	 */
	public function reloadUIs(){
		UIAPI::resetUIs($this);
		$ui = new SimpleForm('A simple form with buttons only', '');
		$ui->addButton(new Button('Button'));
		$button2 = new Button('ImageButton');
		$button2->addImage(Button::IMAGE_TYPE_URL, 'https://server.wolvesfortress.de/MCPEGUIimages/hd/X.png');
		$ui->addButton($button2);
		self::$uis['simpleUI'] = UIAPI::addUI($this, $ui);
		/* ********* */
		$ui = new CustomForm('Testwindow');
		$ui->addElement(new Label('Label'));
		$ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
		$ui->addElement(new Input('Input', 'text'));
		$ui->addElement(new Slider('Slider', 5, 10, 0.5));
		$ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
		$ui->addElement(new Toggle('Toggle'));
		self::$uis['customUI'] = UIAPI::addUI($this, $ui);
		/* ********* */
		$ui = new ModalWindow('Bananas', 'We finally want bananas!', 'yes', 'no');
		self::$uis['modalUI'] = UIAPI::addUI($this, $ui);
		/* ********* */
		$ui = new CustomForm('Server Settings Test');
		$ui->addElement(new Label('Label'));
		$ui->addElement(new Dropdown('Dropdown', ['name1', 'name2']));
		$ui->addElement(new Input('Input', 'text'));
		$ui->addElement(new Slider('Slider', 5, 10, 0.5));
		$ui->addElement(new StepSlider('Stepslider', [5, 7, 9, 11]));
		$ui->addElement(new Toggle('Toggle'));
		self::$uis['serverSettingsUI'] = UIAPI::addUI($this, $ui);
	}
}