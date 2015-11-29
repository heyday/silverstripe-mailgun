silverstripe-mailgun
====================

Silverstripe plugin for Mailgun

*** Custom Headers example.

	$mailer = new \Mrk\Mailer();
    $mailer->addCustomHeader('h:Reply-To', 'email@example.com');
    
*** You need the following Yaml config file setup:

    ###################
    ###MAILGUN SETUP###
    ###################
    
    MailGun:
      key: key-YourKey
      domain: yourdomain.com
      from: info@yourdomain.com


