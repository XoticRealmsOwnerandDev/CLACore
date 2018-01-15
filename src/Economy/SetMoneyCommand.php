<?php

namespace Economy;

use CLACore\Core;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class SetMoneyCommand extends PluginCommand {

    private $main;
    public $prefix = TF::BOLD . TF::RED . "Money " . TF::RESET;

    public function __construct($name, Core $main){
        $this->main = $main;
        $this->setDescription("/setmoney for setting at player the money");
        $this->setPermission("core.economy.set");
        parent::__construct($name, $main);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) {
            $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must run this command in-game.");
        }
        if ($sender instanceof Player) {
            if ($sender->hasPermission("core.economy.set") || $sender->isOp()) {
                if (!isset($args[1])) {
                    $sender->sendMessage($this->prefix . "§cThe number o the nickname isn't valid");
                    return true;
                }
                if (!is_numeric($args[1])) {
                    $sender->sendMessage($this->prefix . "§cThe number of money has not been well defined");
                    return true;
                }
                $player = $this->main->getServer()->getPlayer($args[0]);
                $money = new Config($this->main->getDataFolder() . "money.yml", Config::YAML);
                if (!isset($args[1])) {
                    $sender->sendMessage($this->prefix . "§cUsa: /setmoney <player> <money>");
                    return true;
                }
                $nick = strtolower($player->getName());
                $money->set($nick, (int)$args[1]);
                $money->save();
                $sender->sendMessage($this->prefix . "§aYou have set up at §b" . $player->getName() . "§a " . $args[1] . " money!");
                $player->sendMessage($this->prefix . "§aYour money §b" . $args[1]);
                return true;
            }
            if (!$sender->hasPermission("core.economy.set")) {
                $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
            }
            return true;
        }
        return true;
    }
}