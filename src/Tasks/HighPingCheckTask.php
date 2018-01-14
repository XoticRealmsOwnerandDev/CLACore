<?php

namespace Tasks;

use CLACore\Core;
use pocketmine\scheduler\PluginTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat as C;

class HighPingCheckTask extends PluginTask {

    public function __construct(Core $plugin){
        parent::__construct($plugin);
    }

    public  function onRun(int $currentTick){
        foreach (Server::getInstance()->getOnlinePlayers() as $players){
            if ($players->getPing() > 400){
                $players->kick(C::RED . "You have been removed from the game because you have a high ping", false);
            }
        }
    }
}