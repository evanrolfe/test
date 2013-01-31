<form action="<?= Uri::create('install/admin'); ?>" method="POST" accept-charset="utf-8">
Enter the login details for the admin user:
<hr>
Email (used in login): <input type="text" name="email">
<br>
Password (used in login): <input type="text" name="password">
<br>
Name: <input type="text" name="name">
<br>
<button class="buttonS bGreen" style="margin: 6px 6px;" type="submit">Submit</button>
</form>
