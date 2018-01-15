<?php

namespace CLACore\Economy;

use CLACore\Core;

use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;

use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class AddMoneyCommand extends PluginCommand {

    private $main;

    public $prefix = TF::BOLD . TF::RED . "Money " . TF::RESET;

    public function __construct($name, Core $main){
        parent::__construct($name, $main);
        $this->main = $main;
        $this->setDescription("/addmoney for add money to players");
        $this->setPermission("core.economy.add");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$sender instanceof Player) {
            $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You must run this command in-game.");
        }
        if ($sender->hasPermission("core.economy.add") || $sender->isOp()) {
            if ($sender instanceof Player) {
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
                    $sender->sendMessage($this->prefix . "§cUse: /addmoney <player> <money>");
                    return true;
                }
                $nick = strtolower($player->getName());
                $money->set($nick, $money->get($nick) + $args[1]);
                $money->save();
                $sender->sendMessage($this->prefix . "§aYou added§b " . $args[1] . " §amoney at §b" . $player->getName() . "");
                $sender->sendMessage($this->prefix . "The total money of " . $player->getName() . " : " . $money->get(strtolower($player->getName())));
                $player->sendMessage($this->prefix . "You have been added " . $args[1] . " money on your account!");
                return true;
            }
            if (!$sender->hasPermission("core.economy.add")) {
                $sender->sendMessage(TF::BOLD . TF::DARK_GRAY . "(" . TF::RED . "!" . TF::DARK_GRAY . ") " . TF::RESET . TF::GRAY . "You don't have permission to use this command.");
            }
            return true;
        }
        return true;
    }
}