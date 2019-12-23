<?php
/**
 * Yeets clients up if they enter the void down below.
 *
 * @var Plugin $this
*/
use Phpcraft\
{EffectType, Event\ServerMovementEvent, Packet\EntityEffectPacket, Packet\RemoveEntityEffectPacket, Plugin};
use pas\pas;
$this->on(function(ServerMovementEvent $event)
{
	if($event->client->pos->y < -16)
	{
		$event->client->startPacket("entity_velocity");
		$event->client->writeVarInt($event->client->eid);
		$event->client->writeShort(0);
		$event->client->writeShort(25000);
		$event->client->writeShort(0);
		$event->client->send();
	}
});
