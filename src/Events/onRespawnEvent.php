<?php
namespace Events;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use CLACore\Core;
class onRespawnEvent implements Listener{
    private $core;

    public function __construct(Core $core){
        $this->core = $core;
    }
    public function onRespawn(PlayerRespawnEvent $e){
        $player = $e->getPlayer();
        $name = $player->getName();
        $core = $this->core;
        $this->titlecfg = new Config($core->getDataFolder() . "title.yml", Config::YAML);
        $title = $this->titlecfg->get("Title-Respawn-title");
        $title = str_replace("{name}", $name, $title);
        $subtitle = $this->titlecfg->get("Title-Respawn-subtitle");
        $subtitle = str_replace("{name}", $name, $subtitle);
        if($core->cfg->get("Title-Respawn") == true){
            $player->addTitle($title, $subtitle);
        }
    }
}