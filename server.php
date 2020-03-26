<?php
echo "Phpcraft PHP Minecraft Server\n\n";
if(empty($argv))
{
	die("This is for PHP-CLI. Connect to your server via SSH and use `php server.php`.\n");
}
require __DIR__."/vendor/autoload.php";
use Asyncore\Asyncore;
use Phpcraft\
{ChatComponent, Command\Command, Event\ServerConsoleEvent, IntegratedServer, PluginManager};
$server = IntegratedServer::cliStart("Phpcraft Server", [
	"groups" => [
		"default" => [
			"allow" => [
				"use /me",
				"use /gamemode",
				"use /noclipcreative",
				"use /metadata",
				"change the world"
			]
		],
		"user" => [
			"inherit" => "default",
			"allow" => [
				"use /abilities",
				"use chromium"
			]
		],
		"admin" => [
			"allow" => "everything"
		]
	]
]);
echo "Loading plugins...\n";
PluginManager::loadPlugins();
echo "Loaded ".count(PluginManager::$loaded_plugins)." plugin(s).\n";
$server->ui->render();
Asyncore::on("stdin_line", function(string $msg) use (&$server)
{
	if($msg && !Command::handleMessage($server, $msg) && !PluginManager::fire(new ServerConsoleEvent($server, $msg)))
	{
		$server->broadcast(ChatComponent::translate("chat.type.announcement", [
			"Server",
			$msg
		]));
	}
});
Asyncore::loop();
$server->ui->add("Server is not listening on any ports and has no clients, so it's shutting down.");
$server->ui->render();
