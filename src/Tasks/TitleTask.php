<?php

namespace Tasks;

use pocketmine\Player;
use pocketmine\Server;

use pocketmine\utils\Config;

use pocketmine\scheduler\PluginTask;

use CLACore\Core;

class TitleTask extends PluginTask{

    private $core;
    private $player;

    public function __construct(Core $core, Player $player){
        parent::__construct($core, $player);
        $this->core = $core;
        $this->player = $player;
    }

    public function onRun(int $tick){
        $player = $this->player;
        $name = $player->getName();
        $core = $this->core;
        $this->titlecfg = new Config($core->getDataFolder() . "title.yml", Config::YAML);
        $title = $this->titlecfg->get("Title-Join-title");
        $title = str_replace("{name}", $name, $title);
        $subtitle = $this->titlecfg->get("Title-Join-subtitle");
        $subtitle = str_replace("{name}", $name, $subtitle);
        if($core->cfg->get("Title-Join") == true){
            $player->addTitle($title, $subtitle);
        }
    }
}