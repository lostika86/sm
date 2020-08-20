<?php namespace JPackages\SimpleMailer\Mail;

use Illuminate\Support\Arr;
use JPackages\SimpleMailer\Config;

class Header
{

	const KEY_CLIENT_FROM_CONTAINER = 'client_from';
	const KEY_APPLICATION_FORM_CONTAINER          = 'application_from';

	public static function to(array $input)
	{
		$formHeader 	= Config::header();

		$clientFromEmailDetails  = $formHeader[ self::KEY_CLIENT_FROM_CONTAINER ];
		$clientTo = Arr::only($input, $clientFromEmailDetails);

		$to = [
			$formHeader[ self::KEY_APPLICATION_FORM_CONTAINER ][0] => $formHeader[ self::KEY_APPLICATION_FORM_CONTAINER ][1],
		];

		if (isset($formHeader[ self::KEY_CLIENT_FROM_CONTAINER ]['key_from_name'])) {
			$append = [$clientTo[ $formHeader[ self::KEY_CLIENT_FROM_CONTAINER ]['key_from_email']] => $clientTo[ $formHeader[ self::KEY_CLIENT_FROM_CONTAINER ]['key_from_name']]];
		} else{
			$append = $clientTo[ $formHeader[ self::KEY_CLIENT_FROM_CONTAINER ]['key_from_email']];
		}
		$to = array_merge($to, $append);

		return $to;
	}
}