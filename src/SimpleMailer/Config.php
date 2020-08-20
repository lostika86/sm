<?php namespace JPackages\SimpleMailer;

use JPackages\SimpleMailer\Mail\MailTransport;

abstract class Config
{
	public static function formConfig(): array
	{
		$formFields = self::getFormFields();

		$formHeader = [
			'application_from' 	=> [MailTransport::getFromEmail(), MailTransport::getFromName()],  // email FROM detail from application view
		];

		if (empty(self::getClientEmailDetails())) {
			throw new \Exception('E-mail base details are not correctly defined, check "actions" on form field confing.');
		}

		$formHeader['client_from'] = self::getClientEmailDetails();

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

	protected static function getClientEmailDetails()
	{
		$formFields = self::getFormFields();

		$emailDetails = [];
		$fromEmailExists = false;
		foreach ($formFields as $formField) {
			if (array_key_exists('actions', $formField) && is_array($formField['actions']) && !empty($actions = $formField['actions'])) {
				if (in_array('key_from_email', $actions, true)) {
					$fromEmailExists = true;
					$emailDetails['key_from_email'] = $formField['name'];
				}

				if (in_array('key_from_name', $actions, true)) {
					$emailDetails['key_from_name'] = $formField['name'];
				}
			}
		}

		if (!$fromEmailExists) {
			return [];
		}

		return $emailDetails;
	}

	public static function getClientEmailSubjectBlock()
	{
		$formFields = self::getFormFields();


		foreach ($formFields as $formField) {
			if (array_key_exists('actions', $formField) && is_array($formField['actions']) && !empty($actions = $formField['actions'])) {
				if (in_array('key_mail_subject', $actions, true)) {

					return $formField['name'];
				}

			}
		}


		return '';
	}

	public static function getFormFields(): array
	{
		$formFields = [];
		if (defined('JPACKAGE_FORM_FIELDS')) {
			$formFields = JPACKAGE_FORM_FIELDS;
		}
		return $formFields;
	}


}