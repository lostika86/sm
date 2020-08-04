<?php namespace JPackages\SimpleMailer;

use JPackages\SimpleMailer\Mail\MailTransport;

abstract class Config
{
	public static function formConfig(): array
	{
		$formFields = [];
		if (defined('JPACKAGE_FORM_FIELDS')) {
			$formFields = JPACKAGE_FORM_FIELDS;
		}

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