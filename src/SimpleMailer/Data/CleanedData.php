<?php

namespace JPackages\SimpleMailer\Data;

class CleanedData
{
	/** @var  array */
	protected $input = [];

	/**
	 * @return array
	 */
	public function getInput(): array
	{
		return $this->input;
	}

	/**
	 * @param array $input
	 */
	public function setInput(array $input)
	{
		$this->input = $input;
	}


}