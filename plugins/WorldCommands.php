<?php
/**
 * @var Plugin $this
 */
use Phpcraft\
{ChatComponent, ClientConnection, Command\ServerCommandSender, Plugin};
$this->registerCommand("world", function(ClientConnection $con, string $world = "")
{
	if($world)
	{
		if(array_key_exists($world, $con->getServer()->worlds))
		{
			$con->world = $world;
			$con->chunks = [];
			$con->generateChunkQueue();
		}
		else
		{
			$con->sendMessage(ChatComponent::text("'$world' is not a valid world on this server. Use /worlds for a list of worlds.")
										   ->red());
		}
	}
	else
	{
		$con->sendMessage(ChatComponent::text("You are currently in world '".$con->world."'."));
	}
})
	 ->registerCommand("worlds", function(ServerCommandSender $sender)
	 {
		 $sender->sendMessage("This server has the following worlds: ".join(", ", array_keys($sender->getServer()->worlds)));
	 });
