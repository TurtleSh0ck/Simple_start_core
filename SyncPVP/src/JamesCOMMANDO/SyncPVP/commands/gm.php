<?php


namespace JamesCOMMANDO\Syncpvp\commands;


use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\Config;

class gm extends Command {

    private $plugin;

    public function __construct(Main $plugin)
{
    parent::__construct("gm", "sets the gamemode that you want", "/gm 0,1,2,3");
    $this->setPermission("Sync.gm");
    $this->plugin = $plugin;
}

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }

        if(!$sender instanceof Player){
            $sender->sendMessage("You have to be a player to use this command!");
            return true;
        }

        if(empty($args)){
            $sender->sendMessage($this->getUsage());
            return true;
        }

        $settings = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        if(isset($args[1])){
            $player2 = $this->plugin->getServer()->getPlayer($args[1]);
            if($player2 == null) {
                $sender->sendMessage($settings->get("PlayerNotFound"));
                return true;
            }
            $change = $player2->getName();
            if($args[0] == "0"){
                $player2->setGamemode(0);
                $player2->sendMessage($settings->get("GamemodeChange-Message"));
                $sender->sendMessage($this->convert($settings->get("GamemodeChangeOther-Message"), $change));
            } elseif($args[0] == "1"){
                $player2->setGamemode(1);
                $player2->sendMessage($settings->get("GamemodeChange-Message"));
                $sender->sendMessage($this->convert($settings->get("GamemodeChangeOther-Message"), $change));
            } elseif($args[0] == "2"){
                $player2->setGamemode(2);
                $player2->sendMessage($settings->get("GamemodeChange-Message"));
                $sender->sendMessage($this->convert($settings->get("GamemodeChangeOther-Message"), $change));
            } elseif($args[0] == "3"){
                $player2->setGamemode(3);
                $player2->sendMessage($settings->get("GamemodeChange-Message"));
                $sender->sendMessage($this->convert($settings->get("GamemodeChangeOther-Message"), $change));
            }
        } else {
            if($args[0] == "0"){
                $sender->setGamemode(0);
                $sender->sendMessage($settings->get("GamemodeChange-Message"));
            } elseif($args[0] == "1"){
                $sender->setGamemode(1);
                $sender->sendMessage($settings->get("GamemodeChange-Message"));
            } elseif($args[0] == "2"){
                $sender->setGamemode(2);
                $sender->sendMessage($settings->get("GamemodeChange-Message"));
            } elseif($args[0] == "3"){
                $sender->setGamemode(3);
                $sender->sendMessage($settings->get("GamemodeChange-Message"));
            }
        }

        return false;
    }

    private function convert(string $string, $change): string{
        $string = str_replace("{player}", $change, $string);
        return $string;
    }
}