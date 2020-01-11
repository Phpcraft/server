<?php
/**
 * @var Plugin $this
 */
use hotswapp\Event;
use Phpcraft\
{ChatComponent, Event\ServerJoinEvent, Plugin};
$this->on(function(ServerJoinEvent $event)
{
	if($event->cancelled)
	{
		return;
	}
	$event->client->startPacket("player_list_header_and_footer");
	$event->client->writeChat(ChatComponent::text("Phpcraft Server"));
	$event->client->writeChat(ChatComponent::text("phpcraft.de"));
	$event->client->send();
}, Event::PRIORITY_LOW);
