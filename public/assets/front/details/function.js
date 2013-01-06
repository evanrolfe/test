$(document).ready(function(){
		$('#photos').galleryView({
			panel_width: 565,
			panel_height: 385,
			//frame_width: 100,
			//frame_height: 99,
			// panel_width: 800,
		   // panel_height: 300,
			frame_width: 55,
			frame_height: 40,
			transition_speed: 1200,
			background_color: '#fff',
			border: 'none',
			easing: 'easeInOutBack',
			pause_on_hover: true,
		   // nav_theme: 'custom',
			overlay_height: 52,
			filmstrip_position: 'bottom',
			overlay_position: 'bottom'
				});
		
		$('.panel .zoom2 img').hover(function(){
			$('.glass').show();
		});
		$('.panel .zoom2 img').mouseout(function(){
			$('.glass').hide();
		});
		
	});

