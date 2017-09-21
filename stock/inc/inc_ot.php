<link rel="stylesheet" href="inc/styles_ot.css" type="text/css" />
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $(".mainCompose").hide();
    $('.loader').hide();
    $('#errortxt').hide();

    $('.compose').click(function() {
    	$('.mainCompose').slideToggle();
    });
    
    $('.sendbtn').click(function(e) {
    	e.preventDefault();
    	$('.sendbtn').hide();
    	$('.loader').show();
    	
    	if($('#mymsg').val() == "") {
			$('#errortxt').show();
			$('.sendbtn').show();
			$('.loader').hide();
    	}
    	else {
    		$('sendbtn').hide();
    		$('.loader').show();
    		$('#errortxt').hide();
    		
    		var formQueryString = $('#sendprivatemsg').serialize(); // form data for ajax input
    		finalSend();    		
    	}
    
    	// possibly include Ajax calls here to external PHP
    	function finalSend() {
    		$('.mainCompose').delay(1000).slideToggle('slow', function() {
    			$('#composeicon').addClass('sent').removeClass('compose').hide();
    		
    			// hide original link and display confirmation icon
    			$('#composebtn').append('<img src="img/check-sent.png" />');
    		});
    	}
    });
});
</script>
