<?php

namespace Events;

use CLACore\Core;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerExhaustEvent;

use pocketmine\utils\Config;

class onExhaustEvent implements Listener {

    private $plugin;

    public function __construct(Core $plugin){
        $this->plugin = $plugin;
    }

    public function onExhaust(PlayerExhaustEvent $event){
        $config = new Config($this->plugin->getDataFolder()."config.yml", Config::YAML);
        if($config->get("Disable-HungerChange") == true){
            $event->setCancelled(true);
        }
    }
}