<?php

namespace CLACore;

use Economy\AddMoneyCommand;
use Economy\SeeMoneyCommand;
use Economy\SetMoneyCommand;
use Economy\TakeMoneyCommand;
use pocketmine\plugin\PluginBase;

use pocketmine\utils\Config;
use pocketmine\utils\Textformat as C;

#Events
use Events\onRespawnEvent;
use Events\onJoinEvent;
use Events\onLoginEvent;
use Ranks\Rank;

class Core extends PluginBase{

    public $cfg;

    public function onEnable(){
        $this->onConfig();
        $this->getServer()->getCommandMap()->register("hub", new Commands\hub());

        $this->onEvent();
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
        $this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);
   }

    public function onEvent(){

        if($this->cfg->get("Allow-Rank") == true){
            $this->getServer()->getCommandMap()->register("addmoney", new AddMoneyCommand("addmoney", $this));
            $this->getServer()->getCommandMap()->register("takemoney", new TakeMoneyCommand("takemoney", $this));
            $this->getServer()->getCommandMap()->register("setmoney", new SetMoneyCommand("setmoney", $this));
            $this->getServer()->getCommandMap()->register("seemoney", new SeeMoneyCommand("seemoney", $this));
        }
        if($this->cfg->get("Allow-Money") == true){
            $this->getServer()->getPluginManager()->registerEvents(($this->Rank = new Rank($this)), $this);
        }
        $this->getServer()->getPluginManager()->registerEvents(($this->onRespawnEvent = new onRespawnEvent($this)), $this);
        $this->getServer()->getPluginManager()->registerEvents(($this->onJoinEvent = new onJoinEvent($this)), $this);
        $this->getServer()->getPluginManager()->registerEvents(($this->onLoginEvent = new onLoginEvent($this)), $this);
    }
}
