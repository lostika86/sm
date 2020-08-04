<?php

namespace JPackages\SimpleMailer\Mail\Layouts;

use JPackages\SimpleMailer\Config;
use JPackages\SimpleMailer\Recaptcha\CaptchaValidator;

class MailBody
{
	/** @var  array */
	protected $data;

	/** @var  string */
	private $body = '';

	/** @var array */
	protected $translation;

	/** @var array */
	private $hidden = [CaptchaValidator::CAPTCHA_RESPONSE_KEY];

	public function __construct(array $data)
	{
		$this->setData($data);

		$this->buildMailBody();
	}

	protected function buildMailBody()
	{
		$data = $this->getData();

		$fields 	= collect(Config::fields())->keyBy('name');
		foreach ($data as $block => $value)
		{
			if (in_array($block, $this->hidden, true)) {
				continue;
			}
			$methodName =  'block' . ucfirst(ucwords($block));

			if (method_exists($this,$methodName))
			{
				$block = $this->$methodName($value);


			} else{
				$block = '<p>'.$fields->get($block)["trans"].':'. $value.'</p>';
			}
			$this->setBody($block);
		}
	}



	private function blockContactMessage(string $value)
	{
		return '<p>'.$this->getTranslationFor('message').':'. $value.'</p>';
	}

	/**
	 * @return array
	 */
	public function getData(): array
	{
		return $this->data;
	}

	/**
	 * @param array $data
	 */
	public function setData(array $data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 */
	public function setBody(string $body)
	{
		$this->body .= $body;
	}

	protected function getTranslationFile()
	{

		if (!isset($this->translation)) {
			$this->translation = (array) include __DIR__.'/../translation.php';
		}
		return $this->translation;

	}

	public function getTranslationFor(string $key = '')
	{
		if (empty($key)) {
			return '';
		}
		$translations = $this->getTranslationFile();

		if (array_key_exists($key, $translations)) {
			return $translations[ $key ];
		}
	}

}