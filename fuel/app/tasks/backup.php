<?php
namespace Fuel\Tasks;

class Backup
{

    public function run($email = "yachtfractions@gmail.com")
    {
			$date = \Date::forge()->format("%d-%m-%Y %H:%m");

			//1. Create an instance
			$email = \Email::forge();

			//2. Populate email data
			$email->from('yachtfractions@evanrolfe.info', 'Yacht Fractions');
			$email->to(array( $email));
			$email->subject("[yachtfractions] Site Backup File Attached");	
			$email->body("The site backup file is attached.");

			$email->string_attach('asfd', "backup at ".$date.".sql");

			try
			{
				$email->send();
				$return = "Backup successfully sent.";
			}
			catch(\EmailValidationFailedException $e)
			{
				$return = "Email not sent: Invalid email.";
			}
			catch(\EmailSendingFailedException $e)
			{
				$return = "Backup email failed to send.";
			}

			echo $return;
    }
}
