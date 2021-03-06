<?php /** @noinspection PhpComposerExtensionStubsInspection */
/**
 * Loads a 128x128 image from map.png and displays it to clients as a map.
 *
 * @var Plugin $this
 */
use hotswapp\Event;
use Phpcraft\
{Event\ServerJoinEvent, Item, NBT\CompoundTag, NBT\IntTag, NBT\StringTag, Packet\MapData\MapDataPacket, Packet\SetSlotPacket, Phpcraft, Plugin, Slot};
$WorldImitatorActive = false;
if(!extension_loaded("gd"))
{
	echo "[Map] Install the PHP gd extension if you want to see PNG images as in-game maps.\n";
	$this->unregister();
	return;
}
$this->on(function(ServerJoinEvent $event)
{
	if($event->cancelled)
	{
		return;
	}
	global $WorldImitatorActive;
	if($WorldImitatorActive)
	{
		return;
	}
	$con = $event->client;
	(new SetSlotPacket(0, Slot::HOTBAR_2, Item::get("filled_map")
											  ->slot(1, new CompoundTag("tag", [
												  new CompoundTag("display", [
													  new StringTag("Name", json_encode(Phpcraft::textToChat("§4§lMÄP")))
												  ]),
												  new IntTag("map", 1337),
											  ]))))->send($con);
	$packet = new MapDataPacket();
	$packet->mapId = 1337;
	$packet->width = 128;
	$packet->height = 128;
	$img = imagecreatefrompng(__DIR__."/map.png");
	for($y = 0; $y < 128; $y++)
	{
		for($x = 0; $x < 128; $x++)
		{
			$rgb = imagecolorat($img, $x, $y);
			$r = ($rgb >> 16) & 0xFF;
			$g = ($rgb >> 8) & 0xFF;
			$b = $rgb & 0xFF;
			array_push($packet->contents, MapDataPacket::getColorId([
				$r,
				$g,
				$b
			]));
		}
	}
	$packet->send($con);
}, Event::PRIORITY_LOWEST);
