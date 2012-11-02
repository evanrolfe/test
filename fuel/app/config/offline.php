<?php
return array(
	'offline_on?' => false,

  //All generated emails to public users will be sent from this email_sent
  //it MUST be from an email on the same domain as the site
  //it DOES NOT NEED to be a working email address, i.e. no need to receive emails on this account (can be a noreply@ email(
  'from_email'  =>    'noreply@evanrolfe.info',
  'from_name'   =>    'Yacht Fractions',

  //All emails will be cc'ed to this email, also data exports (for mobile) will be emailed here
  'admin_email'  =>    'evanrolfe@gmail.info',  

	//Set the percentage of the width of the content box on public pages
	//IGNORE if you dont know what this is
	'content_width' => 50,
);
