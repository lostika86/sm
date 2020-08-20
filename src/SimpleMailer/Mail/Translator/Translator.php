<?php namespace JPackages\SimpleMailer\Mail\Translator;

use Illuminate\Support\Collection;
use JPackages\SimpleMailer\ConfigurationContainer;

class Translator
{
	/**
	 * Array key name for translations, defined in form_config file.
	 * @var string
	 */
	const KEY_TRANSLATIONS = 'trans';

	/**
	 * Input name in request, which defines form locale.
	 * @var string
	 */
	const KEY_LOCALE_INPUT = '_locale';

	/**
	 * Current locale
	 * @var string
	 */
	public $locale;

	/**
	 * Translations as result in current locale
	 * @var Collection
	 */
	protected $translations;

	public function __construct(string $locale = 'sk')
	{
		// defined locale, current locale defines translation
		$this->locale = $locale;
		// collect translations from config file

		$formFields = ConfigurationContainer::getConfigs()->getFormFieldsConfig();

		// populate translations with translations,
		// key - field name, value - translation in locale
		$this->translations = $formFields->mapWithKeys(function ($field) {
			// get field translation
			$fieldTranslations = $this->getFieldTranslations($field);

			return [$field['name'] => $fieldTranslations];
		});

	}

	/**
	 * Check translation on current field. If translation does not exist, create one from field name.
	 * @param array $field
	 * @return string
	 */
	protected function getFieldTranslations(array $field): string
	{
		// make default translation only from field name,
		// if locale translation exists, it will be rewritten
		$translation = $field['name'];

		// check if translation is defined on the field,
		// format; ['trans' => ['sk' =>'field name translation', ...]
		if (array_key_exists(self::KEY_TRANSLATIONS, $field)
			&& is_array($fieldTrans = $field[ self::KEY_TRANSLATIONS ])) {
			// does field has translation in current locale
			if (array_key_exists($this->locale, $fieldTrans)) {
				return $fieldTrans[ $this->locale ];
			}
		}

		return $translation;
	}

	/**
	 * @return Collection
	 */
	public function getTranslations(): Collection
	{
		return $this->translations;
	}
}