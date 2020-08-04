<?php namespace JPackages\SimpleMailer;
use Composer\Script\Event;
class ComposerScripts{

	public static function postUpdate(Event $event)
	{
		$composer = $event->getComposer();
		// do stuff

	}

	public static function postAutoloadDump(Event $event)
	{
		$composer = $event->getComposer()->getConfig()->get('vendor-dir');
		// do stuff

		var_dump($composer);
		exit();
	}

	public static function setupMailer(Event $event)
	{
		$vendorDir = $event->getComposer()->getConfig()->get('vendor-dir');
		// do stuff
		$arguments = $event->getArguments();

		$exampleSrcConfig = self::getConfigFilePath($vendorDir);
		$destinationPath = self::detectConfigPathFromArguments($arguments);

		$fileName = 'mailer_config.php';
		copy($exampleSrcConfig.$fileName,$destinationPath.$fileName);

		var_dump($arguments);
		var_dump($destinationPath);
		var_dump($vendorDir);
		exit();
	}

	private static function getConfigFilePath(string $vendorDir) : string
	{
		return $vendorDir .'/lostika86/sm/example/';
	}

	private static function detectConfigPathFromArguments(array $arguments): string
	{
		$result = array_map('self::getConfigDestinationPathFromArgument',$arguments);

		if (count($result) > 0) {
			return $result[0];
		}

		return '/';
	}

	private static function getConfigDestinationPathFromArgument($argument)
	{
		if (substr_count($argument, '--path=') > 0) {
			return str_replace('--path=','',$argument);
		}

		return false;
	}
}