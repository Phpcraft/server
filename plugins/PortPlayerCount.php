<?php
use Phpcraft\
{ClientConnection, Event\ServerListPingEvent, Plugin};
/**
 * Makes the max. player count equal to the host port used by the list-pinging client.
 *
 * @var Plugin $this
 */
$this->on(function(ServerListPingEvent $event)
{
	if(array_key_exists("players", $event->data) && $event->client instanceof ClientConnection)
	{
		$event->data["players"]["max"] = $event->client->hostport;
	}
});
