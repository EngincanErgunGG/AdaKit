<?php

namespace KurSkyTR;

use pocketmine\{

	plugin\PluginBase,	command\CommandSender,

	command\Command,

	utils\MainLogger as M,

	utils\Config,

	item\Item,

	Player

};

use FormAPI\{

	SimpleForm,

	ModalForm,

	Form

};

class AdaKit extends PluginBase {

	

	/** @var Config */

	public $cfg;

	

	public function onEnable(){

		M::getLogger()->info("Eklenti aktif edildi.");

		@mkdir($this->getDataFolder());

		$this->cfg = new Config($this->getDataFolder() . "config.yml", Config::YAML);

	}

	

	public function onCommand(CommandSender $e, Command $kmt, String $lbl, Array $args): bool{

		if($kmt->getName() == "adakit"){

			if($e instanceof Player){

				$f = new SimpleForm(function (Player $e, $data){

					if($data === null) return true;

					switch($data){

						case 0;

						break;

						case 1;

						$modalform = new ModalForm(function (Player $e, $dataa){

							if($dataa === null) return true;

							switch($dataa){

								case true;

								$c = $this->cfg->get($e->getName());

								if($c["Başlangıç"] >= $c["Bitiş"]){

									$e->getInventory()->addItem(Item::get(Item::MELON, 0, 10), Item::get(Item::SUGARCANE, 0, 10), Item::get(Item::STONE, 0, 32), Item::get(Item::EMERALD, 0, 3), Item::get(Item::DIAMOND, 0, 5));

									$zaman = time();

									$bugun = date('d.m.y', $zaman);

									$bitis = strtotime("+2 years", $zaman);

									$this->cfg->set($e->getName(), [

									"Kit" => "Ada Kit",

									"Başlangıç" => $bugun,

									"Bitiş" => $bitis

									]);

									$this->cfg->save();

									$e->sendMessage("§eAda kiti alındı.");

								}else{

									$e->sendMessage("§cAda kitini sadece 1 kere alabilirsiniz.");

								}

								break;

								case false;

								break;

							}

						});

						$modalform->setTitle("Ada Kit");

						$modalform->setContent("\nAlınacak Kit : Ada Kit\nEşyalar:\n\n10 Adet Karpuz\n10 Adet Şeker Kamışı\n32 Adet Taş\n3 Tane Zümrüt\n5 Tane Elmas\n\nBu kiti seçmek istiyormusunuz?");

						$modalform->setButton1("Evet");

						$modalform->setButton2("Hayır");

						$modalform->sendToPlayer($e);

						break;

					}

				});

				$f->setTitle("Ada Kit");

				$f->setContent("");

				$f->addButton("§cKapat");

				$f->addButton("Oyuncu Ada Kit", 0,"textures/items/wood_sword");

				$f->sendToPlayer($e);

			}else{

				$e->sendMessage("§cBu komut oyunda kullanılabilir.");

			}

		}

		return true;

	}

}
