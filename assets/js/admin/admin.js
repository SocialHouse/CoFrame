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

    $("#change_password_form").validate({
        rules:{
            old_password : {required:true, remote: {url: base_url+"admin/auth/check_old_password", type : "post"}},
            password : {required:true},
            confirm_password :{ required : true,equalTo: "#newPass"},
        },
        messages :{
            old_password : {'required': "Please enter current password",'remote' : 'You have entered wrong current password'},
            password : {'required': "Please enter new password"},
            confirm_password : {'required': "Please confirm password",'equalTo':'New password and confirm passowrd fields should be same'}
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
                { "data" : "plan" },
                { "data" : "id" ,
                "orderable": false,
                "render": function ( data, type, full, meta ) {
                    var action = '<div class="tabledit-toolbar btn-toolbar" style="text-align: left;"><div class="btn-group btn-group-sm" style="float: none;">';
                    action += '<a data-toggle="tooltip" data-placement="bottom" target="_blank" data-original-title="Login" href="'+base_url+'tour/login_fast/'+data+'" class="tabledit-edit-button btn btn-sm btn-default" style="float: none;">';
                    action += '<span class="font-icon font-icon-user"></span>';
                    action += '</a>';
                    var css_class = 'glyphicon glyphicon-ok-circle';
                    var title = "Unban";
                    if(full.banned == 0)
                    {
                        title = "Ban";
                        css_class = 'glyphicon glyphicon-ban-circle';
                    }

                    action += '<a data-toggle="tooltip" data-placement="bottom" data-original-title="Statistics" href="'+base_url+'accounts/stats/'+data+'" class="tabledit-edit-button btn btn-sm btn-default" style="float: none;">';
                    action += '<span class="font-icon font-icon-speed"></span>';
                    action += '</a>';


                    action += '<a  data-toggle="tooltip" data-placement="bottom" data-original-title="'+title+'" href="'+base_url+'admin/accounts/change_status/'+full.id+'/'+full.banned+'" class="tabledit-delete-button btn btn-sm btn-default" style="float: none;">';
                    action += '<span class="'+css_class+'"></span>';
                    action += '</a></div></div>';
                    return action;
                    // var action = '<a class="btn btn-primary btn-xs" href="'+base_url+'admin/edit-event/'+data+'"><i class="fa fa-edit" aria-hidden="true"></i></a> &nbsp;';
                    // action += '<a class="btn btn-danger btn-xs delete-record"  href="'+base_url+'admin/delete-event/'+data+'"><i class="fa fa-trash" aria-hidden="true"></i></a> &nbsp;';
                    // action += '<a class="btn btn-info btn-xs"  href="'+base_url+'admin/invoice-link/'+data+'"><i class="fa fa-envelope" aria-hidden="true"></i></a>';
                    // return action;
                }}
            ]
        });
    }
});