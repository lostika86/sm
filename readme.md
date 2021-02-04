### Installation

Add this lines to composer.json or update current by adding with these lines.

```
{
   "require": {
     "lostika86/sm" : "1.2.1"
   },
   "repositories":[
     {
       "type": "vcs",
       "url": "git@github.com:lostika86/sm.git"
     }
   ],
   "minimum-stability": "stable"
 }
```

### Setup

 **1. Copy email file:** (note: command is for WIN OS)

`copy .\vendor\lostika86\sm\example\email.php` 

**2. Copy config file**

`copy .\vendor\lostika86\sm\example\mailer_config.php`

**3. Update .env file with these lines**
```
MAIL_DRIVER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=username_code
MAIL_PASSWORD=password_comes_here
MAIL_FROM_ADDRESS=myfromaddress@example.com
MAIL_FROM_NAME="Example Name"
MAIL_REPLY_TO="replyto@example.com"
SITE_HOSTNAME="localhost"
RECAPTCHA_SECRET_KEY="xyt_mysecret_code_comes_here"
```

**4. Change `mailer_config.php` as you want**

Note: For another rules check validation package `https://github.com/Respect/Validation` repository, and read documentation.

**Mailer Config basics**
```
	[
		'type' 	=> 'text',
		'name' => 'company_name',
		'rules' =>  ['notEmpty', 'stringType'],
		'trans' => [
			'sk' 	=> 'Názov firmy',
			'en'	=> 'Company name'
		],
		'actions' => ['key_mail_subject'] // defines that this input will be an mail subject 
	],
```
Other actions:
**key_from_name** - defines email _From Name_ , 
**key_from_email** - defines email _From Address_
