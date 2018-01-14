<?php

namespace CLACore\Commands;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\level\Level;
use pocketmine\level\sound\EndermanTeleportSound;

use pocketmine\math\Vector3;

use pocketmine\utils\TextFormat as C;

use CLACore\Core;

class hub extends PluginCommand{

    public function __construct($name, Core $plugin){
        parent::__construct($name, $plugin);
        $this->setDescription("Teleport to hub.");
        $this->setAliases(["Hub"]);
    }
     
    public function execute(CommandSender $sender, string $commandLabel, array $args): bool{
                    if($sender instanceof Player){
                        $level = $sender->getLevel();
                        $x = $sender->getX();
                        $y = $sender->getY();
                        $z = $sender->getZ();
                        $spawn = new Vector3($x, $y, $z);
                        $sender->sendMessage(C::GREEN . "Teleporting to hub.");
                        $sender->teleport($this->getPlugin()->getServer()->getDefaultLevel()->getSafeSpawn());
                        $level->addSound(new EndermanTeleportSound($spawn));
        }else{
          $sender->sendMessage(C::RED . "You are not In-Game.");
        }
            return true;
    }
}
