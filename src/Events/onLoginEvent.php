<?php

namespace Events;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;

use CLACore\Core;

class onLoginEvent implements Listener{

    private $core;
    
    public function __construct(Core $core){
        $this->core = $core;
    }

    public function onLogin(PlayerLoginEvent $e){
        $player = $e->getPlayer();
        $core = $this->core;
        if($core->cfg->get("Alway-Spawn") == true){
            $player->teleport($core->getServer()->getDefaultLevel()->getSafeSpawn());
        }
    }
}