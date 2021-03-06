<?php
/**
 * My dad works at Microsoft and he's gonna get you banned from this server.
 * Wait, Microsoft actually owns Minecraft now.
 * Shit.
 *
 * @var Plugin $this
 */
use hotswapp\Event;
use Phpcraft\
{ChatComponent, ClientConfiguration, ClientConnection, Command\CommandSender, Command\GreedyString, Event\ServerJoinEvent, Plugin};
$this->on(function(ServerJoinEvent $e)
{
	$ban_reason = $e->client->config->get("ban");
	if($ban_reason !== null)
	{
		$e->client->disconnect([
			"text" => $ban_reason === true ? "You have been banned from this server." : $ban_reason
		]);
		$e->cancelled = true;
	}
}, Event::PRIORITY_HIGHEST);
$this->registerCommand("ban", function(CommandSender &$sender, ClientConfiguration $victim, GreedyString $reason = null)
{
	if($sender instanceof ClientConnection && $sender->config === $victim)
	{
		$sender->sendMessage("Silly you.");
		return;
	}
	if($victim->hasPermission("unbannable"))
	{
		$sender->sendMessage(ChatComponent::text("You can't ban the unbannable ".$victim->getName().". I can't believe you even tried.")
										  ->red());
		return;
	}
	$victim->set("ban", $reason ? $reason->value : true);
	if($victim->isOnline())
	{
		$victim->getPlayer()
			   ->disconnect("You have been banned from this server".($reason ? ": ".$reason->value : "."));
	}
	$sender->sendAdminBroadcast(ChatComponent::text($victim->getName()." has been banned.".($reason === null ? " And you didn't even need a reason, apparently." : ""))
											 ->yellow(), "use /ban");
}, "use /ban");
$this->registerCommand([
	"unban",
	"pardon"
], function(CommandSender &$sender, ClientConfiguration $victim)
{
	if($victim->has("ban"))
	{
		$victim->unset("ban");
		$sender->sendAdminBroadcast(ChatComponent::text($victim->getName()." has been unbanned.")
												 ->green(), "use /unban");
	}
	else
	{
		$sender->sendMessage(ChatComponent::text($victim->getName()." is not banned. Better safe than sorry?")
										  ->yellow());
	}
}, "use /unban");
