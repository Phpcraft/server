<?php
echo "Phpcraft PHP Minecraft Server\n\n";
if(empty($argv))
{
	die("This is for PHP-CLI. Connect to your server via SSH and use `php server.php`.\n");
}
require __DIR__."/vendor/autoload.php";
use Phpcraft\
{Command\Command, Event\ServerConsoleEvent, Event\ServerTickEvent, IntegratedServer, PluginManager};
use pas\pas;
$server = IntegratedServer::cliStart("Phpcraft Server", [
	"groups" => [
		"default" => [
			"allow" => [
				"use /me",
				"use /gamemode",
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
pas::on("stdin_line", function(string $msg) use (&$server)
{
	if($msg && !Command::handleMessage($server, $msg) && !PluginManager::fire(new ServerConsoleEvent($server, $msg)))
	{
		$server->broadcast([
			"translate" => "chat.type.announcement",
			"with" => [
				[
					"text" => "Server"
				],
				[
					"text" => $msg
				]
			]
		]);
	}
});
$server->open_condition->add(function(bool $lagging) use (&$server)
{
	PluginManager::fire(new ServerTickEvent($server, $lagging));
}, 0.05);
pas::loop();
$server->ui->add("Server is not listening on any ports and has no clients, so it's shutting down.");
$server->ui->render();
