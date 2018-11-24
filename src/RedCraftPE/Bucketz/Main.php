<?php

namespace RedCraftPE\Bucketz;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\item\Bucket;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\block\Block;
use pocketmine\math\Vector3;

class Main extends PluginBase implements Listener {

	public function onEnable(): void {
	
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
	}
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
	
		switch(strtolower($command)) {
		
			case "bucketz":
				
				if (!$args) {
				
					$this->sendHelp(Player $sender);
					return true;
				} else {
				
					switch($args[0]) {
					
						case "give":
							
							if ($sender->hasPermission("bucketz.give")) {
								
								if (!$args[1]) {
									
									$sender->sendMessage(TextFormat::WHITE . "Usage: /bucketz give <amount>
									return true;							               
								} else {

									$amount = $args[1];
									if (is_numeric($amount)) {
									
										$sender->getInventory()->addItem(Item::get("BUCKET", 0, 1)->setCustomName(TextFormat::AQUA . "GenBucket"));
										$sender->sendMessage(TextFormat::GREEN . "You ");
									} else {
									
										$sender->sendMessage(TextFormat::WHITE . "Usage: /bucketz give [amount]");
										return true;								                                     
									}
								}
							}
						break;
					}
				}
			break;
		}
	}
	public function onPlace(BlockPlaceEvent $event) {
	
		$item = $event->getItem();
		$block = $event->getBlock();
		$level = $block->getLevel();
		
		if ($item instanceof Bucket) {
		
			if ($item->getCustomName() === TextFormat::AQUA . "GenBucket") {
			
				if ($block instanceof Lava || $block instanceof Water) {
				
					$X = $block->getX();
					$Y = $block->getY();
					$Z = $block->getZ();
					$int = 1;
					$level->setBlock($block, Block::get("STONE"));
					$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
					
					while ($blockBelow->getID() === 0) {
					
						$level->setBlock($blockBelow, Block::get("STONE"));
						
						$int++;
						$blockBelow = $level->getBlock(new Vector3($X, $Y - $int, $Z));
					}
				}
			}
		}
	}
}
