<?php
/**
 * Allows clients to bullet jump, aka. give them velocity in the rough direction they're looking when they sneak + jump.
 *
 * @var Plugin $this
 */
use Phpcraft\Event\ServerOnGroundChangeEvent;
use Phpcraft\Plugin;
$this->on(function(ServerOnGroundChangeEvent $event)
{
    if(!$event->client->on_ground && $event->client->entityMetadata->crouching)
    {
		$con = $event->client;
		$y_perc = 100 / 90 * (90 - abs($con->pitch)) / 100;
		$x = sin(pi() / 180 * $con->yaw) * $y_perc * -13;
		$y = (1 - $y_perc) * 7 + 1;
		$z = cos(pi() / 180 * $con->yaw) * 13;
		$con->startPacket("entity_velocity");
		$con->writeVarInt($con->eid);
		$con->writeShort($x * 1000);
		$con->writeShort($y * 1000);
		$con->writeShort($z * 1000);
		$con->send();
    }
});
