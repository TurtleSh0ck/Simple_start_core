<?php


namespace JamesCOMMANDO\SyncPVP;


use Frago9876543210\EasyForms\elements\Label;
use Frago9876543210\EasyForms\forms\CustomForm;
use Frago9876543210\EasyForms\forms\CustomFormResponse;
use pocketmine\event\Listener;
use JamesCOMMANDO\SyncPVP\Main;
use pocketmine\event\player\PlayerJoinEvent;
use Frago9876543210\EasyForms\EasyForms;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\Player;
use pocketmine\utils\TextFormat;

class PlayerListenerr implements PlayerListener{
/*
    public function onJoin(PlayerJoinEvent $event){
        $player = $event->getPlayer();
        $player->removeAllEffects();
        if(!$event->getPlayer()->hasPlayedBefore()){
            $player->sendForm(new CustomForm("Welcome to AtlasPVP",
            [
                new Label("Welcome to SyncPVP we hope you enjoy our server!")
            ],
            function (Player $player, CustomFormResponse $response){
                $player->sendMessage(TextFormat::GOLD . "Hope you like our server!");
            }));
        }
        if($event->getPlayer()->hasPlayedBefore()){
            $player->sendForm(new CustomForm("Welcome back!",
            [
                new Label("Welcome back, I hope you enjoy our server like how we enjoyed making it!")
            ], function (Player $player, CustomFormResponse $response) : void{
                $player->sendMessage(TextFormat::GOLD . "Welcome back!");
                }));
        }
    }


    public function onLeave(PlayerQuitEvent $event){
        $player = $event->getPlayer();
    }
*/
}
