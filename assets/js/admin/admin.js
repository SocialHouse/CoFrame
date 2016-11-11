$(document).ready(function(){
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
});