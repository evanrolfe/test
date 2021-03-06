<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title><?=$title;?></title>
	<?php echo render('_includes'); ?>

	<? if(false)://isset($form_page) and $form_page): ?>

<script type="text/javascript">

     function PopIt() { return ""; }
     function UnPopIt()  { /* nothing to return */ } 
 
     $(document).ready(function() {
     	window.onbeforeunload = PopIt;
		$("a").click(function(){ window.onbeforeunload = UnPopIt; });
     });
</script>

	<? endif; ?>
    <style type="text/css">
<!--
.style1 {
	color: #999999;
	font-size: x-small;
}
.style2 {font-size: small}
-->
    </style>
</head>
<body <? if(isset($form_page) and $form_page): ?>onbeforeunload="return confirmExit()"<? endif; ?>>
<div style="width: 100%; padding-top: 20px;" align="center">
	<h1><?= $title; ?></h1>

	<? if(isset($offline) and $offline): ?>
		<div class="nNote nFailure" style="width: 75%;">
			<h1>Currently in Offline Mode</h1>
			<br>
			Login just as you would on the online site.
		</div>
	    <p>
		<? endif;?>

		<?php echo render('_flash_messages'); ?>

	    <?= $content; ?>


	    <br>
	Chris Hawes, Yacht Fractions Ltd., PO Box 196, Falmouth, Cornwall. TR11 5WD Tel: 01326 374435 Fax 01326 374625 Email <a href="mailto:chris@yachtfractions.co.uk">chris@yachtfractions.co.uk</a> </p>
	    <p>
	      <span class="style1">Website Development by <a href='http://evanrolfe.info'>Evan Rolfe</a></span><span class="style2">.</span>
	      <? if(isset($user) and $user): ?>
            </p>
<div>
	  <a href="<?= Uri::create('session/logout'); ?>" class="buttonS bLightBlue ">
	    Logout
	  </a>
	  </div>
	  <br>
  <? endif; ?>
</div>
