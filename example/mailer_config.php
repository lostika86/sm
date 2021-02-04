<?php
return [
	'fields' => [
		[
			'type' 	=> 'text',
			'name' => 'contact_name',
			'rules' =>  ['notEmpty', 'stringType'],
			'trans' => [
				'sk' => 'Kontaktná osoba',
				'hu'	=> 'Kapcsolattartó'
			],
			'actions' => ['key_from_name']
		],
		[
			'type' 	=> 'text',
			'name' => 'contact_subject',
			'rules' =>  ['notEmpty', 'stringType'],
			'trans' => [
				'sk' => 'Predmet správy'
			],
			'actions' => ['key_mail_subject']
		],
		[
			'type' 	=> 'text',
			'name' => 'contact_phone',
			'rules' =>  ['notEmpty', 'stringType'],
			'trans' => [
				'sk' => 'Tel.číslo'
			],
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
			'trans' => [
				'sk' => 'Správa'
			],

		],
		[
			'type' 	=> 'input',
			'name' => 'g-recaptcha-response',
			'rules' =>  ['notEmpty', 'stringType'],
			'trans' => 'g-recaptcha-response error',
		],
		[
			'type' 	=> 'file',
			'name' => 'uploaded_file',
			'rules' =>  ['arrayType','multiFile' => ['file','image','size' => [null,'10B'],'mimetype' => ['image/jpeg']]],
			'trans' => [
				'sk' => 'file'
			],
		],
	],
	'parameters' => [
		'hiddenFields' => ['uploaded_file']
	]
];