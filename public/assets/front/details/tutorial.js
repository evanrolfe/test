$(function() {
  $('.error').hide();
  $('input.text-input').css({backgroundColor:"#FFFFFF"});
  $('input.text-input').focus(function(){
    $(this).css({backgroundColor:"#FFDDAA"});
  });
  $('input.text-input').blur(function(){
    $(this).css({backgroundColor:"#FFFFFF"});
  });

  $(".button").click(function() {
		// validate and process form
		// first hide any error messages
    $('.error').hide();
		
	  var name = $("input#name").val();
		if (name == "") {
      $("label#name_error").show();
      $("input#name").focus();
      return false;
    }
		var email = $("input#email").val();
		if (email == "") {
      $("label#email_error").show();
      $("input#email").focus();
      return false;
    }
	
	var num = $("input#num").val();
		if (num == "") {
      $("label#num_error").show();
      $("input#num").focus();
      return false;
    }
	var phone = $("input#phone").val();
	var arrival = $("input#arrival").val();
	var departure = $("input#departure").val();
	var message = $("textarea#message").val();
	var apartment = $("input#apartment").val();
	
	
		
		var dataString = 'name='+ name + '&email=' + email + '&phone=' + phone + '&num=' + num + '&apartment=' + apartment + '&arrival=' + arrival + '&departure=' + departure + '&message=' + message;
		//alert (dataString);return false;
		
		$.ajax({
      type: "POST",
      url: "../../plugins/apartments/bin/process.php",
      data: dataString,
      success: function() {
        $('#contact_form').html("<div id='message'></div>");
        $('#message').html("<h2>Contact Form Submitted!</h2>")
        .append("<p>We will be in touch soon.</p>")
        .hide()
        .fadeIn(200, function() {
          $('#message').append("&nbsp;");
        });
        
      }
     });
    return false;
	});
});
runOnLoad(function(){
  
});
