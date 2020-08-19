<?php
return [
	[
		'type' 	=> 'text',
		'name' => 'contact_name',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'Kontaktná osoba',
		'actions' => ['key_from_name']
	],
	[
		'type' 	=> 'text',
		'name' => 'contact_subject',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'Predmet správy',
		'actions' => ['key_mail_subject']
	],
	[
		'type' 	=> 'text',
		'name' => 'contact_phone',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'Tel.číslo',
	],
	[
		'type' 	=> 'text',
		'name' => 'contact_email',
		'rules' =>  ['notEmpty', 'email'],
		'trans' => 'E-mail',
		'actions' => ['key_from_email']
	],
	[
		'type' 	=> 'textarea',
		'name' => 'contact_message',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'Správa',

	],
	[
		'type' 	=> 'input',
		'name' => 'g-recaptcha-response',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'g-recaptcha-response error',

	],
];