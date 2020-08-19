<?php namespace JPackages\SimpleMailer\Mail;

use Illuminate\Support\Arr;
use JPackages\SimpleMailer\Config;

class Header
{

	public static function to(array $input)
	{
		$formHeader 	= Config::header();

		$clientFromEmailDetails  = $formHeader['client_from'];
		$clientTo = Arr::only($input, $clientFromEmailDetails);

		$to = [
			$formHeader['application_from'][0] => $formHeader['application_from'][1],
		];

		if (isset($formHeader['client_from']['key_from_name'])) {
			$append = [$clientTo[$formHeader['client_from']['key_from_email']] => $clientTo[$formHeader['client_from']['key_from_name']]];
		} else{
			$append = $clientTo[$formHeader['client_from']['key_from_email']];
		}
		$to = array_merge($to, $append);

		return $to;
	}
}