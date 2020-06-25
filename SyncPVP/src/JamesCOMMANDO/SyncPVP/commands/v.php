<?php


namespace JamesCOMMANDO\Syncpvp\commands;


use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\entity\Entity;
use pocketmine\Player;
use pocketmine\utils\Config;

class v extends Command {

    public $vanish = array();
    private $plugin;

    public function __construct(Main $plugin)
    {
        parent::__construct("v", "makes you vanish", "/vanish");
        $this->setPermission("sync.vanish");
        $this->plugin = $plugin;
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args){
        if(!$this->testPermission($sender)){
            return false;
        }

        if(!$sender instanceof Player){
            $sender->sendMessage("You must be a player to use this command!");
            return true;
        }

        $settings = new Config($this->plugin->getDataFolder() . "messages.yml", Config::YAML);
        if(empty($args[0])){
            if(!in_array($sender->getName(), $this->vanish)){
                $this->vanish[] = $sender->getName();
                $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
                $sender->setNameTagVisible(false);
                $sender->sendMessage("You are now vanished!");
            }elseif(in_array($sender->getName(), $this->vanish)){
                unset($this->vanish[array_search($sender->getName(), $this->vanish)]);
                $sender->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
                $sender->setNameTagVisible(true);
                $sender->sendMessage("You are not vanished!");
            }
            return false;
        }

        if($this->plugin->getServer()->getPlayer($args[0])) {
            $player = $this->plugin->getServer()->getPlayer($args[0]);
            $change = $player->getName();
            if (!in_array($player->getName(), $this->vanish)) {
                $this->vanish[] = $player->getName();
                $player->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, true);
                $player->setNameTagVisible(false);
                $player->sendMessage("You are vanished!");
                $sender->sendMessage($this->convert($change, "{player} is now vanished!"));
            } elseif (in_array($player->getName(), $this->vanish)) {
                unset($this->vanish[array_search($player->getName(), $this->vanish)]);
                $player->setDataFlag(Entity::DATA_FLAGS, Entity::DATA_FLAG_INVISIBLE, false);
                $player->setNameTagVisible(true);
                $player->sendMessage("You are not vanished!");
                $sender->sendMessage($this->convert($change, "{player} is not vanished!"));
            }
        }else{
            $sender->sendMessage($settings->get("PlayerNotFound"));
            return false;
        }
        return false;
    }

    private function convert(string $string, $change): string{
        $string = str_replace("{player}", $change, $string);
        return $string;
    }
}