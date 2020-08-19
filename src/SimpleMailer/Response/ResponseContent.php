<?php namespace JPackages\SimpleMailer\Response;

use Illuminate\Contracts\Support\Arrayable;

class ResponseContent implements Arrayable
{
	/**
	 * Action status in content.
	 * @var bool
	 */
	protected $status = false;

	/**
	 * Data for marketing purposes.
	 * @var array
	 */
	protected $marketing = [];

	/**
	 * Errors in content.
	 * @var array
	 */
	protected $errors = [];

	public function toArray() : array
	{
		return [
			'status'	=> $this->status,
			'marketing'	=> $this->marketing,
			'errors'	=> $this->errors,
		];
	}

	/**
	 * Set status to success.
	 * @return $this
	 */
	public function setSuccessStatus(): self
	{
		$this->setStatus(true);
		return $this;
	}

	/**
	 * Set status to failed.
	 * @return $this
	 */
	public function setFailedStatus(): self
	{
		$this->setStatus(false);
		return $this;
	}

	/**
	 * Merges some marketing data into marketing container.
	 *
	 * @param array $marketingData
	 * @return $this
	 */
	public function pushToMarketing(array $marketingData): self
	{
		$this->marketing = array_merge($this->marketing, $marketingData);
		return $this;
	}

	/**
	 * @param bool $status
	 * @return ResponseContent
	 */
	public function setStatus(bool $status): ResponseContent
	{
		$this->status = $status;
		return $this;
	}

	/**
	 * @param array $marketing
	 * @return ResponseContent
	 */
	public function setMarketing(array $marketing): ResponseContent
	{
		$this->marketing = $marketing;
		return $this;
	}

	/**
	 * @param array $errors
	 * @return ResponseContent
	 */
	public function setErrors(array $errors): ResponseContent
	{
		$this->errors = $errors;
		return $this;
	}


}