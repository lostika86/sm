<?php namespace JPackages\SimpleMailer\Validator;

use JPackages\SimpleMailer\Recaptcha\CaptchaValidator;
use Respect\Validation\Rules\AbstractComposite;

class RecaptchaRule extends AbstractComposite
{
	public function validate($input) : bool
	{

		$recaptchaResult = CaptchaValidator::verify($input);

		return empty($recaptchaResult);
	}
}