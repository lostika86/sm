<?php namespace JPackages\SimpleMailer\Recaptcha;

final class ErrorCodes
{
	const MISSING_INPUT_SECRET   = 'missing-input-secret';
	const INVALID_INPUT_SECRET   = 'invalid-input-secret';
	const MISSING_INPUT_RESPONSE = 'missing-input-response';
	const INVALID_INPUT_RESPONSE = 'invalid-input-response';
	const BAD_REQUEST            = 'bad-request';
	const TIMEOUT_OR_DUPLICATE   = 'timeout-or-duplicate';
	const LOW_SCORE_RATE         = 'low-score-rate';

	/**
	 * Defines error-code is in predefined error codes.
	 *
	 * @param array $errorCodes
	 * @return bool
	 */
	public static function hasError(array $errorCodes): bool
	{
		foreach ($errorCodes as $errorCode) {
			if ($hasError = in_array($errorCode,self::definedErrorCodes(), true)){
				return $hasError;
			}
		}
		return false;
	}

	/**
	 * Predefined error codes
	 * @return array|string[]
	 */
	public static function definedErrorCodes() :array
	{
		$reflection = new \ReflectionClass(__CLASS__);
		return $reflection->getConstants();
	}
}