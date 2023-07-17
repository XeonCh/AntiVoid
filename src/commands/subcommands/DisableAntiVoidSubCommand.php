<?php

declare(strict_types = 1);

namespace xeonch\antivoid\commands\subcommands;

use CortexPE\Commando\BaseSubCommand;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\player\Player;
use xeonch\antivoid\Loader;

class DisableAntiVoidSubCommand extends BaseSubCommand
{
    
    public function prepare():void
    {
        $this->setPermission("antivoid.disable.cmd");
    }
    
    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void
    {
        if(!$sender instanceof Player){
            $sender->sendMessage(TextFormat::RED . "Use this command in game");
            return;
        }
        if (Loader::getInstance()->getSetting()->get("enable-antivoid") == false) {
            $sender->sendMessage(TextFormat::RED . "Antivoid already disable");
            return;
        }
        $sender->sendMessage(TextFormat::GREEN . "AntiVoid disable");
        Loader::getInstance()->getSetting()->set("enable-antivoid", false);
        Loader::getInstance()->getSetting()->save();
    }
}