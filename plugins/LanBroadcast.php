<?php /** @noinspection PhpUndefinedFieldInspection */
/**
 * Broadcasts the server to the entire <del>world</del> local area network!
 *
 * @var Plugin $this
 */
use Phpcraft\
{ChatComponent, Event\ServerTickEvent, LanInterface, Plugin};
$this->next_announce = 0;
$this->on(function(ServerTickEvent $e)
{
	if($e->server->isListening() && --$this->next_announce <= 0)
	{
		$this->next_announce = 30;
		LanInterface::announce(explode("\n", $e->server->getMotd()
													   ->toString(ChatComponent::FORMAT_SILCROW))[0], $e->server->getPorts()[0]);
	}
});
