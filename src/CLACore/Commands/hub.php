<?php

namespace CLACore\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;
use pocketmine\level\sound\EndermanTeleportSound;

class hub extends Command{
	
	public function __construct(){
        parent::__construct("hub");
        $this->setDescription("Log in your Hub");
        $this->setAliases(["hub"]);
	}
	
	public function execute(CommandSender $sender, string $label, array $args){
        if (!$this->testPermission($sender)){
            return true;
        }
		$player = $event->getPlayer();
		$name = $player->getName();
		
                $sender->sendMessage("§fW§ee§al§cc§bo§dm§fe §bb§aa§ec§ck§7......");
                $sender->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
	        $sender->getInventory()->clearAll();
		$sender->addTitle("§6Lobby");
		$player-setFood(20);
		$player->setHeahlt(20);
		$player->getlevel()->addSound(new EndermanTeleportSound($player));
            return true;
        }
    }
