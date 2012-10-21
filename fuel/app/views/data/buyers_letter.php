<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>

</head>
<body>
<?=$buyer->name;?><br>
<?=$buyer->preferences['address1'];?><br>
<?=$buyer->preferences['address2'];?><br>
<?=$buyer->preferences['town'];?><br>
<?=$buyer->preferences['postcode'];?><br>
<?=$buyer->preferences['country'];?><br>
<br><br>
<?=Date::forge()->format("%d/%m/%y");?>
<br><br>
Dear <?=$buyer->name;?>,
<br>
<b><u>Re <?=$yachtshare->name;?></u></b>
<br><br>
<table width="600px" style="border: none;">
<tr>
	<td>I have now completed the purchase of a <?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?> share in <?=$yachtshare->name; ?> on your behalf and enclose a signed bill of sale transferring title to yourself, you should retain this as your proof of ownership.</td>
</tr>
</table>
<br>
You should ensure that the insurance details and SSR are updated to reflect your ownership prior to your first sail.
<br><br>
I wish you many happy days sailing.
<br><br>
Chris Hawes
