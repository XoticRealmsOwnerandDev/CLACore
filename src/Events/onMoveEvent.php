<?php

namespace Events;

use CLACore\Core;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class onMoveEvent implements Listener {

    private $core;

    public function __construct(Core $core){
        $this->core = $core;
    }

    public function onMove(PlayerMoveEvent $e){
        if ($this->core->cfg->get("Allow-NoVoid") == true) {
            if ($e->getPlayer()->getLevel()->getName() === $this->core->cfg->get("No-Void-World")) {
                if ($e->getTo()->getFloorY() < 1) {
                    $player = $e->getPlayer();
                    $player->teleport($this->core->getServer()->getDefaultLevel()->getSafeSpawn());
                }
            }
        }
    }
}