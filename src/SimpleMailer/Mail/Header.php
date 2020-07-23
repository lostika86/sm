<?php namespace JPackages\SimpleMailer\Mail;

use Illuminate\Support\Arr;
use JPackages\SimpleMailer\Config;

class Header
{

	public static function to(array $input)
	{
		$formHeader 	= Config::header();

		$clientTo = Arr::only($input, $formHeader['client_from']);

		return [
			$formHeader['application_from'][0] => $formHeader['application_from'][1],
			$clientTo[$formHeader['client_from'][0]] => $clientTo[$formHeader['client_from'][1]]
		];
	}
}