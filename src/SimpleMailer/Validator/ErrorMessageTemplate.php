<?php namespace JPackages\SimpleMailer\Validator;

class ErrorMessageTemplate
{
	protected $template = 'Error :attribute';

	/**
	 * Builds a simple message.
	 * @param string $attribute
	 * @return string
	 */
	public function getErrorMessage(string $attribute) : string
	{
		return ucfirst(strtolower(str_replace(':attribute', $attribute, $this->template)));
	}


}