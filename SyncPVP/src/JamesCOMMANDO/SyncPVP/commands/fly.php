<?php


namespace JamesCOMMANDO\Syncpvp\commands;


use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\Player;
use pocketmine\utils\Config;

class fly extends Command {

    private $plugin;
    public function __construct(Main $plugin)
    {
        parent::__construct("fly", "lets you fly!", "/fly");
        $this->setPermission("sync.fly");
        $this->plugin = $plugin;
    }
    private function convert(string $string, $change): string
    {
        $string = str_replace("{player}", $change, $string);
        var_dump($change, $string);
        return $string;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }

        if(!$sender instanceof Player){
            $sender->sendMessage("You must be a player to use this command!");
            return false;
        }

        $settings = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        if(isset($args[0])){
            $player2 = $this->plugin->getServer()->getPlayer($args[0]);
            if($player2 == null) {
                $sender->sendMessage($settings->get("PlayerNotFound"));
                return true;
            }
            $change = $player2->getName();


            if(!$player2->isCreative()){
                if(!$player2->getAllowFlight()){
                    $player2->setAllowFlight(true);
                    $player2->setFlying(true);
                    $player2->sendMessage($settings->get("FlyEnabled-Message"));
                    $sender->sendMessage($this->convert($settings->get("FlyEnabledOther-Message"), $change));
                }else{
                    $player2->setAllowFlight(false);
                    $player2->setFlying(false);
                    $player2->sendMessage($settings->get("FlyDisabled-Message"));
                    $sender->sendMessage($this->convert($settings->get("FlyDisabledOther-Message"), $change));
                }
            }else{
                $sender->sendMessage($settings->get("PlayerCreativeOther-Message"));
                return false;
            }
        } else{
            if(!$sender->isCreative()){
                if(!$sender->getAllowFlight()){
                    $sender->setAllowFlight(true);
                    $sender->setFlying(true);
                    $sender->sendMessage("Flying enabled");
                }else{
                    $sender->setAllowFlight(false);
                    $sender->setFlying(false);
                    $sender->sendMessage("Flight disabled");
                }
            }else{
                $sender->sendMessage($settings->get("PlayerCreative-Message"));
            }
        }

        return false;
    }


}