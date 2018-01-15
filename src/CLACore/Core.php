<?php

namespace CLACore;

use Tasks\HighPingCheckTask;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\Textformat as C;

#Commands
use CLACore\Commands\Ping;
use CLACore\Commands\Hub;
use CLACore\Commands\Fly;

#Economy Command
use Economy\AddMoneyCommand;
use Economy\MoneyCommand;
use Economy\SeeMoneyCommand;
use Economy\SetMoneyCommand;
use Economy\TakeMoneyCommand;

#Events
use Events\onRespawnEvent;
use Events\onJoinEvent;
use Events\onLoginEvent;

use Ranks\Rank;

class Core extends PluginBase{

    public $cfg;
    public $money;

    public function onEnable(){
        $this->onConfig();
        $this->onEvent();
        $this->onCommands();
        $this->onEconomy();
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new HighPingCheckTask($this), 100); //5 Sek.
        $this->getLogger()->info(C::GREEN."Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED."Disabled.");
    }

    public function onConfig(){
        @mkdir($this->getDataFolder());
        $this->saveResource("config.yml");
        $this->saveResource("rank.yml");
        $this->saveResource("title.yml");
        $this->saveResource("money.yml");
        $this->money = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }

    public function onEvent(){
        if($this->cfg->get("Allow-Rank") == true){
            $this->getServer()->getPluginManager()->registerEvents(($this->Rank = new Rank($this)), $this);
        }
        $this->getServer()->getPluginManager()->registerEvents(($this->onRespawnEvent = new onRespawnEvent($this)), $this);
        $this->getServer()->getPluginManager()->registerEvents(($this->onJoinEvent = new onJoinEvent($this)), $this);
        $this->getServer()->getPluginManager()->registerEvents(($this->onLoginEvent = new onLoginEvent($this)), $this);
    }

    private function onCommands(){
        $this->getServer()->getCommandMap()->register("hub", new Hub("hub", $this));
        $this->getServer()->getCommandMap()->register("ping", new Ping("ping", $this));
        $this->getServer()->getCommandMap()->register("fly", new Fly("fly", $this));
    }

    private function onEconomy(){
        if($this->cfg->get("Allow-Money") == true){
            $this->getServer()->getCommandMap()->register("addmoney", new AddMoneyCommand("addmoney", $this));
            $this->getServer()->getCommandMap()->register("takemoney", new TakeMoneyCommand("takemoney", $this));
            $this->getServer()->getCommandMap()->register("setmoney", new SetMoneyCommand("setmoney", $this));
            $this->getServer()->getCommandMap()->register("seemoney", new SeeMoneyCommand("seemoney", $this));
            $this->getServer()->getCommandMap()->register("money", new MoneyCommand("money", $this));
        }
    }

    public function myMoney($player){
        if ($player instanceof Player) {
            $player = $player->getName();
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->get($player);
        return $moneyconf->get($player);
    }

    public function reduceMoney($player, $money){
        if ($player instanceof Player) {
            $player->getName();
        }
        if ($this->myMoney($player) - $money < 0) {
            return true;
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->set($player, (int)$moneyconf->get($player) - $money);
        $moneyconf->save();
        return true;
    }

    public function addMoney($player, $money){
        if ($player instanceof Player) {
            $player->getName();
        }
        if ($this->myMoney($player) + $money < 0) {
            return true;
        }
        $player = strtolower($player);
        $moneyconf = new Config($this->getDataFolder() . "money.yml", Config::YAML);
        $moneyconf->set($player, (int)$moneyconf->get($player) + $money);
        $moneyconf->save();
        return true;
    }
}