<?php

namespace BeeAZ\AcidIsland\commands\subcommand;

use pocketmine\Server;
use pocketmine\command\CommandSender;
use BeeAZ\AcidIsland\AcidIsland;
use pocketmine\world\Position;

class Teleport {


	public function onCommand(CommandSender $player, array $args) {
		if (!$player->hasPermission("acidisland.teleport")) {
			return true;
		}
		if (count($args) < 2) {
			return true;
		}
		$name = strtolower(implode(" ", array_slice($args, 1)));
		$ai = AcidIsland::getInstance();
		if ($ai->isIsland($name)) {
			if ($ai->getIsland($name)->get("lock") === false) {
				Server::getInstance()->getWorldManager()->loadWorld("ai-" . $name);
				$player->teleport(new Position(7, 65, 5, Server::getInstance()->getWorldManager()->getWorldByName("ai-" . $name)));
				$player->sendMessage(str_replace("{island}", $name, $ai->cfg->get("ISLAND-TELEPORT")));
			} else {
				$player->sendMessage($ai->cfg->get("ISLAND-TELEPORT-LOCK"));
			}
		} else {
			$player->sendMessage($ai->cfg->get("ISLAND-NOTFOUND"));
		}
	}
}
