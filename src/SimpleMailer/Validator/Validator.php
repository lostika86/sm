<?php

namespace JPackages\SimpleMailer\Validator;

use Illuminate\Support\MessageBag;
use JPackages\SimpleMailer\Config;
use JPackages\SimpleMailer\Recaptcha\CaptchaValidator;
use JPackages\SimpleMailer\Recaptcha\ValidationMessage;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validatable;
use Respect\Validation\Validator as RespectValidator;
use Symfony\Component\HttpFoundation\FileBag;

class Validator
{
	/** @var RespectValidator */
	protected $validator;

	/** @var MessageBag */
	protected $messageBag;

	/** @var array  */
	protected $validation = [];

	/** @var FileBag */
	protected $validFileBag;

	public function __construct()
	{
		$this->validator = new RespectValidator();

		$this->messageBag 	= new MessageBag();

		$this->validFileBag = new FileBag();

	}

	public function validate(array $input = [])
	{

        if (empty($input)) {
			$this->getMessageBag()->merge( ['other' => 'Input data is missing!' ] );
            return false;
        }

        $fields = Config::fields();


		$this->getValidator()::with('JPackages\\SimpleMailer\\Validator\\Rules');

		foreach ($fields as $fieldData) {
			$rules 	= $fieldData['rules'];

			$this->createValidation($name = $fieldData['name'])
				 ->setName($name);


			if ($name === CaptchaValidator::CAPTCHA_RESPONSE_KEY){
				continue;
			}
			$messageTemplate 	= new ErrorMessageTemplate();

			if (!empty($multiFileRules = $this->extractMultiFileRule($rules))) {
                // check against our multiFile rule,
				// if found, check against child rules
				$mfValidator = RespectValidator::create();

				foreach ($multiFileRules as $index => $mfRule) {
					// sometimes our rule can have parameters
					if (!is_array($mfRule)) {
						 $mfValidator->addRule($mfRule);
					}else{
						$mfValidator->addRule($index,$mfRule);
					}
				}

				$this->validation[$name] = $multiFileValidation = RespectValidator::multiFile($mfValidator->getRules());

			}

			// these rule appending is for our simpliest validation rules
			if (!isset($multiFileValidation)) {
		   	$this->getValidation($name)->addRules( $rules)->setTemplate($messageTemplate->getErrorMessage($name));
			}

			// soo lets begin to validate everything
			try {
				// ok, the needles field data name exists on our request input
				if (array_key_exists($name, $input)) {
					// try to validate
					$this->getValidation($name)->assert( $input[$name]);
				} else{
					// input does not contain needed field data
					$this->setMessageBag([$name => $this->translate($name) ]);
				}

				if ($fieldData['type'] === 'file') {
					$this->validFileBag->add($input[$name]);
				}
			} catch(NestedValidationException $exception) {
				// push everything into a bag ...
				$this->pushMessagesIntoBag($name,$exception->getMessages());
			}


		}

		// TODO think again our old captcha
		$recaptchaResult = CaptchaValidator::verify($input[$key = CaptchaValidator::CAPTCHA_RESPONSE_KEY]);

		if (!empty($recaptchaResult)) {
			$captchaErrors = new ValidationMessage();
			$captchaErrors->setErrorCodes($recaptchaResult);
			$this->pushMessagesIntoBag($key,$captchaErrors->errorMessages());
		}

		return true;
	}

	protected function extractMultiFileRule(array $rules)
	{
		if (array_key_exists('multiFile', $rules)) {
			return $rules['multiFile'];
		}

		return [];
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

	protected function getValidation(string $name) : Validatable
	{
		return $this->validation[$name];
	}


	/**
	 * @return RespectValidator
	 */
	public function getValidator(): RespectValidator
	{
		return $this->validator;
	}

	/**
	 * @param RespectValidator $validator
	 */
	public function setValidator(RespectValidator $validator)
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


	/**
	 * @return FileBag
	 */
	public function getValidFileBag(): FileBag
	{
		return $this->validFileBag;
	}

}