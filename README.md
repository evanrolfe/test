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

7.  


*Trouble Shooting:*
================================
*  Session errors occuring in offline mode: change line num 33 in /fuel/app/config/session.php from ```'driver'			=> 'db',``` to ```'driver'			=> 'cookie',```

*  Uploads not working due to PHP missing fileinfo extensions: add the following line to php.ini ```extension=fileinfo.so```
