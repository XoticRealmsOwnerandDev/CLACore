<?php

namespace Events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use Tasks\TitleTask;

use CLACore\Core;

class onJoinEvent implements Listener {

    private $core;
    
    public function __construct(Core $core){
        $this->core = $core;
    }

    public function onJoin(PlayerJoinEvent $e){
        $player = $e->getPlayer();
        $name = $player->getName();
        $core = $this->core;
        $core->getServer()->getScheduler()->scheduleDelayedTask(new TitleTask($core, $player), 50); //2.5 Sek.
    }
}