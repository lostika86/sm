<?php
namespace JPackages\SimpleMailer\Cleaning;

use Illuminate\Http\Request;
use JPackages\SimpleMailer\Data\CleanedData;
use JPackages\SimpleMailer\Data\RequestData;

class CleanRequest
{

	/** @var  Cleaner */
	protected $cleaner;

	/** @var  CleanedData */
	protected $cleaned;

	/** @var RequestData */
	protected $requestData;

	public function __construct(RequestData $requestData)
	{

		$this->requestData = $requestData;

		$this->setCleaner(new Cleaner());

		$this->setCleaned(new CleanedData());
	}

	public function cleaning() : self
	{
		$input  = $this->requestData->getInput();

		$cleaned = [];

		foreach ($input as $attr => $value){
			$this->cleanInput($value);

			$cleaned[$attr]     = $value;
		}

		$this->cleaned->setInput($cleaned);

		$this->requestData->getRequest()->replace($this->getCleanedInput());

		return $this;
	}

	protected function cleanInput(&$input)
	{
		$input = $this->cleaner->getCleaner()->purify($input);
	}



	/**
	 * @param Cleaner $cleaner
	 */
	public function setCleaner(Cleaner $cleaner)
	{
		$this->cleaner = $cleaner;
	}



	public function getCleanedInput(): array
	{
		return $this->getCleaned()->getInput();
	}
	/**
	 * @return CleanedData
	 */
	public function getCleaned(): CleanedData
	{
		return $this->cleaned;
	}

	/**
	 * @param CleanedData $cleaned
	 */
	public function setCleaned(CleanedData $cleaned)
	{
		$this->cleaned = $cleaned;
	}

	/**
	 * @return RequestData
	 */
	public function getRequestData(): RequestData
	{
		return $this->requestData;
	}

}