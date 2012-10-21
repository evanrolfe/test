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
Invoice 
<br><br>

<br><br>
<table width="600px" style="border: none;">
<tr>
	<td colspan=2>Introduction fee in the sale of <?=$yachtshare->share_size_num;?>/<?=$yachtshare->share_size_den;?> of <?=$yachtshare->name; ?> for the capital sum of £<?=$yachtshare->price;?> to <?=$buyer->name;?></td>
</tr>
<tr>
	<td></td>
</tr>
<tr>
	<td>Our fee thereon @ 6%</td><td>£<?=$yachtshare->price*0.06;?>.00</td>
</tr>
<tr>
	<td>VAT @ 20.00%</td><td>£<?=$yachtshare->price*0.012;?>.00</td>
</tr>
<tr>
	<td>Total fees</td><td>£<?=$yachtshare->price*0.072;?>.00</td>
</tr>
</table>
<br>
Payments made from proceeds of sale
<br><br>
VAT no 750 5796 11

