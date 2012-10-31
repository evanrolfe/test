*Installation (by Evan)*
================================

1.  Download the zip from https://github.com/evanrolfe/test

2.  Extract to the web root directory

3.  Open /.htaccess (in the application root) and change line num 4 from:

    ```RewriteBase /yacht/public```

	 replace /yacht/ with the name of the directory containing the app. i.e. if the app is located in /home/evan/www/yacht_fractions then .htaccess should contain:

	```RewriteBase /yacht_fractions/public```

4.  Open /fuel/app/config/config.php update line 26, do not forget the trailing slash!!!

    ```'base_url'  => 'http://localhost/yacht/',```

5.  Open /fuel/app/config/production/db.php according to the DB (straightforward).

    NOTE: the site is in production mode by default, should you switch to development mode then you will need to update /fuel/app/config/development/db.php as well.

6.  Optional: to set to offline mode, update /fuel/app/config/offline.php

7.  Now enter phpmyadmin, click on the corresponding database in the sidepanel, click on the "Import" tab, then import the SQL file located at /database_install.sql (in root dir)

8.  Go to http://yourdomain.com/your_yacht_folder/install/admin to create an admin user

9.  IMPORTANT: delete the file located at: /fuel/app/classes/controller/install.phpmyadmin

FINISHED!

*Trouble Shooting:*
================================
*  Session errors occuring in offline mode: change line num 33 in /fuel/app/config/session.php from ```'driver'			=> 'db',``` to ```'driver'			=> 'cookie',```

*  Uploads not working due to PHP missing fileinfo extensions: add the following line to php.ini ```extension=fileinfo.so```

*  If you get a permission denied error pertaining to the logs then a probable solution will be to set the permissions of /fuel/app/logs directory to writable by the web server's user account. i.e. in linux run command: ```chmod -R 777 fuel/app/logs/*```

*Todo (from Skype convo on 29/10/2012):*
================================
Tasks from convo:
* ~~yachtshare/create: validate share size screws up that formrow~~ (Completed 31/10/12 - 10:15)
* ~~file/yachtshare/X: set dropdown to "Any" by default then validate something is selected~~ (Completed 31/10/12 - 12:45)
* append file type (i.e. "_public_header") to file name
* make "Logout" link on public pages more prominent
* Selected boats row should not appear?
* buyer/create: selected boats should give name and not just ID's
* actionstep/create: should have buttons "Introduce" and "Introduce with email"
* yachtshare/edit: show html descriptions
* mobile export: does not link telephone numbers
* image upload: php memory_limit???
* have config file for email address in emailnew controller
* Errors in production mode send email?


Older tasks:
* HTML scrape inactive boats from http://www.yachtfractions.co.uk/fracadmin.asp
* "Save for later" saves on logout
* Jquery interface for change order of formfields
* ~~Fix dropdowns going off screen problem~~ (Completed 31/10/12 - 12:45)
* Validate dropdowns in buyer/create, yachtshare/create,actionstep/create
