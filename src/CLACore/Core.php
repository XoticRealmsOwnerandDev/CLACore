<?php

namespace CLACore;

use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\Textformat as C;

#Events
use Events\onLoginEvent;

class Core extends PluginBase{

    public function onEnable(){
        $this->onConfig();
        $this->onEvent();
        $this->getLogger()->info(C::GREEN."Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED."Disabled.");
    }

    public function onConfig(){
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
    }

    public function onEvent(){
        $this->getServer()->getPluginManager()->registerEvents(($this->onLoginEvent = new onLoginEvent($this)), $this);
    }
}