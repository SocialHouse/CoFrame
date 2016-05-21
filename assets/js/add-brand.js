jQuery(function($) {

	$(document).ready(function() {
		$('#brandOutlets.outlet-list li').on('click', function() {
			if(!$(this).hasClass('saved')) {
				$(this).toggleClass('disabled selected');
				$(this).siblings().each(function() {
					if(!$(this).hasClass('saved')) {
						$(this).addClass('disabled').removeClass('selected');
					}
				});
				if(!$(this).hasClass('disabled')) {
					$('#addOutlet').removeClass('btn-disabled').prop("disabled", false);
				}
				else {
					$('#addOutlet').addClass('btn-disabled').prop("disabled", true);
				}
			}
		});
		$('#addNewUser.outlet-list li').on('click', function() {
			var savedOutlets = $('#userOutlet').val();
			var newOutlets = [];
			var thisOutlet = $(this).data('selectedOutlet');
			$(this).toggleClass('disabled selected');
			if($(this).hasClass('selected')) {
				if(savedOutlets !== '') {
					newOutlets.push(savedOutlets);
				}
				newOutlets.push(thisOutlet);
			}
			else {
				savedOutlets = savedOutlets.split(',');
				var index = savedOutlets.indexOf(thisOutlet);
				savedOutlets.splice(index, 1);
				newOutlets.push(savedOutlets);
			}
			$('#userOutlet').val(newOutlets);
		});
		//add brand outlet to list
		$('#addOutlet').on('click', function() {
			var $selectedItem = $('#brandOutlets .selected');
			var numberSelected =  $selectedItem.length;
			var savedOutlets = [];
			var outletsVal = $('#brandOutlet').val();
			if(numberSelected > 0) {
				var $selectedList = $('#selectedOutlets ul');
				var $listItem = $(document.createElement('li'));
				if(outletsVal !== '') {
					savedOutlets.push(outletsVal);
				}
				savedOutlets.push($selectedItem.data('selectedOutlet'));	
				var outletTitle = $selectedItem.data('selected-outlet');
				var outletId = $selectedItem.data('selected-outlet-id');
				
				var outletHtml = $selectedItem.html()+'<input type="hidden" class="outlets" name="outlets[]" value="'+outletId+'" >' ;				
				var removeOutlet = '<a href="#" class="pull-sm-right remove-outlet" data-remove-outlet="' + outletTitle + '"><i class="tf-icon circle-border">x</i></a>';
				$listItem.append(outletHtml + outletTitle + removeOutlet).attr('data-outlet', outletTitle);
				
				$selectedItem.addClass('saved').removeClass('selected');
				//set input field value
				$('#brandOutlet').val(savedOutlets);				
				$selectedList.append($listItem);
			}
			else {
				return;
			}
		});
		//remove brand outlet from list
		$('body').on('click', '.remove-outlet', function() {
			var savedOutlets = $('#brandOutlet').val().split(',');
			console.log(savedOutlets);
			var removeOutlet = $(this).data('remove-outlet');
			console.log(removeOutlet);
			console.log(savedOutlets);
			$('#selectedOutlets li[data-outlet="' + removeOutlet + '"]').slideUp(function() {
				$(this).remove();
				hideNoLength($('#selectedOutlets'));

				var index = savedOutlets.indexOf(removeOutlet);
				savedOutlets.splice(index, 1);
				$('#brandOutlet').val(savedOutlets);
			});
			$('#brandOutlets li[data-selected-outlet="' + removeOutlet + '"]').removeClass('saved').addClass('disabled');
		});

		$('#selectedOutlets').on('contentSlidDown', function() {
			hideNoLength($(this));
		});

		$('#userRoleSelect').on('change', function() {
			var selectedRole = $(this).val();
			var $actPermissions = $('.permission-details:visible');
			if($actPermissions.length) {
				$actPermissions.fadeOut(function() {
					$('#' + selectedRole + 'Permissions').slideDown();
				});
			}
			else {
				$('#' + selectedRole + 'Permissions').slideDown();
			}
		});

		$('.edit-permissions').on('click', function() {
			var section = $(this).data('section');
			var $sectionList = $('#' + section).find('.permissions-list');
			$(this).toggleClass('btn-disabled');
			$sectionList.toggleClass('view');
			if($(this).hasClass('btn-disabled')) {
				$sectionList.find('li').css('display', 'block');
			}
			else {
				$sectionList.find('li.hidden').css('display', 'none');
			}
		});
		$('.permissions-list .check-box').on('click', function() {
			var $parent = $(this).parent('li');
			$parent.toggleClass('hidden');
		});

		/*Tag Functions*/
		//assign tags to brand
		$('body').on('click', '#selectBrandTags .tag', function() {
			if($(this).hasClass('saved')) {
				return;
			}
			var checked = false;
			var label = $('#tagLabel').val();
			var $checkbox = $(this).find('input');
			if(label === 'other') {
				label = $('#otherTagLabel input').val();
			}
			$(this).toggleClass('selected');
			if($(this).hasClass('selected')) {
				checked = true;
				var $siblings = $(this).siblings(':not(.saved)');
				var $sibCheckbox = $siblings.find('input');
				if(label !== "") {
					$(this).attr('data-value', label);
				}
				$siblings.removeClass('selected').attr('data-value', '');
				$sibCheckbox.prop('checked', false);
			}
			else {
				checked = false;
			}
			//set the input value
			$checkbox.prop('checked', checked);
		});

		var customTag = false;

		$('#chooseTagColor').colorpicker({format: 'hex'}).on('changeColor', function(e) {			
			var customColor = e.color.toHex();
			var $custom = $('#selectBrandTags .custom-tag');
			var $icon = $custom.find('.fa');
			$icon.css({'color': customColor, 'border-color': customColor});
			$custom.show();
			customTag = true;
		});

		$('#tagLabel').on('change', function() {
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			if(label)
			{
				if(label !== 'other') {
					$('#otherTagLabel').hide();
					$tag.attr('data-value', label);
					$('#addTag').prop('disabled',false);
				}
				else {
					$('#otherTagLabel').show(function(){
						$(this).find('input').focus();
					});			
					$('#addTag').prop('disabled',true);
						
				}
			}
			else
			{
				$('#addTag').prop('disabled',true);
			}
		});

		$('#otherTagLabel input').on('keyup blur', function() {			
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			$tag.attr('data-value', label);
			
			if($(this).val().length > 0)
			{
				$('#addTag').prop('disabled',false);
			}
			else
			{
				$('#addTag').prop('disabled',true);	
			}
		});

		//add tag to list
		$('#addTag').on('click', function() {
			var $selectedItem = $('#selectBrandTags .selected');
			var numberSelected =  $selectedItem.length;
			if(numberSelected > 0) {
				setTimeout(function(){
					var $selectedList = $('#selectedTags ul');
					var $clone = $selectedItem.clone();

					var $listItem = $clone.remove('input').removeClass('selected');
					$listItem.children('.color').attr('name','selected_tags[]');

					var tagTitle = $selectedItem.data('value');
					var editTag = '<a href="#" class="pull-sm-right edit-tag btn-icon btn-gray" data-edit-tag="' + tagTitle + '"><i class="fa fa-pencil"></i></a>';
					//reset custom tags so that another can be added
					if(customTag === true) {
						var $custom = $('#selectBrandTags .custom-tag');					
						var $newCustom = $custom.clone();
						$newCustom.insertAfter($custom).removeClass('selected').hide();
						$custom.removeClass('custom-tag');
						customTag = false;
					}
					$listItem.append('<input type="hidden" name="labels[]" class="labels" value="'+tagTitle+'" >'+tagTitle + editTag).attr('data-tag', tagTitle);
					$selectedItem.addClass('saved').removeClass('selected');
					$selectedList.append($listItem);
				}, 100);
				$('.submit_tag').prop('disabled',false);
			}
			else {
				return;
			}
		});

		$('#selectedTags').on('contentSlidDown', function() {
			hideNoLength($(this));
		});

		$('#add-brand-details').on('submit', function(){
			$(this).addClass('success');
			//show dashboard button and tooltip
			$('#addBrandSuccess').show();
			successTip();
			$('.modal-contain').removeClass('in').hide();
			$('.brand-step').removeClass('active');
		});

		$('body').on('click', '.btn-next-step', function() {
			var next = $(this).data('nextStep');
			nextStep(next);
		});
	});

	window.successTip = function successTip() {
		$('#addBrandSuccess .btn').qtip({
			content: {
				attr: 'data-content'
			},
			position: {
				my: 'bottom center',
				at: 'top center',
				adjust: {
					y: -11
				},
				container: $('.page-main')
			},
			show: {
				effect: function() {
					$(this).fadeIn();
				},
				ready: true
			},
			hide: {
				effect: function() {
					$(this).fadeOut();
				},
				event: 'unfocus'
			},
			style: {
				classes: 'qtip-shadow text-xs-center',
				tip: {
					width: 20,
					height: 10
				},
				width: 320
			}
		});
	}

	function nextStep(i) {
		$('.brand-step').removeClass('active').addClass('inactive');
		$('#brandStep' + i).removeClass('inactive').addClass('active');
	}

	function hideNoLength(obj) {
		var numSelected = $(obj).find('li').length;
		if(numSelected < 1) {
			$(obj).hide();
		}
	}
});