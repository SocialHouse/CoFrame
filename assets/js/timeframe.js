$(document).ready(function(){
	if($('#date').length)
	{
		$('#date').datepicker();

	    $('#time').timepicker({
	        minuteStep: 5,
	        showInputs: false,
	        disableFocus: true
	    });
	}
})
