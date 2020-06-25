<?php


namespace JamesCOMMANDO\Syncpvp\commands;


use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\Config;

class heall extends Command{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("heal", "Heals your target", "/heal <player>");
        $this->setPermission("sync.heal");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){

        if(!$this->testPermission($sender)){
            return false;
        }

        if(!$sender instanceof Player){
            $sender->sendMessage("You must be a player to use this command.");
            return true;
        }

        $settings = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        if(isset($args[0])){
            $player2 = $this->plugin->getServer()->getPlayer($args[0]);
            $player2->setHealth(20);
            $hom = $player2->getName();
            $player2->sendMessage("You have been healed!");
            $sender->sendMessage($this->convert($hom, "You have healed {player}!"));
        } else{
            $sender->setHealth(20);
            $sender->sendMessage("You have been healed!");
        }

        return false;
    }

    private function convert(string $string, $hom): string {
        $string = str_replace("{player}", $hom, $string);
        return $string;
    }
}