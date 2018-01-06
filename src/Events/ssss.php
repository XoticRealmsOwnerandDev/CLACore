<?php

namespace Events;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\Config;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use CLACore\Core;

class onJoinEvent implements Listener{

    private $core;
    
    public function __construct(Core $core){
        $this->core = $core;
    }

    public function onJoin(PlayerJoinEvent $e){
        $player = $e->getPlayer();
        $name = $player->getName();
        $core = $this->core;
        $this->titlecfg = new Config($core->getDataFolder() . "title.yml", Config::YAML);
        $title = $this->titlecfg->get("Title-Join-title");
        $title = str_replace("{name}", $name, $title);
        $subtitle = $this->titlecfg->get("Title-Join-subtitle");
        $subtitle = str_replace("{name}", $name, $subtitle);
        if($core->cfg->get("Title-Join") == true){
            echo 1;
            $player->addTitle($title, $subtitle);
        }
    }
}