<?php

namespace JPackages\SimpleMailer\Mail;

use JPackages\SimpleMailer\Mail\Layouts\Base;

/**
 * Class Mailing
 * @package SimpleMailer\Mail
 */
class MailTransport
{

    protected $fromEmail = '';
	protected $fromName = '';



	/** @var  \Swift_SmtpTransport */
	private $transport;

	/** @var  \Swift_Mailer */
	private $mailer;

	/** @var  \Swift_Message */
	private $message;

	/**
	 * @var Base
	 */
	private $base;

	/**
	 * Mailing constructor.
	 */
	public function __construct()
	{
		$transport = $this->makeTransport();

		$this->setTransport($transport);
		$this->setMailer(new \Swift_Mailer($transport));

		$this->fromName  = $this->getConfig('fromName');
		$this->fromEmail = $this->getConfig('fromEmail');

	}

	public function getConfig(string $key = '')
	{
		$config 	= [
			'host'       => getenv('MAIL_HOST'),
			'port'       => getenv('MAIL_PORT'),
			'username'   => getenv('MAIL_USERNAME'),
			'password'   => getenv('MAIL_PASSWORD'),
			'fromEmail'  => getenv('MAIL_FROM_ADDRESS'),
			'fromName'   => getenv('MAIL_FROM_NAME'),
			'replyTo'    => getenv('MAIL_REPLY_TO'),
		];

		$encryption = getenv('MAIL_ENCRYPTION');

		if ($encryption === 'ssl' || $encryption === 'tls') {
			$config['encryption'] 	= $encryption;
		}
		if (empty($key)) {
			return $config;
		}

		return array_key_exists($key,$config) ? $config[$key] : null;
	}

	public static function getFromName()
	{
		return (new static())->fromName;
	}

	public static function getFromEmail()
	{
		return (new static())->fromEmail;
	}

	public static function getReplyTo()
	{
		return [(new static())->getConfig('replyTo') => MailTransport::getFromName()];
	}

	public function mailIt() : int
	{

		return $this->mailer->send($this->getMessage());
	}

	/**
	 * @return \Swift_SmtpTransport
	 */
	private function makeTransport()
	{
		$transport = (new \Swift_SmtpTransport($this->getConfig('host'), $this->getConfig('port')))
			->setUsername($this->getConfig('username'))
			->setPassword($this->getConfig('password'));
		if (array_key_exists('encryption',$this->getConfig())){
		    $transport->setEncryption($this->getConfig('encryption'));
        }

		return $transport;
	}

	/**
	 * @return \Swift_SmtpTransport
	 */
	public function getTransport(): \Swift_SmtpTransport
	{
		return $this->transport;
	}

	/**
	 * @param \Swift_SmtpTransport $transport
	 */
	public function setTransport(\Swift_SmtpTransport $transport)
	{
		$this->transport = $transport;
	}

	/**
	 * @return \Swift_Mailer
	 */
	public function getMailer(): \Swift_Mailer
	{
		return $this->mailer;
	}

	/**
	 * @param \Swift_Mailer $mailer
	 */
	public function setMailer(\Swift_Mailer $mailer)
	{
		$this->mailer = $mailer;
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

	/**
	 * @param Base $base
	 * @return MailTransport
	 */
	public function setBase(Base $base): MailTransport
	{
		$this->base = $base;

		// set message into transport
		$this->setMessage($base->getMessage());

		return $this;
	}


}