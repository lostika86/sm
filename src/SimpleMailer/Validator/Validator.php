<?php

namespace JPackages\SimpleMailer\Validator;


use Illuminate\Support\MessageBag;
use JPackages\SimpleMailer\Config;
use JPackages\SimpleMailer\Recaptcha\CaptchaValidator;
use JPackages\SimpleMailer\Recaptcha\ValidationMessage;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator as RespectValidator;

class Validator
{
	/** @var \Respect\Validation\Validator */
	protected $validator;

	/** @var MessageBag */
	protected $messageBag;

	/** @var array  */
	protected $validation = [];


	public function __construct()
	{
		$this->validator = new RespectValidator();

		$this->messageBag 	= new MessageBag();

	}

	public function validate(array $input = [])
	{

        if (empty($input)) {
			$this->getMessageBag()->merge( ['other' => 'Input data is missing!' ] );
            return false;
        }

        $fields = Config::fields();

		foreach ($fields as $fieldData) {
			$rules 	= $fieldData['rules'];

			$this->createValidation($name = $fieldData['name'])
				 ->setName($name);
			if ($name === CaptchaValidator::CAPTCHA_RESPONSE_KEY){
  				 	continue;
			}
			$messageTemplate 	= new ErrorMessageTemplate();

		   	$this->getValidation($name)->addRules( $rules)->setTemplate($messageTemplate->getErrorMessage($name));
			try {

				if (array_key_exists($name, $input)) {
					$this->getValidation($name)->assert( $input[$name]);
				} else{
					$this->setMessageBag([$name => $this->translate($name) ]);
				}
			} catch(NestedValidationException $exception) {
				$this->pushMessagesIntoBag($name,$exception->getMessages());
			}
		}

		$recaptchaResult = CaptchaValidator::verify($input[$key = CaptchaValidator::CAPTCHA_RESPONSE_KEY]);

		if (!empty($recaptchaResult)) {
			$captchaErrors = new ValidationMessage();
			$captchaErrors->setErrorCodes($recaptchaResult);
			$this->pushMessagesIntoBag($key,$captchaErrors->errorMessages());
		}

		return true;

	}

	/**
	 * Validation failed and mess
	 * @return bool
	 */
	public function failed()
	{
		return $this->getMessageBag()->isNotEmpty();
	}

	public function success()
	{
		return ! $this->failed();
	}

	protected function createValidation(string $name) : RespectValidator
	{
		return $this->validation[$name] = $this->validator->create();
	}

	protected function getValidation(string $name)
	{
		return $this->validation[$name];
	}


	/**
	 * @return \Respect\Validation\Validator
	 */
	public function getValidator(): \Respect\Validation\Validator
	{
		return $this->validator;
	}

	/**
	 * @param \Respect\Validation\Validator $validator
	 */
	public function setValidator(\Respect\Validation\Validator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * @return MessageBag
	 */
	public function getMessageBag(): MessageBag
	{
		return $this->messageBag;
	}

	/**
	 * @param array $messageBag
	 */
	public function setMessageBag(array $messageBag)
	{
		$this->messageBag->merge($messageBag);
	}

	/**
	 * Adds massively messages to bag.
	 *
	 * @param string $key
	 * @param array $messages
	 */
	public function pushMessagesIntoBag(string $key, array $messages)
	{
		foreach ($messages as $message) {
			$this->getMessageBag()->add($key, $message);
		}
	}
	public function translate(string $name)
	{
		return $name;
	}


}