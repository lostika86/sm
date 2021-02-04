<?php

namespace JPackages\SimpleMailer\Data;

use Illuminate\Http\Request;

class RequestData
{
	/** @var Request */
	private $request;

	/** @var  array */
	protected $input = [];

	public function __construct()
	{
		$this->setRequest(Request::capture());

		$this->setInput(
			$this->getRequest()->all()
		);

	}

	/**
	 * @return array
	 */
	public function getInput(): array
	{
		return $this->getRequest()->all();
	}

	/**
	 * @param array $input
	 */
	public function setInput(array $input)
	{
		$this->input = $input;
	}

	/**
	 * @return Request
	 */
	public function getRequest()
	{
		return $this->request;
	}

	/**
	 * @param Request $request
	 */
	public function setRequest($request)
	{
		$this->request = $request;
	}

	/**
	 * Request is a POST method.
	 * @return bool
	 */
	public function isPost(): bool
	{
		return $this->getRequest()->getMethod() === 'POST';
	}

	/**
	 * Does the request contains files
	 * @return bool
	 */
	public function containsFiles(): bool
	{
		return $this->getRequest()->files->count() > 0;
	}
}