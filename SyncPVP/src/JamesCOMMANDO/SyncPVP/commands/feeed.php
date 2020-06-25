<?php
declare(strict_types=1);

namespace JamesCOMMANDO\Syncpvp\commands;


use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\Config;

class feeed extends Command
{

    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("feed", "Feeds the player", "/feed <player>");
        $this->setPermission("sync.feed");
        $this->plugin = $plugin;
    }


    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }
        if(!$sender instanceof Player){
            $sender->sendMessage("Run this Command as a player (INGAME)!");
            return true;
        }
        $settings = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        if(isset($args[0])){
            $player2 = $this->plugin->getServer()->getPlayer($args[0]);
            $player2->setFood(20);
            $hom = $player2->getName();
            $player2->sendMessage("You have been fed!");
            $sender->sendMessage($this->convert($hom, ("You have fed {}")));
        } else{
            $sender->setFood(20);
            $sender->sendMessage("You have been fed!");
        }
        $issuer = $sender->getName();
        return false;
    }

    public function convert(string $string, $hom): string{
        $string = str_replace("{player}", $hom, $string);
        return $string;
    }
}