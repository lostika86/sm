<?php namespace JPackages\SimpleMailer\Recaptcha;

use ReCaptcha\ReCaptcha;

final class CaptchaValidator
{
	CONST CAPTCHA_RESPONSE_KEY  = 'g-recaptcha-response';
	/** @var ReCaptcha */
	private $recaptcha;

	public function __construct()
	{
		$this->recaptcha 	= new ReCaptcha(getenv('RECAPTCHA_SECRET_KEY'));
		$this->recaptcha->setExpectedHostname(getenv('SITE_HOSTNAME'));

	}

	public static function verify(string $reCaptchaResponse, $remoteIp = null) : array
	{
		$captchaValidator 	= new static();
		$result 	= $captchaValidator->recaptcha->verify($reCaptchaResponse, $remoteIp);

		if (!$result->isSuccess()) {
			return $result->getErrorCodes();
		}

		$score = $result->getScore();

		if ($score < 0.8) {
			return [ErrorCodes::LOW_SCORE_RATE];
		}

		return [];
	}


}