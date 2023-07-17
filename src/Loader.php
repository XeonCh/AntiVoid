<?php

declare(strict_types = 1);

namespace xeonch\antivoid;

use pocketmine\plugin\PluginBase;
use xeonch\antivoid\commands\AntiVoidCommand;

use pocketmine\utils\{TextFormat, Config};
use pocketmine\world\World;

use CortexPE\Commando\BaseCommand;
use CortexPE\Commando\PacketHooker;

class Loader extends PluginBase {

    /** @var Loader */
    public static $instance;

    public $setting;

    public function onLoad():void
    {
        self::$instance = $this;
    }

    public function onEnable():void
    {
        $this->saveDefaultConfig();
        $this->setting = new Config($this->getDataFolder() . "setting.yml", Config::YAML, [
            "enable-antivoid" => true
        ]);
        $this->setting->save();
        $this->getServer()->getCommandMap()->register("antivoid", new AntiVoidCommand($this, "antivoid", "AntiVoid command", ["av"]));
        $this->getserver()->getPluginManager()->registerEvents(new EventListener($this), $this);
    }

    private function loadVirion():void
    {
        foreach ([
            "Commando" => BaseCommand::class
        ] as $virion => $class
        ) {
            if (!class_exists($class)) {
                $this->getLogger()->error($virion . " virion not found.");
                $this->getServer()->getPluginManager()->disablePlugin($this);
                return;
            }
        }

        if (!PacketHooker::isRegistered()) {
            PacketHooker::register($this);
        }
    }
    
    public function getSetting()
    {
        return $this->setting;
    }

    public static function getInstance(): self
    {
        return self::$instance;
    }
    
    public function checkWorld(World $world): bool {
        $enabledWorlds = $this->getConfig()->get("enable-world", []);
        $disabledWorlds = $this->getConfig()->get("disable-world", []);
        $worldName = $world->getFolderName();
        
        if (in_array($worldName, $enabledWorlds)) {
            return true;
        } elseif (in_array($worldName, $disabledWorlds)) {
            return false;
        } else {
            return true;
        }
    }    
}