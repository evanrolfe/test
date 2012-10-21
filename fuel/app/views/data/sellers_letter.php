<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>

</head>
<body>
<?=$yachtshare->boat_details['seller_name'];?><br>
<?=$yachtshare->boat_details['address_1'];?><br>
<?=$yachtshare->boat_details['address_2'];?><br>
<?=$yachtshare->boat_details['postcodezipcode'];?><br>
<?=$yachtshare->boat_details['town'];?><br>
<?=$yachtshare->boat_details['country'];?><br>
<br><br>
<?=Date::forge()->format("%d/%m/%y");?>
<br><br>
Dear <?=$yachtshare->boat_details['seller_name'];?>,
<br>
<b><u>Re <?=$yachtshare->name;?></u></b>
<br><br>
<table width="600px" style="border: none;">
<tr>
	<td>I have now completed the sale of your share in <?=$yachtshare->name; ?> and enclose our invoice and a bill of a sale signed by <?=$buyer->name;?> for your records.</td>
</tr>
<tr>
	<td>I have made a payment of £<?=$yachtshare->price*0.928;?> into your account being sale proceeds £<?=$yachtshare->price;?> less our fees £<?=$yachtshare->price*0.072;?>.</td>
</tr>
</table>
<br>
Yours sincerely
<br><br>
Chris Hawes
