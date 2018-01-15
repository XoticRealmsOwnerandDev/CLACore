<?php
namespace CLACore\Commands;

use CLACore\Core;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

class Fly extends PluginCommand {

    private $main;
    private $players = array();

    public function __construct($name, Core $main) {
        parent::__construct($name, $main);
        $this->main = $main;
        $this->setDescription("/fly for enable and disable the flying");
        $this->setPermission("core.command.fly");

    }
    public function addPlayer(Player $player) {
        $this->players[$player->getName()] = $player->getName();
    }
    public function isPlayer(Player $player) {
        return in_array($player->getName(), $this->players);
    }
    public function removePlayer(Player $player) {
        unset($this->players[$player->getName()]);
    }
    public function execute(CommandSender $sender, $commandLabel, array $args) {
        if(!$sender->hasPermission("core.command.fly")) {
            $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
        }
        if(!$sender instanceof Player) {
            $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must run this command in-game.");
        }
        if($sender->hasPermission("core.command.fly") || $sender->isOp()) {
            if ($sender instanceof Player) {
                if ($this->isPlayer($sender)) {
                    $this->removePlayer($sender);
                    $sender->setAllowFlight(false);
                    $sender->sendMessage(TF::RED . "The flying has been disabled");
                    return true;
                } else {
                    $this->addPlayer($sender);
                    $sender->setAllowFlight(true);
                    $sender->sendMessage(TF::GREEN . "the flying has been enabled");
                    return true;
                }
            }
        }
        return true;
    }
}