<?php namespace JPackages\SimpleMailer\Validator\Exceptions;

use Respect\Validation\Exceptions\ValidationException;

final class MultiFileException extends ValidationException
{
	public function setRelated(array $exceptions = [])
	{
		// we have child rules, so every rule can have owne exception
		// grab the messages for response
		$messages = [];
		foreach ($exceptions as $exception) {
			$messages[] = $exception->getMainMessage();
		}
		// we have simply exception, so define the message
		$this->message = implode('|', $messages);

		return $this;
	}
}