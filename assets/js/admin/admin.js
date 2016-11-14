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

    if($('#account_list').length)
    {
         $('#account_list').dataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": base_url+"admin/accounts/get_accounts",
                "type": "POST",
            },
            "columns":[
                { "data" : "first_name" },
                { "data" : "last_name" },
                { "data" : "email" },
                { "data" : "phone" },
                { "data" : "company_name" },        
                // { "data" : "id" ,
                // "orderable": false,
                // "render": function ( data, type, full, meta ) {
                //     // var action = '<a class="btn btn-primary btn-xs" href="'+base_url+'admin/edit-event/'+data+'"><i class="fa fa-edit" aria-hidden="true"></i></a> &nbsp;';
                //     // action += '<a class="btn btn-danger btn-xs delete-record"  href="'+base_url+'admin/delete-event/'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;';
                //     // action += '<a class="btn btn-info btn-xs"  href="'+base_url+'admin/invoice-link/'+data+'"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
                //     // return action;
                // }}
            ]
        });
    }
});