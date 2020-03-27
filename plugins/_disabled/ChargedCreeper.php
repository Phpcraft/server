<?php
/**
 * @var Plugin $this
 */
use Asyncore\Asyncore;
use Phpcraft\
{ClientConnection, Entity\EntityType, Packet\SpawnMobPacket, Plugin, Server};
$this->registerCommand("chargedcreeper", function(ClientConnection $client)
{
	$packet = new SpawnMobPacket($client->getServer()->eidCounter->next(), EntityType::get("creeper"));
	$direction = $client->getUnitVector()
						->multiply(3);
	$direction->y = 0;
	$packet->pos = $client->getPosition()
						  ->add($direction);
	$packet->metadata->charged = true;
	$packet->send($client);
});
