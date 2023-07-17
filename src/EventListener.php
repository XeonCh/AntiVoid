<?php

declare(strict_types = 1);

namespace xeonch\antivoid;

use FG\ASN1\Construct;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;

class EventListener implements Listener {

    /** @var Loader */
    public $pl;

    public function __construct(Loader $plugin) {
        $this->pl = $plugin;
    }

    public function onMove(PlayerMoveEvent $event) {
        $player = $event->getPlayer();
        $pos = $player->getPosition();
        if ($pos->getY() < 0) {
            if ($this->pl->getSetting()->get("enable-antivoid", true)) {
                if ($this->pl->checkWorld($player->getWorld())) {
                    $player->teleport($player->getWorld()->getSpawnLocation());
                    if ($this->pl->getConfig()->getNested("message.enable", true)) {
                        $msg = str_replace(["&", "{player}"], ["§", $player->getName()], $this->pl->getConfig()->getNested("message.msg"));
                        $player->sendMessage($msg);
                    }
                }
            }
        }
    }
}