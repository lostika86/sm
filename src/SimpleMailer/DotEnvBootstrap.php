<?php namespace JPackages\SimpleMailer;

use Dotenv\Dotenv;

final class DotEnvBootstrap
{
	public static function make(string $path = '/../../')
	{
		$dotenv = Dotenv::createImmutable(__DIR__.$path);
		$dotenv->load();
	}
}