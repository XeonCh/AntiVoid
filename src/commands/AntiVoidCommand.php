<?php

declare(strict_types=1);

namespace xeonch\antivoid\commands;

use xeonch\antivoid\Loader;
use pocketmine\command\CommandSender;
use CortexPE\Commando\BaseCommand;
use xeonch\antivoid\commands\subcommands\EnableAntiVoidSubCommand;
use xeonch\antivoid\commands\subcommands\DisableAntiVoidSubCommand;

class AntiVoidCommand extends BaseCommand{

    /** @var Loader */
    protected $plugin;

    /**
     * @return void
     */
	protected function prepare(): void{
        $this->registerSubCommand(new EnableAntiVoidSubCommand($this->plugin, "enable", "enable world AntiVoid"));
        $this->registerSubCommand(new DisableAntiVoidSubCommand($this->plugin, "disable", "disable world AntiVoid"));
        $this->setPermission($this->getPermission());
    }

    public function getPermission()
    {
        return "antivoid.cmd";
    }
    /**
     * @param CommandSender $sender
     * @param string $aliasUsed
     * @param array $args
     * @return void
     */
    public function onRun(CommandSender $sender, string $aliasUsed, array $args): void{
    	$this->sendUsage();
    }
}