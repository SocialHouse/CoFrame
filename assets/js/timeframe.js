$(document).ready(function(){
	if($('.time').length)
	{
		$('.date').datepicker();
		$('.time').timepicker({
	        minuteStep: 5,
	        showInputs: false,
	        disableFocus: true
	    });
	}

	$('.load_default').on('change',function() {		
	    if(this.checked) {
	    	$('.default_phases').show();
	    	$('.user_phases').hide();
	    }
	    else {
	    	$('.default_phases').hide();
	    	$('.user_phases').show();
	    }
	});

	$('#add_phases_number').click(function(){
		$('.modal-body').load(base_url+'phases/add_phases_number',function(result)
		{
			$('#myModal').modal({show:true});
			$('#add_all_phases').attr('id','add_phases');
		});
	});

	$(document).on("click","#add_phases",function() {
		var phases = $('#no_phases').val();
		if(phases > 0)
		{
			$('#myModal .modal-body').html('');
			var phase_html = $('.hide:first').clone();		
			var html_div = phase_html.html();				
			html_div = html_div.replace('Approvers for phase 1','Approvers for phase '+(1));
			html_div = html_div.split('users[a]').join('phase[users][1]');

			html_div = html_div.replace('approve_year[a]','phase[approve_year][1][]');
			html_div = html_div.replace('approve_month[a]','phase[approve_month][1][]');
			html_div = html_div.replace('approve_day[a]','phase[approve_day][1][]');
			html_div = html_div.replace('approve_time[a]','phase[approve_time][1][]');
			html_div = html_div.replace('note[a]','phase[note][1][]');
			html_div = html_div.split('readonly="readonly"').join('');
			html_div = html_div.split('disabled="disabled"').join('');

			var next_phase_button = '';
			// var next_phase_button = '<div class="col-md-12 add_phase_btn_div"><button style="margin-top:10px" type="button" class="btn btn-primary add_phases_btn pull-right" id="add_phases">Next</button></div>';

			html_div = '<div id="div_to_clone" class="row"><div class="col-md-12 user_phases well" ><a href="javascript:void(0)"  id="1" class="pull-right remove-phase">&times;</a>'+html_div+'<input type="hidden" class="phases_to_add" name="phases_to_add" value="'+phases+'" /><input type="hidden" class="phase_number" name="phase_number" value="1"/>'+next_phase_button+'</div></div>';
			$(html_div).appendTo('.modal-body');		
			$(this).attr('id','');
			$(this).attr('id','add_next_phase');

			$('.approve_time').timepicker({
		        minuteStep: 5,
		        showInputs: false,
		        disableFocus: true
		    });
		}
    });

    $(document).on("click","#add_next_phase",function() {
    	var phase_to_add = parseInt($('.modal-body .phases_to_add:last').val());
    	$('.modal-body #div_to_clone .user_phases').children('.remove-phase').remove();
    	$('.modal-body #div_to_clone .user_phases').children('.add_phase_btn_div').remove();
    	// add_phases_btn
    	var phase_added = $('.modal-body #div_to_clone .user_phases').length + 1;

    	var next_phase = parseInt($('.modal-body .phase_number:last').val()) + 1;
    	
    	var $orginal = $(".user_phases:eq("+(phase_added - 1)+")");
    	$orginal.find('textarea').attr('readonly','readonly');
    	$orginal.find(':input').attr('readonly','readonly');
    	
    	if(phase_to_add >= phase_added)
    	{
	    	var phase_html = $('.hide:first').clone();		
			var html_div = phase_html.html();
			html_div = html_div.replace('Approvers for phase 1','Approvers for phase '+(next_phase));
			html_div = html_div.split('users[a]').join('phase[users]['+next_phase+']');
			html_div = html_div.replace('approve_year[a]','phase[approve_year]['+next_phase+'][]');
			html_div = html_div.replace('approve_month[a]','phase[approve_month]['+next_phase+'][]');
			html_div = html_div.replace('approve_day[a]','phase[approve_day]['+next_phase+'][]');
			html_div = html_div.replace('approve_time[a]','phase[approve_time]['+next_phase+'][]');
			html_div = html_div.replace('note[a]','phase[note]['+next_phase+'][]');			
			html_div = html_div.replace('<input class="phases_to_add" name="phases_to_add" value="'+phase_to_add+'" type="text"><input class="phase_number" name="phase_number" value="1" type="text">','');			

			var next_phase_button = '';
			// if(phase_to_add > phase_added)
			// {
			// 	next_phase_button = '<div class="col-md-12 add_phase_btn_div"><button style="margin-top:10px" type="button" class="btn btn-primary add_phases_btn pull-right" id="add_phases">Next</button></div>';
			// }
			html_div = '<div class="col-md-12 user_phases well" ><a href="javascript:void(0)"  id="'+next_phase+'" class="pull-right remove-phase">&times;</a>'+html_div+'<input type="hidden" class="phases_to_add" value="'+phase_to_add+'" name="phases_to_add"><input type="hidden" class="phase_number" value="'+next_phase+'" name="phase_number">'+next_phase_button+'</div>';

			$(html_div).appendTo('.modal-body #div_to_clone');			
			if(phase_to_add == phase_added)
			{
				$(this).attr('id','save_phases');
			}
			$('.approve_time').timepicker({
		        minuteStep: 5,
		        showInputs: false,
		        disableFocus: true
		    });
		}
    });

    $(document).on("click","#save_phases",function() {
    	var phase_added = $('.modal-body #div_to_clone .user_phases').length + 1;

    	var next_phase = parseInt($('.modal-body .phase_number:last').val()) + 1;
    	
    	var $orginal = $(".user_phases:eq("+(phase_added - 1)+")");
    	$orginal.find('textarea').attr('readonly','readonly');
    	$orginal.find(':input').attr('readonly','readonly');

    	var html_modal_body = $('#myModal .modal-body #div_to_clone');
    	$('.phase_div').html('');
    	$(html_modal_body).appendTo('.phase_div');
    	$('#myModal').modal('hide');
    	$(this).attr('id','add_phases');
    });

    $(document).on('click','.remove-phase',function(){
    	var total_phase_added = $('.modal-body #div_to_clone .user_phases').length;
    	var phases_to_add = $(this).parents('.user_phases').children('.phases_to_add').val();
    	if( total_phase_added > 1)
    	{
    		console.log($(this).parents('.user_phases').children('.col-md-12:eq(0)'));
    		$(this).parents('.user_phases').remove();
    		var phases_already_added= $('.modal-body #div_to_clone .user_phases').length;    	
    		if(phases_to_add >= phases_already_added)
    		{
    			$('#save_phases').attr('id','add_next_phase');
    			var all_phases = $('.modal-body #div_to_clone .user_phases');
    			var i =1;
    			$.each(all_phases, function( index, value ) {
					$(value).children('.phase_num_div:first').children('label:first').html('Approvers for phase '+(i++));
				});
    		}

    	}
    });

    $(document).on('click','#cancel_phases',function(){
    	$('.add_phases_btn').attr('id','add_phases');
    });
})
