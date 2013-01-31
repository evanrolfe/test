<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8">
	<title>Change the order of the options</title>
	<?php echo render('_includes'); ?>
	<script type="text/javascript">
		function closeAndRefresh(){
			opener.location.reload(); // or opener.location.href = opener.location.href;
			window.close(); // or self.close();
		}

		function replace_tag(label)
		{
			var label = label.split(" ").join("_").replace(/\W/g, '').toLowerCase();

			$("input[name=tag]").val(label);
		}

		var selected_options = [];
		var options = [];

		function add_option()
		{
			options.push($("#option_add_input").val());
			refresh_options();
		}

		function del_option(index)
		{
			options.splice(index,1);

			refresh_options();
		}

		function refresh_options()
		{
			//2. Set input value as these options
			$("#options").val(JSON.stringify(options));

			//3. Display the options to html
			var options_html = "";

			for(var i=0; i<options.length; i++)
			{
				options_html += '<a href="#" onclick="del_option('+i+')">[X]</a> '+options[i]+'<br>';
			}

			$("#options_display").html(options_html);
		}

		var updateForm = function()
		{
			var index_arr = $("#sortable").sortable("toArray");

			var new_options = [];

			for(var i=0; i<index_arr.length; i++)
			{
				new_options.push(options[index_arr[i]]);
			}

			options = new_options;

			refresh_options();
		}

		$(function() {
			$( "#sortable" ).sortable();//{update : updateForm});
		});

		function submit_it()
		{
			updateForm();
			$("#order_form").submit();
		}

		window.onload = function () {
				//1. Parse the dropdown options from mysql into javascript (via json)
				options = <?=$field->options;?>;

				refresh_options();

				if(<?=$close_window;?>)
				{
					opener.location.reload();
					window.close();
				}
		}

	</script>
	<link href="<?= Uri::create('public/assets/css/jquery-sortable/jquery.ui.all.css'); ?>" rel="stylesheet" type="text/css" />
	<style>
	#sortable { list-style-type: none; margin: 0; padding: 0; width: 60%; }
	#sortable li { margin: 0 1px 1px 1px; padding: 1px; font-size: 1.2em; font-weight: bold; height: 1.5em; }
	html>body #sortable li { height: 1.5em; line-height: 1.2em; }
	.ui-state-highlight { height: 1.5em; line-height: 1.2em; }
	</style>
</head>
<body>
<h3>Drag the options to the desired order then click "Save"</h3>
<br>
<form action="<?= Uri::create('formfieldbuyer/dropdown/'.$field->id); ?>" method="POST" accept-charset="utf-8" id="order_form">
	<div align="right">
		<button type="button" onclick="submit_it()" class="buttonS bGreen" style="margin: 6px 6px; color: white;">Save</button>
	</div>	
	
<input type='hidden' name='options' id='options' width="20">

	<ul id="sortable" style="width: 80%;">
		<? $i=0; ?>
		<? foreach(json_decode($field->options) as $option): ?>
			<li class="ui-state-default" id="<?=$i;?>"><?=$option;?></li>
			<? $i++; ?>
		<? endforeach; ?>
	</ul>
	<div align="right">
		<button type="button" onclick="submit_it()" class="buttonS bGreen" style="margin: 6px 6px; color: white;">Save</button>
	</div>
</form>
</body>
