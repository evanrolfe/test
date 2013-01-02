<?php
namespace Fuel\Tasks;

class Backup
{

    public function run($to_email = "evanrolfe@gmail.com")
    {
			$date = \Date::forge()->format("%d-%m-%Y %H:%m");

			//1. Create an instance
			$email = \Email::forge();

			//2. Populate email data
			$email->from('yachtfractions@evanrolfe.info', 'Yacht Fractions');
			$email->to($to_email);
			$email->subject("[yachtfractions] Site Backup File Attached");	
			$email->body("The site backup file is attached.");

			$backup = $this->get_sql_string();

			$email->string_attach($backup, "backup at ".$date.".sql");

			try
			{
				$email->send();
				$return = "Backup successfully sent to: ".$to_email;
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

	public function get_sql_string()
	{
		//1. Get the table names
		$tables = array('actionsteps','asnames','buyers','emailtemplates','formfields_buyer','images','yachtshares');

		$out = "";
		foreach($tables as $table)
		{
			if(in_array($table, array('shares','sessions', 'migration','backups','users'))) //'yachtshares','buyers','formfields_buyer','emailtemplates',
				continue;

			$out .= "TRUNCATE `".$table."`;";

			$out .= "INSERT INTO `".$table."` (";
			$columns = \DB::list_columns($table);

			$i=1;
			foreach($columns as $key => $col)
			{
				$out .= "`".$key."`";
				if($i < count($columns))
					$out .= ", ";
				$i++;
			}
			
			$out .= ") VALUES ";
	
			$rows = \DB::query('SELECT * FROM `'.$table.'`',\DB::SELECT)->execute();

			$j=1;
			foreach($rows as $row)
			{
				$out .= "(";
				$i=1;
				foreach($columns as $key => $col)
				{
					$val = (is_null($row[$key])) ? "NULL" : $row[$key];


					if($col['type'] == 'string')
					{
						//$val = Security::clean($val, array('strip_tags', 'htmlentities'));
						$val = addslashes($val);
						$out .= "'".$val."'";
					}else{
						$out .= $val;
					}

					if($i < count($columns))
						$out .= ", ";
					$i++;
				}

				$out .= ")";

				if($j < count($rows))
				{
					$out .= ",";
				}else{
					$out .= ";";
				}
				$j++;
			}
		}

		return $out;		
	}    
}
