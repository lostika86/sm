<?php namespace JPackages\SimpleMailer;

use JPackages\SimpleMailer\Mail\MailTransport;

abstract class Config
{
	public static function formConfig(): array
	{
		$formFields 	= [
			[
				'type' 	=> 'text',
				'name' => 'contact_name',
				'rules' =>  ['notEmpty', 'stringType'],
				'trans' => 'Kontaktná osoba',
			],
			[
				'type' 	=> 'text',
				'name' => 'email',
				'rules' =>  ['notEmpty', 'email'],
				'trans' => 'E-mail',

			],
			[
				'type' 	=> 'textarea',
				'name' => 'message',
				'rules' =>  ['notEmpty', 'stringType'],
				'trans' => 'Správa',

			],
			[
				'type' 	=> 'input',
				'name' => 'g-recaptcha-response',
				'rules' =>  ['notEmpty', 'stringType'],
				'trans' => 'g-recaptcha-response error',

			],
		];

		$formHeader = [
			'application_from' 	=> [MailTransport::getFromEmail(), MailTransport::getFromName()],  // email FROM detail from application view
			'client_from' 	=> ['email', 'contact_name'], // email FROM detail - client
		];

		return [
			'formFields' => $formFields,
			'formHeader' => $formHeader
		];
	}

	public static function fields() : array
	{
		return self::formConfig()['formFields'];
	}

	public static function header() : array
	{
		return self::formConfig()['formHeader'];
	}
}