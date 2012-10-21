<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Yacht Fractions</title>
	<?php echo render('_includes'); ?>

</head>
<body>

<!-- Sidebar begins -->
<div id="sidebar">
    
    <!-- Secondary nav -->
    <div class="secNav">
        <div class="secWrapper">
            <div class="secTop">
                <div class="balance">
                    <div class="balInfo"><h1>Yacht Fractions</h1></div>
                </div>
            </div>
            
            <!-- Tabs container -->


		     <!-- Buyers Sidebar -->      
			<div id='buyers_sidebar'>     
		        <div id="general">
		            <ul class="subNav">
						<? foreach($links as $link): ?>
		                	<li><a href="<?= Uri::create($link['uri']); ?>" <? if($link['current']): ?>class="this"<? endif; ?>><span class="<?= $link['icon']; ?>"></span><?= $link['name']; ?></a></li>
						<? endforeach; ?>
		            </ul>
		        </div>
			</div>       
 
		        <div class="divider"><span></span></div>

		     <!-- User Sidebar -->      
			<div id='buyers_sidebar'>     
		        <div id="general">
					Logged in as: <?= $user->name; ?>
					<br>
					<a href="<?=Uri::create('session/logout');?>">Logout</a>
		        </div>
			</div> 

		        <div class="divider"><span></span></div>

		     <!-- Yachtshares on hold Sidebar -->      

				<? if(sizeof($yachtshares_on_hold) > 0): ?>
				<b>Yacht Shares on Hold:</b>
				<ul class="">
					<? foreach($yachtshares_on_hold as $yachtshare): ?>
		            <li>
		                    <span class="contactName">
		                        		                <strong><a href="<?= Uri::create('yachtshare/view/'.$yachtshare->id);?>" title=""><?= $yachtshare->yachtshare_name; ?></a></strong>
		                        <i><?= $yachtshare->hours_left; ?> hours left - 
<? if($yachtshare->email_sent): ?>
	(email sent)
<? else: ?>
<a href="<?=Uri::create('/emailnew/create/template/2/'.$yachtshare->buyer_id.'/'.$yachtshare->id.'/hold');?>">Send email</a>
<? endif; ?>
</i>
		                    </span>
		                    <span class="clear"></span>
		            </li>
					<? endforeach; ?>
		        </ul>
				<? else: ?>
					There are no yacht shares currently on hold.
				<? endif; ?>
       </div> 
       <div class="clear"></div>
   </div>
</div>
<!-- Sidebar ends -->


<!-- Content begins -->   
<div id="content"> 


    <!-- Main Section -->   
    <div class="wrapper" style='padding-top: 7px;'>
	
	<h1><?= $title; ?></h1>
    <!-- Flash Messages -->   
		<? if (Session::get_flash('success')): ?>
		<div class="nNote nSuccess">
			<? echo implode('</p><p>', e((array) Session::get_flash('success'))); ?>
		</div>
		<? endif; ?>

		<? if (Session::get_flash('error')): ?>
		<div class="nNote nFailure">
			<? echo implode('</p><p>', e((array) Session::get_flash('error'))); ?>
		</div>
		<? endif; ?>

		<!-- Content -->
   		<?php echo $content; ?>
    </div>
<!-- Content ends -->   
        
</body>
</html>


