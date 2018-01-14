<?php
namespace CLACore\Economy;

use CLACore\Core;
use pocketmine\command\CommandSender;
use pocketmine\command\PluginCommand;
use pocketmine\Player;
use pocketmine\utils\Config;

class MoneyCommand extends PluginCommand
{
    private $main;

    public function __construct($name, Core $main)
    {
        parent::__construct($name, $main);
        $this->main = $main;
        $this->setDescription("/money for see your money");

    }

    public function execute(CommandSender $sender, $commandLabel, array $args)
    {
        if ($sender instanceof Player) {
            $money = new Config($this->main->getDataFolder() . "money.yml", Config::YAML);
            $sender->sendMessage("§2Money§8: " . $money->get(strtolower($sender->getName())));
            return true;
        }
        return true;
    }
}