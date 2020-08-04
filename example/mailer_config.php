<?php
return [
	[
		'type' 	=> 'text',
		'name' => 'contact_name',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => 'Kontaktná osoba',
	],
	[
		'type' 	=> 'text',
		'name' => 'email',
		'rules' =>  ['notEmpty', 'email'],
		'trans' => 'E-mail',

	],
	[
		'type' 	=> 'textarea',
		'name' => 'message',
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