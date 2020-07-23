<?php namespace JPackages\SimpleMailer\Recaptcha;

class ValidationMessage
{
	protected $errorCodes;

	public function errorMessages() : array
	{
		$captchaDefaultError = ValidationMessage::lowScoreMessage();

		$messages 	= [];
		foreach ($this->errorCodes as $errorCode) {

			if (ErrorCodes::hasError([$errorCode])) {
				switch ($errorCode){
					case ErrorCodes::LOW_SCORE_RATE:
						$message 	= $captchaDefaultError;
						break;
					case ErrorCodes::TIMEOUT_OR_DUPLICATE:
						$message 	= self::timeoutMessage();
						break;
					default: $message = $captchaDefaultError;
				}

				$messages[] = $message;
			}

		}

		return $messages;
	}

	/**
	 * @param array|string[]
	 * @return ValidationMessage
	 */
	public function setErrorCodes($errorCodes)
	{
		$this->errorCodes = $errorCodes;
		return $this;
	}

	/**
	 * @return string
	 */
	public static function lowScoreMessage()
	{
		// TODO make translatable
		return 'Message was not sent, blocked by captcha.';
	}

	public static function timeoutMessage() : string
	{
		return 'Message blocked by spam filter, please refresh page.';
	}

}