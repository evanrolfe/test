	<script type="text/javascript">
	$(function(){
		var $dialog = $('<div></div>')
			.html('<?=$field->description;?>')
			.dialog({
				autoOpen: false,
				title: "Terms and Conditions",
				modal: true,
				width: 600,
				buttons: {
				    "Ok": function () {
				        $(this).dialog("close");
				    }					
				}
			});

		$('#open_terms_and_conditions').click(function() {
			$dialog.dialog('open');
			// prevent the default action, e.g., following a link
			return false;
		});
	});
	</script>

	<div class="formRow">
	    <div class="grid3"><label>
	    	I agree to Yachtfractions <a href="#" id="open_terms_and_conditions">Terms and Conditions</a>
	    	<font color="red">*</font>
	    </label></div>
	    <div class="grid9" align="left">
			<input type="checkbox" name="terms" id="" class="required">
			<br>
		</div>
		<div class="clear"></div>
	</div>
