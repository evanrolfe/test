<?php
/*
* Set this to true if the application is to be run in offline mode which does nothing more than display a big warning banner at the top of each page
*
* In order to make database read-only:
*
*	In phpmyadmin:
*	1. Click on "Privileges" in top horizontal nav bar
*	2. Click "Add a new user"
*	3. Use details:
		Login information:

			User name: whatever you want (say 'offline_user')
			Host: localhost
			Password: whatever you want

		Database for user:

			Select: None

		Global Privileges:
			CHECK: Select
	4. 
*/

return array(
	'offline_on?' => false,

	//Set the percentage of the width of the content box on public pages
	'content_width' => 50,
);
