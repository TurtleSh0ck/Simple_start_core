<?php

declare(strict_types=1);

namespace JamesCOMMANDO\SyncPVP;

use JamesCOMMANDO\Syncpvp\commands\feeed;
use JamesCOMMANDO\Syncpvp\commands\fly;
use JamesCOMMANDO\Syncpvp\commands\gm;
use JamesCOMMANDO\Syncpvp\commands\heall;
use JamesCOMMANDO\Syncpvp\commands\v;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\DisconnectPacket;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
use pocketmine\utils\Config;

class Main extends PluginBase implements Listener {

    public function configUpdater():void{
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $messages = new Config($this->getDataFolder() . "messages.yml", Config::YAML);
        // TODO NEED TO IMPLEMENT AN UPDATER WHICH WILL NOT BE ADDED UNLESS THE SERVER IS OUT
        // TODO IDEAS /smite, thru , freeze, nick
    }

    public function onEnable(){
        $this->saveResource("settings.yml");
        $this->saveResource("messages.yml");
        $settings = new Config($this->getDataFolder() . "settings.yml", Config::YAML);
        $this->configUpdater();
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->getServer()->getPluginManager()->registerEvents(PlayerListenerr, $this);
        if($settings->get("feed", true)){
            $this->getServer()->getCommandMap()->register("feed", new feeed($this));
        }
        if($settings->get("gamemode", true)) {
            $this->unregisterCommand("gamemode");
            $this->getServer()->getCommandMap()->register("gm", new gm($this));
        }
        if($settings->get("fly", true)){
            $this->getServer()->getCommandMap()->register("fly", new fly($this));
        }
        if($settings->get("heal", true)){
            $this->getServer()->getCommandMap()->register("heal", new heall($this));
        }
        if($settings->get("v", true)){
            $this->getServer()->getCommandMap()->register("vanish", new v($this));
        }
    }

    public function onDisable(){
    }

    private function unregisterCommand(string $name): void
    {
        $map = $this->getServer()->getCommandMap();
        $cmd = $map->getCommand($name);
        if ($cmd !== null) $this->getServer()->getCommandMap()->unregister($cmd);
    }

    public function onDataPacketSend(DataPacketSendEvent $event){
        $pk = $event->getPacket();
        if($pk instanceof DisconnectPacket){
            if($pk->message === "Internal server error"){
                $pk->message = "§cAn error occurred!\nContact us at Discord and tell us what happened!";
            }
        }
    }

    public function onPlayerJoin(Player $player, PlayerJoinEvent $event){
        
        $player->sendMessage("Welcome to SyncPVP we hope you like our server!");
    }

}
