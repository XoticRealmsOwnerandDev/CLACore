<?php
namespace CLACore\Economy;

use CLACore\Core;;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

class SeeMoneyCommand extends PluginCommand
{
    private $main;
    public $prefix = TF::BOLD . TF::RED . "Money " . TF::RESET;

    public function __construct($name, Core $main)
    {
        parent::__construct($name, $main);
        $this->main = $main;
        $this->setDescription("/seemoney for see the money of another player");

    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            if (!isset($args[0])) {
                $sender->sendMessage($this->prefix . "§cThe nickname isn't definite");
                return true;
            }
            if (!isset($args[0])) {
                $sender->sendMessage($this->prefix . "§cUsa: /seemoney <player>");
            }
            $money = new Config($this->main->getDataFolder() . "money.yml", Config::YAML);
            $sender->sendMessage("§2The money of§6 " . $args[0] . " §8:§3 " . $money->get(strtolower($args[0])));
            return true;
        }
        return true;
    }
}