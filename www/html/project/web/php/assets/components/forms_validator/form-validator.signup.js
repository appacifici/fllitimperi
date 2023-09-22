$.validator.setDefaults(
{
	submitHandler: function() { 
        var request = $.ajax({
            url: ajaxCallPath + "call.php?" + $( '#formSignUp').serialize(),
            type: "GET",
            async: false,
            dataType: "xml"
        });

        request.done( function( xml ) {
            var totalError = false;
            var mex = false;
          
            $( xml ).find('root').each( function() {
                totalError = $( this ).find('errors').attr('total');
                mex = $( this ).find('message').text();
            });
            
            var parameters = new Array();   
            parameters['type'] = !totalError ? 'success' : 'error';
            parameters['layout'] = 'top';
            parameters['mex'] = mex;
            classNotyfy.openNotyfy( parameters );     
            
            if( !totalError )
                formControl.resetForm( "#formSignUp" );            
        });
        return false;
    },
            
	showErrors: function(map, list) {
		this.currentElements.parents('label:first, div:first').find('.has-error').remove();
		this.currentElements.parents('.form-group:first').removeClass('has-error');
		
		$.each(list, function(index, error) 
		{
			var ee = $(error.element);
			var eep = ee.parents('label:first').length ? ee.parents('label:first') : ee.parents('div:first');
			
			ee.parents('.form-group:first').addClass('has-error');
			eep.find('.has-error').remove();
			eep.append('<p class="has-error help-block pull-right" style="color:#a94442;margin-top:3px">' + error.message + '</p>');
            
		});
		//refreshScrollers();
	}
});

$(function()
{
	// validate signup form on keyup and submit
	$("#formSignUp").validate({
		rules: {
			username: {
				required: true,
				minlength: 2,
                loginRegex: true,
			},
			password: {
				required: true,
				minlength: 5
			},
			confirm_password: {
				required: true,
				minlength: 5,
				equalTo: "#password"
			},
			email: {
				required: true,
				email: true
			},
			topic: {
				required: "#newsletter:checked",
				minlength: 2
			},
			privacy: "required"
		},
		messages: {
			firstname: "Please enter your firstname",
			lastname: "Please enter your lastname",
			username: {
				required: "Inserisci la tua username",
				minlength: "L'username deve essere di almeno 3 ",
                loginRegex: "L'username può contenere solo lettere e numeri"
			},
			password: {
				required: "Inserisci una password",
				minlength: "Inserisci una password di almeno 5 caratteri"
			},
			confirm_password: {
				required: "Inserisci una password",
				minlength: "Inserisci una password di almeno 5 caratteri",
				equalTo: "Inserisci la stessa password inserita sopra"
			},
			email: "Inserisci un email valita",
			privacy: "Campo obbligatorio"
		}
	});

	// propose username by combining first- and lastname
	$("#username").focus(function() {
		var firstname = $("#firstname").val();
		var lastname = $("#lastname").val();
		if(firstname && lastname && !this.value) {
			this.value = firstname + "." + lastname;
		}
	});

	//code to hide topic selection, disable for demo
	var newsletter = $("#newsletter");
	// newsletter topics are optional, hide at first
	var inital = newsletter.is(":checked");
	var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
	var topicInputs = topics.find("input").attr("disabled", !inital);
	// show when newsletter is checked
	newsletter.click(function() {
		topics[this.checked ? "removeClass" : "addClass"]("gray");
		topicInputs.attr("disabled", !this.checked);
	});
}); 

