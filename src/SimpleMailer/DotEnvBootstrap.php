<?php namespace JPackages\SimpleMailer;

use Dotenv\Dotenv;

final class DotEnvBootstrap
{
	public static function make(string $path = __DIR__.'/../../../../')
	{
		$dotenv = Dotenv::create($path);
		$dotenv->load();
	}
}