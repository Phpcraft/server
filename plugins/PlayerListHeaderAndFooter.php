<?php
/**
 * @var Plugin $this
 */
use Phpcraft\
{Event\Event, Event\ServerJoinEvent, Plugin};
$this->on(function(ServerJoinEvent $event)
{
	if($event->cancelled)
	{
		return;
	}
	$event->client->startPacket("player_list_header_and_footer");
	$event->client->writeString('{"text":"Phpcraft Server"}');
	$event->client->writeString('{"text":"phpcraft.de"}');
	$event->client->send();
}, Event::PRIORITY_LOW);
