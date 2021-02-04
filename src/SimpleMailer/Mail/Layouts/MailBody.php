<?php

namespace JPackages\SimpleMailer\Mail\Layouts;

use Illuminate\Support\Collection;
use JPackages\SimpleMailer\Config;
use JPackages\SimpleMailer\ConfigurationContainer;
use JPackages\SimpleMailer\Mail\Translator\Translator;
use JPackages\SimpleMailer\Recaptcha\CaptchaValidator;

class MailBody
{
	/** @var  array */
	protected $data;

	/** @var  string */
	private $body = '';

	/** @var string */
	private $subject = '';

	public $locale = 'sk';

	/** @var Collection */
	protected $translations;

	/** @var array */
	private $hidden = [CaptchaValidator::CAPTCHA_RESPONSE_KEY,Translator::KEY_LOCALE_INPUT];

	public function __construct(array $data, string $locale = 'sk')
	{
		$this->setData($data);

		if (!empty($blockName = Config::getClientEmailSubjectBlock())) {
			$this->setSubject($data[$blockName]);
		}

		$this->setLocale($locale);

		$this->buildMailBody();
	}



	protected function buildMailBody()
	{
		$data = $this->getData();

		$fields 	= collect(ConfigurationContainer::getConfigs()->getFormFieldsConfig())->keyBy('name');

		$parameters = collect(ConfigurationContainer::getConfigs()->getFormParameters());


		foreach ($data as $block => $value)
		{
			if (in_array($block, $this->hidden, true)) {
				continue;
			}
			if (in_array($block, $parameters->get('hiddenFields'), true))
				continue;

			$blockName  = $fields->get($block)["name"];
			$block = '<p>' . $this->getTranslationFor($blockName) . ': ' . $value . '</p>';
			$this->setBody($block);
		}
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


	public function getTranslationFor(string $key = '')
	{
		return $this->translations->get($key, '');
	}

	/**
	 * Sets default locale from request, or as a variable.
	 * @param string $locale
	 */
	protected function setLocale(string $locale = 'sk')
	{
		$this->locale = $locale;

		if (array_key_exists(Translator::KEY_LOCALE_INPUT, $this->getData())
			&& is_string($localeInput = $this->getData()[ Translator::KEY_LOCALE_INPUT ])
			&& !empty($localeInput)) {
			$this->locale = $localeInput;
		}

		// get translations from config too
		$translator = new Translator($this->locale);
		$this->translations 	= $translator->getTranslations();

	}

	/**
	 * @return string
	 */
	public function getSubject(): string
	{
		return $this->subject;
	}

	/**
	 * @param string $subject
	 */
	public function setSubject(string $subject)
	{
		$this->subject = $subject;
	}
}