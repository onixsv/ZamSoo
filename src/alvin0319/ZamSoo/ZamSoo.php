<?php

declare(strict_types=1);

namespace alvin0319\ZamSoo;

use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\SingletonTrait;
use function file_exists;
use function file_get_contents;
use function file_put_contents;
use function json_decode;
use function json_encode;

class ZamSoo extends PluginBase{
	use SingletonTrait;

	protected array $data = [];

	protected function onLoad() : void{
		self::setInstance($this);
	}

	protected function onEnable() : void{
		if(file_exists($file = $this->getDataFolder() . "ZamSoo.json")){
			$this->data = json_decode(file_get_contents($file), true);
		}
	}

	protected function onDisable() : void{
		file_put_contents($this->getDataFolder() . "ZamSoo.json", json_encode($this->data));
	}

	public function addZamSooPoint(Player $player, int $point = 1) : void{
		if(!$this->hasData($player)){
			$this->createData($player);
		}
		$this->data[$player->getName()] += $point;
	}

	public function reduceZamSooPoint(Player $player, int $point = 1) : void{
		$this->data[$player->getName()] -= $point;
	}

	public function getZamSooPoint(Player $player) : int{
		return $this->data[$player->getName()] ?? -1;
	}

	public function hasData(Player $player) : bool{
		return isset($this->data[$player->getName()]);
	}

	public function createData(Player $player) : void{
		$this->data[$player->getName()] = 0;
	}
}