<?php
/**
 * @var Plugin $this
 */
use Phpcraft\
{ClientConnection, Item, NBT\CompoundTag, NBT\IntTag, Packet\SetSlotPacket, Phpcraft, Plugin, Slot
};
$this->registerCommand([
	"leatherchestplate",
	"leather_chestplate"
], function(ClientConnection $client)
{
	(new SetSlotPacket(0, Slot::HOTBAR_1, Item::get("leather_chestplate")
											  ->slot(1, new CompoundTag("", [
												  new CompoundTag("display", [
													  new IntTag("color", Phpcraft::rgbToInt([
														  255,
														  0,
														  255
													  ]))
												  ]),
												  new IntTag("map", 1337),
											  ]))))->send($client);
});
