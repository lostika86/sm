<?php namespace JPackages\SimpleMailer;

require_once JPACKAGE_VENDOR_PATH . '/autoload.php';

use JPackages\SimpleMailer\Cleaning\CleanRequest;
use JPackages\SimpleMailer\Data\RequestData;
use JPackages\SimpleMailer\Mail\Layouts\Base;
use JPackages\SimpleMailer\Mail\Layouts\MailBody;
use JPackages\SimpleMailer\Mail\MailTransport;
use JPackages\SimpleMailer\Response\ResponseContent;
use JPackages\SimpleMailer\Response\SenderResponse;
use JPackages\SimpleMailer\Validator\Validator;

/**
 * Load environment variables from .env
 */
DotEnvBootstrap::make(JPACKAGE_START_PATH);
/**
 * Capture the request.
 */
$requestData = new RequestData();
/**
 * Preparing response.
 */
$senderResponse = new SenderResponse(); // TODO make response json compatible
if (!$requestData->getRequest()->ajax() && $requestData->getRequest()->isMethod('POST')) {
	// only xhr request is allowed
	return $senderResponse->setStatusCode(403)->send();
}

/**
 * Clean up the request, maybe contains some strange
 */
$cleanRequest = new CleanRequest($requestData);
$cleanRequest->cleaning();
// input is cleaned perfectly, use it in below process
/**
 * Validate the request data.
 */
$validator  = new Validator();
$validator->validate($requestData->getInput());

$responseContent 	= new ResponseContent();
// initial status is falsy status
$responseContent->setFailedStatus();

// ok, than check data validity
if ($validator->success()){
	// compose mailbody, and prepare e-mail for sending
	$mailBody = new MailBody($requestData->getInput(),'sk');
	$mailBase = new Base($mailBody);
	// make the SMTP transport layer
	$mailer = new MailTransport();
	$mailer->setBase($mailBase);

	// The number of successful recipients. Can be 0 which indicates failure
	$mailerResult = $mailer->mailIt();
	// push the status into the content too
	$responseContent->setStatus($mailerResult > 0);
}
// additionally push some marketing data, and make the error bag
$responseContent->setErrors($validator->getMessageBag()->toArray())
				->pushToMarketing(['submitted' => true]); // TODO make marketing blocks

$senderResponse->setContent($responseContent);

return $senderResponse->send();


