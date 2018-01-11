<?php

namespace CLACore\Commands;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;
use pocketmine\Player;

class hub extends Command{
	
	public function __construct(){
        parent::__construct("hub");
        $this->setDescription("Teleport to Hub");
        $this->setAliases(["hub"]);
	}
	
	public function execute(CommandSender $sender, string $label, array $args){
        if (!$this->testPermission($sender)){
            return true;
        }
                $sender->sendMessage("§fW§ee§al§cc§bo§dm§fe §bb§aa§ec§ck§7......");
                $sender->teleport($this->getServer()->getDefaultLevel()->getSafeSpawn());
            return true;
        }
    }
