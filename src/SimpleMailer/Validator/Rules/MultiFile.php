<?php
namespace JPackages\SimpleMailer\Validator\Rules;

use Illuminate\Http\UploadedFile;
use JPackages\SimpleMailer\Validator\Exceptions\MultiFileException;
use Respect\Validation\Exceptions\ValidationException;
use Respect\Validation\Rules\AbstractComposite;

final class MultiFile extends AbstractComposite {

	public function __construct()
	{
		$this->addRules(func_get_args());
	}

	public function assert($input)
	{
		$exceptions = [];

		// filenames - we will replace them
		$extraParameters = ['fileNames' => []];

		foreach ($input as $key => $item) {
			/** @var UploadedFile $item */
			$extraParameters['fileNames'][$key] = $item->getClientOriginalName();
			// take every rule under multifile
			foreach ($this->getRules() as $rule) {
				try {
					$rule->assert($item);
				} catch (ValidationException $exception) {
					// set filename, which are invalid
					$exceptions[] = $exception->setName($extraParameters['fileNames'][$key]);
				}
			}
		}

		// so we have some exceptions
		if (!empty($exceptions)) {
			// report them
			throw $this->reportError($input, $extraParameters)->setRelated($exceptions);
		}

		return true;
	}



	public function reportError($input, array $extraParams = [])
	{
		// specify our exception
		$exception = new MultiFileException();

		$name = $this->name ?: ValidationException::stringify($input);
		$params = array_merge(
			get_class_vars(__CLASS__),
			get_object_vars($this),
			$extraParams,
			compact('input')
		);

		// begin the configuration
		$exception->configure($name, $params);

		// set custom template
		$this->template = $exception::$defaultTemplates[$exception::MODE_DEFAULT][$exception::STANDARD];

		if (!is_null($this->template)) {
			$exception->setTemplate($this->template);
		}

		return $exception;
	}


	public function validate($input){}
}