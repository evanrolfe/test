# Important Notes
* Check that the formfields have the right public/private settings (for copying private data in yachtshare/create)
* Check the values of columns: active,temp in table: yachtshares

#Testing

## Buyer

### Buyer Enquiry: http://yacht-fractions.co.uk/buyer/create
* 1. *(PASS) (Completed 12/11/12 - 20:45) Validates: valid email address, all required fields, terms and conditions checked*
* 2. *(PASS) (Completed 12/11/12 - 20:55) Error message displays twice on share sizes. Validates: only numbers can be entered for: share size min/max, budget min/max, length min/max*
* 3. *(PASS) (Completed 12/11/12 - 21:00) Validates: email is not already used*
* 4. *(PASS) (Completed 12/11/12 - 21:45) Does NOT prompt "Are you sure..." the user on submit*
* (PASS) Budget Min/Max Field: the following input should be accepted: "10000.00", "10 000", "10,000"
* (PASS) Select three yachts which interest you" should be highlighted in Admin->Buyer->Find Yachtshares
* (PASS) Email sent to buyer and admin containing correct information
* (PASS) Email displays fractions instead of decimals for share sizes
* (PASS) Terms and conditions appears at end of form
* (PASS) Conversion of feet to meters (if feet selected)
* (PASS) "Save for later" - Does not save the terms and conditions check box
* (PASS) After submitting display thank you page with link back to yachtfractions home page
* (PASS) Closing the browser prompts the user "Are you sure..."

## Seller

### Seller: Registration: http://yacht-fractions.co.uk/seller/create
* (PASS) Validates: valid email, matching passwords, all fields required
* (PASS) Validates: email is not already used

- NOTE: Should this send some kind of confirmation email to the seller?

- NOTE: If no yachtshare with similar name is found then it goes straight to yachtshare/create form.

### Seller: Creating a Yachtshare

* 1. *(PASS) (Completed 12/11/12 - 22:00) Back button does not work at http://yacht-fractions.co.uk/seller/search*
* 2. *(PASS) (Completed 12/11/12) "Save for later" - saved form data should be cleared once the yachtshare has been created.*
* 3. *(PASS) (Completed 12/11/12 - 22:05) "This is my boat copy the details" => Private fields are NOT copied. (Example: login as seller and go to http://yacht-fractions.co.uk/yachtshare/create/114)*
* 4. *(PASS) (Completed 12/11/12 - 22:05) Does NOT prompt "Are you sure..." the user on submit*
* (PASS) "Save for later" - check it saves on window close
* (PASS) There is some kind of line being shown below the box at http://yacht-fractions.co.uk/seller/search, remove it.
* (PASS) Able to search for boats by name
* (PASS) Select multiple shares creates multiple yachtshares with corresponding share sizes
* (PASS) Closing the browser prompts the user "Are you sure..."
* (PASS) Validates: all required fields, valid email address, terms and conditions must be checked
* (PASS) Validates: a number is entered in share size, budget, length
* (PASS) Price field: the following input should be accepted: "10000.00", "10 000" - will force validation, "10,000"
* (PASS) Convert feet to meters if feet selected

### Seller: Viewing their own yachtshare: http://yacht-fractions.co.uk/yachtshare/view/116
* 1. *(PASS) (Completed 12/11/12 - 22:10) Display share size as fraction*
* 2. *(PASS) (Completed 12/11/12 - 22:10) Do NOT show terms and conditions field*

- NOTE: Do we want the seller to be able to delete their own yachtshare?

### Seller: Editing their own yachtshare: http://yacht-fractions.co.uk/yachtshare/edit/116
* (FAIL) Validates: all required fields, valid email address, terms and conditions must be checked
* (FAIL) Validates: a number is entered in share size, budget, length
* (PASS) Price field: the following input should be accepted: "10000.00", "10 000" - will force validation, "10,000"
* (PASS) Convert feet to meters if feet selected

- NOTE: Do we want the seller to be able to edit their own yachtshare? I think not, if they need to correct details they should email chris hawes because otherwise he will not necessarily know about changes to the yachts being sold.

### Seller: Uploading files for a yachtshare
* (PASS) able to upload
* Displays (formatted) error message to user if file is too big
* (PASS) user able to select from file types "Private doc/photo", "Public header photo", "Public gallery photo"
* (PASS) Seller able to delete their own photos
* (PASS) Resize images with width > 800px

- NOTE: include explanation of different file types for user?

## Admin

### Yachtshare List: http://yacht-fractions.co.uk/yachtshare
* Able to filter according to:
* (PASS) Type
* (PASS) Location General
* (PASS) Location Specific
* (PASS) Price
* (PASS) Length
* (PASS) Share size
* (PASS) Yachtshare status

* (PASS) Search box performs live search on already existing table of yachtshares below
* (PASS) Able to select columns, each column displays correct information in table
* (PASS) "Sale Progress" column shows progress bar with tooltip information (when cursor is moved over a portion of the progress bar)

### Yachtshare -> View (Detail Page): http://yacht-fractions.co.uk/yachtshare/view/1
Reminder:
If no reminder set:
* (PASS) Display "Set Reminder?" checkbox which, when checked, shows the rest of the form
* (PASS) Able to create reminder
* (PASS) Validates a reminder messange has been entered

If reminder set but not yet active:
* (PASS) Show form at bottom of page
* (PASS) Able to update reminder
* (PASS) Able to delete reminder

If reminder is active:
* (PASS) Display at top of page
* (PASS) Display link to yachtshare in sidebar

Active Sales: Example - http://yacht-fractions.co.uk/yachtshare/view/57
If there is an ongoing sale:
* (PASS) Link to buyer associated with the active sale
* (PASS) Link to delete actionstep
* (PASS) Delete actionstep displays "Are you sure?" prompt
* (PASS) List actionsteps with this sale
* (PASS) Link to add a new actionstep to sale
If not:
* (PASS) Display "This yacht share has not been introduced to any buyers yet. "

Click on "Add Actionstep": http://yacht-fractions.co.uk/yachtshare/view/57
* 1. (PASS) (Completed 12/11/12 - 22:20) Validate: actionstep has been selected
* (PASS) "Select Actionstep" dropdown should list only those actionsteps which have not already been added to the sale
* (PASS) Should redirect back to yachtshare/view page

"This yachtshare has been sold!": Example - http://yacht-fractions.co.uk/yachtshare/view/108
* Show invoice link: http://yacht-fractions.co.uk/data/print/invoice/108
* Show buyer letter link: http://yacht-fractions.co.uk/data/print/letter_buyer/108
* Show seller letter link: http://yacht-fractions.co.uk/data/print/letter_seller/108

Details:
* (PASS) List yachtshare information
* 2. *(PASS) (Completed 12/11/12 - 22:30) do NOT show terms and conditions field*

### Yachtshare -> Edit: http://yacht-fractions.co.uk/yachtshare/edit/1
* 1. *(PASS) (Completed 12/11/12 - 22:15) Validates: all required fields, valid email address*
* 2. *(PASS) (Completed 12/11/12 - 22:15)  Validates: a number is entered in share size, budget, length*
* 3. *(PASS) (Completed 12/11/12 - 22:15) Price field: input "10 000" - will force validation*
* (PASS) Price field: the following input should be accepted: "10000.00", "10,000"
* (PASS) Convert feet to meters if feet selected

### Yachtshare -> Upload Files: http://yacht-fractions.co.uk/file/yachtshare/1
* (PASS) able to upload
* Displays (formatted) error message to user if file is too big
* (PASS) admin able to select from file types "Private doc/photo", "Public header photo", "Public gallery photo"
* (PASS) admin able to delete upload files
* Resize images with width > 800px


### Yachtshare -> Find Buyers: http://yacht-fractions.co.uk/yachtshare/find_buyers/1
* (PASS) Yachtshare's details already entered into buyer filter form
* (PASS) Able to change filters
* (PASS) Display "Introduce"/"Already Introduced" link next to each buyer to create introduction actionstep
* (PASS) Able to use search box
* (PASS) Able to select which columns to display

Clicking on "Introduce" for a buyer in table
* (PASS) Validate form
* (PASS) Put on hold if hold period is specified.
* (PASS) Date automatically entered if this field is left blank
* (PASS) Redirect to email form with email body generated from template if "Introduce with email" button is clicked.

### Yachtshare -> Deactivate
* (PASS) Sets yachtshare status to "deactivated"
* (PASS) Displays "Activate" button instead
* (PASS) Displays "Delete Permanently" link
* (PASS) Clicking "Delete Permanently" gives "Are you sure?" prompt then deletes it if YES is clicked

### Buyer List: http://yacht-fractions.co.uk/buyer
* Able to filter according to:
* (PASS) Type
* (PASS) Location General
* (PASS) Location Specific
* (PASS) Price
* (PASS) Length
* (PASS) Share size
* (PASS) Search box performs live search on already existing table of yachtshares below
* (PASS) Able to select columns, each column displays correct information in table
* (PASS) "Sale Progress" column shows progress bar with tooltip information (when cursor is moved over a portion of the progress bar)

### Buyer -> View (Detail Page): http://yacht-fractions.co.uk/buyer/view/2
Active Sales:
If there is an ongoing sale:
* (PASS) Link to yachtshare associated with the active sale
* (PASS) Link to delete actionstep
* (PASS) Delete actionstep displays "Are you sure?" prompt
* (PASS) List actionsteps with this sale
* (PASS) Link to add a new actionstep to sale
If not:
* (PASS) Display "The buyer has not been introduced to any yachtshares yet."

Boat Specification Required:
* (PASS) Show boat specifications correctly

Details of Buyer:
* (PASS) Do not show unecessary fields (i.e. "Select Yachtshare of Interest" displays names and not ID numbers)
* (PASS) Do not show terms and conditions field
* (PASS) Do not show "Boat specification" fields as they have already been shown right above

### Buyer -> Edit: http://yacht-fractions.co.uk/buyer/edit/2
* 1. *(PASS) (Completed 12/11/12 - 23:45) Validates: all required fields, valid email address, terms and conditions must be checked*
* 2. *(PASS) (Completed 12/11/12 - 23:45)Validates: a number is entered in share size, budget, length*
* 3. *(PASS) (Completed 12/11/12 - 23:45) Price field: input "10 000" - will force validation*
* (PASS) Price field: the following input should be accepted: "10000.00", "10,000"
* (PASS) Convert feet to meters if feet selected

### Buyer -> Upload Files: http://yacht-fractions.co.uk/file/buyer/2
* (PASS) able to upload
* Displays (formatted) error message to user if file is too big
* (PASS) admin able to select from file types "Private doc/photo", "Public header photo", "Public gallery photo"
* (PASS) admin able to delete upload files
* Resize images with width > 800px

### Buyer -> Find Yachtshares: http://yacht-fractions.co.uk/buyer/find_yachtshare/2
* (PASS) Yachtshare's details already entered into buyer filter form
* (PASS) Able to change filters
* (PASS) Display "Introduce"/"Already Introduced" link next to each buyer to create introduction actionstep
* (PASS) Able to use search box
* (PASS) Able to select which columns to display

### Buyer -> Delete
* (PASS) Gives "Are you sure?" prompt then deletes when YES is clicked
* (PASS) The button does not work from buyer/find_yachtshares though it does work on all other pages


## Admin -> Other

### Formfields List
* (PASS) Displays list of formfields for buyer and yachtshare including links to edit/delete and change the order of fieldds as they appear in the front-end form

### Formfields -> Edit
* (FAIL) Able to switch between formfield types (i.e. text/dropdown/big text box etc.) using the type dropdown
* (PASS) DROPDOWN FORMFIELDS ONLY: able to change order of the items in dropdown
* (PASS) Buttons should say "Save" and "Cancel", submitting the form or going back to formfield list resepectively

## Emails
* (PASS) (Tested 14/11/12 - 18:00) Sent on "Buyer Enquiry" (buyer/create) (Using emailtemplate ID=3) (cc. Admin)
* Sent on forgot password (session/forgot)
* Sent emails from Controller_Emailnew (using templates from DB):
	1. Hold Reminder Email (cc. Admin)
	2. Yachtshare introduction to buyer  (cc. Admin)

### 

*Evan's Todo*
================================
Added 05/11/12
* ~~Find way to have yachtshare->location and buyer->location fields have the same options~~ (Completed 07/11/12 - 22:30)
* ~~formfield->dropdown->change order should open a new window~~ (Completed 06/11/12 - 16:00)

Added 04/11/12:
* ~~Formfields can have data which will "expire" at a certain date, show expiring data in sidebar of admin panel~~ (Completed 06/11/12 - 13:00)

Tasks (from Skype convo on 29/10/2012):
* ~~yachtshare/create: validate share size screws up that formrow~~ (Completed 31/10/12 - 10:15)
* ~~file/yachtshare/X: set dropdown to "Any" by default then validate something is selected~~ (Completed 31/10/12 - 12:45)
* ~~append file type (i.e. "_public_header") to file name~~ (Completed 31/10/12 - 18:30)
* ~~make "Logout" link on public pages more prominent~~ (Completed 02/11/12 - 11:30)
* ~~buyer/create: selected boats should give name and not just ID's (also in email templates)~~ (Completed 02/11/12 - 12:00)
* ~~actionstep/create: should have buttons "Introduce" and "Introduce with email"~~ (Completed 02/11/12 - 12:20)
* ~~yachtshare/edit and buyer/edit: show html descriptions~~ (Completed 02/11/12 -  12:30)
* mobile export: does not link telephone numbers
* image upload: php memory_limit???
* ~~have config file for email address in emailnew controller~~ (Completed 04/11/12 12:00) (NOTE: configure email in fuel/app/config/offline.php)
* Errors in production mode send email?

Older tasks:
* HTML scrape inactive boats from http://www.yachtfractions.co.uk/fracadmin.asp
* ~~"Save for later" saves on logout~~ (Completed 04/11/12 12:45)
* ~~Jquery interface for change order of formfields~~ (Completed 04/11/12 12:30)
* ~~Fix dropdowns going off screen problem~~ (Completed 31/10/12 - 12:45)
* ~~Validate dropdowns in buyer/create, yachtshare/create,actionstep/create`~~ (Completed 04/11/12 12:00)



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

10. Should you need to change development/production mode it can be done by changing the one line in: fuel/app/bootstrap.php

FINISHED!

*Trouble Shooting*
================================
*  Session errors occuring in offline mode: change line num 33 in /fuel/app/config/session.php from ```'driver'			=> 'db',``` to ```'driver'			=> 'cookie',```

*  Uploads not working due to PHP missing fileinfo extensions: add the following line to php.ini ```extension=fileinfo.so```

*  If you get a permission denied error pertaining to the logs then a probable solution will be to set the permissions of /fuel/app/logs directory to writable by the web server's user account. i.e. in linux run command: ```chmod -R 777 fuel/app/logs/*```

# Notes for developer
* Emails are being sent in the following methods:
	1. Controller_Buyer::action_thankyou($id);
	2. 
