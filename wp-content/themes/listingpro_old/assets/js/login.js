jQuery(document).ready(function($) {


    // Perform AJAX login on form submit
    $('form#login').on('submit', function(e){
		e.preventDefault();
        $('form#login p.status').show().html(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#login #lpusername').val(), 
                'password': $('form#login #lppassword').val(), 
                'security': $('form#login #security').val(),
				'g-recaptcha-response': $('form#login .g-recaptcha-response').val()},
            success: function(data){
				
				if (jQuery("form#login .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				
                $('form#login p.status').html(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        
    });
	
	// Perform AJAX login on from listing login template
    $('form#lp-login-temp').on('submit', function(e){
		e.preventDefault();
        $('form#lp-login-temp p.status').show().html(ajax_login_object.loadingmessage);
        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                'username': $('form#lp-login-temp #lpusernameT').val(), 
                'password': $('form#lp-login-temp #lppasswordT').val(), 
                'security': $('form#lp-login-temp #lpsecurityT').val(),
				'g-recaptcha-response': $('form#lp-login-temp .g-recaptcha-response').val()},
            success: function(data){
				
				if (jQuery("form#lp-login-temp .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
				
                $('form#lp-login-temp p.status').html(data.message);
                if (data.loggedin == true){
                    document.location.href = ajax_login_object.redirecturl;
                }
            }
        });
        
    });
	
	// Perform AJAX login on form submit
    $('form#register').on('submit', function(e){
        $('form#register p.status').show().html(ajax_login_object.loadingmessage);
        $.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajax_register', //calls wp_ajax_nopriv_ajaxregister
                'username': $('form#register #username2').val(), 
                'email': $('form#register #email').val(), 
                'upassword': $('form#register #upassword').val(), 
                'security': $('form#register #security2').val(),
                'g-recaptcha-response': $('form#register .g-recaptcha-response').val() },
				
            success: function(data){
				if (jQuery("form#register .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
                jQuery('form#register p.status').html(data.message);
				var timer = '';
				 function flipItNow(){
					jQuery('.forgetpasswordcontainer').fadeOut();
					jQuery('.siginupcontainer').fadeOut();
					jQuery('.siginincontainer').fadeIn();
					clearTimeout(timer);
				}
				timer = setTimeout(flipItNow, 5000);
				
            }
        });
        e.preventDefault();
    });
	
	$('form#registertmp').on('submit', function(e){
        $('form#registertmp p.status').show().html(ajax_login_object.loadingmessage);
        $.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajax_register', //calls wp_ajax_nopriv_ajaxregister
                'username': $('form#registertmp #username2T').val(), 
                'email': $('form#registertmp #emailT').val(), 
                'upassword': $('form#registertmp #upasswordT').val(), 
                'security': $('form#registertmp #lpsecurityregT').val(),
                'g-recaptcha-response': $('form#registertmp .g-recaptcha-response').val() },
				
            success: function(data){
				if (jQuery("form#registertmp .g-recaptcha-response").length){
					lp_reset_grecaptcha();
				}
                jQuery('form#registertmp p.status').html(data.message);
				var timer = '';
				 function flipItNow(){
					jQuery('.forgetpasswordcontainer').fadeOut();
					jQuery('.siginupcontainer').fadeOut();
					jQuery('.siginincontainer').fadeIn();
					clearTimeout(timer);
				}
				timer = setTimeout(flipItNow, 5000);
				
            }
        });
        e.preventDefault();
    });
	
	
	// Perform AJAX forget password
    $('form#lp_forget_pass_form').on('submit', function(e){
        $('form#lp_forget_pass_form p.status').show().html(ajax_login_object.loadingmessage);
        $.ajax({
			type: 'POST',
            dataType: 'json',
            url: ajax_login_object.ajaxurl,
            data: { 
                'action': 'ajax_forget_pass', //calls wp_ajax_nopriv_ajaxregister
                'email': $('form#lp_forget_pass_form #email3').val(), 
                'security': $('form#lp_forget_pass_form #security3').val() },
				
            success: function(data){
				//grecaptcha.reset();
                $('form#lp_forget_pass_form p.status').html(data.message);
            }
        });
        e.preventDefault();
    });
	
	// Perform AJAX forget password

$('form#lp_forget_pass_formm').on('submit', function(e){

    $('form#lp_forget_pass_formm p.status').show().html(ajax_login_object.loadingmessage);

    $.ajax({

        type: 'POST',

        dataType: 'json',

        url: ajax_login_object.ajaxurl,

        data: {

            'action': 'ajax_forget_pass', //calls wp_ajax_nopriv_ajaxregister

            'email': $('form#lp_forget_pass_formm #email2').val(),

            'security': $('form#lp_forget_pass_formm #security4').val() },

        success: function(data){

            //grecaptcha.reset();

            $('form#lp_forget_pass_formm p.status').html(data.message);

        }

    });

    e.preventDefault();

});

});


