<?php namespace JPackages\SimpleMailer;

use Illuminate\Support\Collection;

class ConfigurationContainer
{
	private static $instances = [];

	/** @var array */
	private $config = [];

	protected function __construct() { }

	protected function __clone() { }

	public function __wakeup()
	{
		throw new \Exception("Cannot unserialize a config container.");
	}

	public static function getInstance(): self
	{
		$cls = static::class;
		if (!isset(self::$instances[$cls])) {
			self::$instances[$cls] = new static();
		}

		return self::$instances[$cls];
	}

	public static function getConfigs()
	{
		$instance 	= self::getInstance();


		$instance->setConfig(Config::formConfig());

		return $instance;
	}

	/**
	 * @param array $config
	 */
	protected function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * @return array
	 */
	protected function getConfig(): array
	{
		return $this->config;
	}

	public function configuration(): Collection
	{
		return collect($this->getConfig());
	}

	public function getFormFieldsConfig(): Collection
	{
		return collect($this->configuration()->get('formFields'));
	}

	public function getFormHeadersConfig(): Collection
	{
		return collect($this->configuration()->get('formHeader'));
	}

	public function getFormParameters(): Collection
	{
		return collect($this->configuration()->get('formParameters'));
	}
}