<?php

namespace  JPackages\SimpleMailer\Mail\Layouts;

use Illuminate\Support\Arr;
use JPackages\SimpleMailer\Config;
use JPackages\SimpleMailer\Mail\Header;
use JPackages\SimpleMailer\Mail\MailTransport;

class Base
{
	/** @var  string */
	private $from;

	/** @var  array */
	private $to;

	/** @var  string */
	private $subject = 'Správa z webovej stránky';

	/** @var  MailBody */
	private $mailBody;

	/** @var  \Swift_Message */
	private $message;

	public function __construct(MailBody $mailBody, array $to = [], \Swift_Message $message = null)
	{
		$this->setFrom(MailTransport::getFromEmail());


		$this->setTo(Header::to($mailBody->getData()));

		if (!empty($to)){
 			$this->setTo($to);
		}

		if (!empty($subject  = $mailBody->getSubject())) {
			$this->setSubject($subject);
		}

		$this->setMailBody($mailBody);
		$this->setMessage($message === null ? new \Swift_Message() : $message);

		$this->boot();
	}


	private function boot()
	{

		$this->message
			->setFrom($this->getFrom())
			->setTo($this->getTo())
//			->setSubject($this->getMailBody()->getTranslationFor('mail_subject'))
			->setSubject($this->getSubject())
			->setReplyTo(MailTransport::getReplyTo())
			->setBody($this->getMailBody()->getBody(), 'text/html')
		;

	}

	/**
	 * @return string
	 */
	public function getFrom(): string
	{
		return $this->from;
	}

	/**
	 * @param string $from
	 */
	public function setFrom(string $from)
	{
		$this->from = $from;
	}

	/**
	 * @return array
	 */
	public function getTo(): array
	{
		return $this->to;
	}

	/**
	 * @param array $to
	 */
	public function setTo(array $to)
	{
		$this->to = $to;
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

	/**
	 * @return MailBody
	 */
	public function getMailBody(): MailBody
	{
		return $this->mailBody;
	}

	/**
	 * @param MailBody $mailBody
	 */
	public function setMailBody(MailBody $mailBody)
	{
		$this->mailBody = $mailBody;
	}



	/**
	 * @return \Swift_Message
	 */
	public function getMessage(): \Swift_Message
	{
		return $this->message;
	}

	/**
	 * @param \Swift_Message $message
	 */
	public function setMessage(\Swift_Message $message)
	{

		$this->message = $message;
	}


}