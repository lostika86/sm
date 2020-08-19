<?php

namespace JPackages\SimpleMailer\Cleaning;

require_once JPACKAGE_VENDOR_PATH . '/ezyang/htmlpurifier/library/HTMLPurifier.auto.php';

use HTMLPurifier_Config as Cleaner_Config;
use HTMLPurifier as Clean;

/**
 * Class Cleaner
 * @package SimpleMailer\Cleaner
 */
class Cleaner
{
	/**
	 * @var null
	 */
	protected $cleaner = null;
	/**
	 * @var null
	 */
	protected $config = null;

	/**
	 * Cleaner constructor.
	 */
	public function __construct()
	{
		$this->setConfig(Cleaner_Config::createDefault());

		$this->setCleaner();
	}

	/**
	 * @return mixed
	 */
	public function getCleaner()
	{
		return $this->cleaner;
	}


	/**
	 * @param null $cleaner
	 *
	 * @throws \Exception
	 */
	public function setCleaner($cleaner = null)
	{
		if(is_null($cleaner)){
			$config = $this->getConfig();

			if (!$config){
				throw new \Exception('No configuration is defined.');
			}

			$cleaner = new Clean($config);

		}

		$this->cleaner = $cleaner;
	}

	/**
	 * @return mixed
	 */
	public function getConfig()
	{
		return $this->config;
	}

	/**
	 * @param mixed $config
	 */
	public function setConfig($config)
	{
		$this->config = $config;
	}


}