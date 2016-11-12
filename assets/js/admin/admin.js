$(document).ready(function(){
    
    $(".close").click(function (e) {
        e.preventDefault();
        $('.alert').slideUp('slow');
    });

	jQuery('#edit-user').validate({
        rules: {
        	first_name: {required: true},
        	last_name: {required: true},        	
        	phone:{ number: true, required: true},
        	timezone: {required: true}
        },
        messages :{
        	first_name: {required: 'First name required'},
        	last_name: {required: 'Last name required'},
        	phone:{
        		required: 'Phone number is required',
        		number: 'Please enter valid phone nuber'
        	},
        	timezone: { required: 'Please select timezone'}
        }
    });

    $("#login_form").validate({
        rules:{
            user_name: {required:true},
            password: {required:true},  
        },
        messages :{
            user_name:{'required': "Please enter user name"},
            password:{'required': "Please enter password"}
        }
    });
});