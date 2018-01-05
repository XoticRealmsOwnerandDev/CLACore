<?php

namespace CLACore;

use pocketmine\plugin\PluginBase;

class Core extends PluginBase{

    public function onEnable(){
        $this->getLogger()->info(C::GREEN."Enabled.");
    }

    public function onDisable(){
        $this->getLogger()->info(C::RED."Disabled.");
    }
}