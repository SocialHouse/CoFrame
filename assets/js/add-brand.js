jQuery(function($) {
	var validName = false;
	var validEmail = false;
	$(document).ready(function() {

		if ($("#add-brand-details").length || $("#step_1_edit").length || $("#step_3_edit").length) {
			// this is use to crop image 
			$('.cropme').simpleCropper();
		}

		var selected_tag = $('#selectedTags').find('li');
		var brandStepH;
		var customTag = false;

		$.each(selected_tag, function(a, b) {
			$.each($('.tag-list').children('.tags-to-add').find('li'), function(c, d) {
				if ($(d).data('color') == $(b).find('a:last').attr('data-color')) {
					$(d).attr('data-value', $(b).data('value'));
					$(d).addClass('saved');
				}
			});
		});

		if ($('#userPermissionsList').children('.table').length) {
			toggleBtnClass('#add_user_next', false);
		} else {
			toggleBtnClass('#add_user_next', true);
		}

		$('#brandOutlets.outlet-list li').on('click', function() {
			if (!$(this).hasClass('saved')) {
				$(this).toggleClass('disabled selected');
				$(this).siblings().each(function() {
					if (!$(this).hasClass('saved')) {
						$(this).addClass('disabled').removeClass('selected');
					}
				});
				if (!$(this).hasClass('disabled')) {
					toggleBtnClass('#addOutlet', false);
				} else {
					toggleBtnClass('#addOutlet', true);
				}
			}
		});

		//add brand outlet to list
		$('#addOutlet').on('click', function() {
			var $selectedItem = $('#brandOutlets .selected');
			var numberSelected = $selectedItem.length;
			var savedOutlets = [];
			var outletsVal = $('#brandOutlet').val();
			if (numberSelected > 0) {
				var $selectedList = $('#selectedOutlets ul');
				var $listItem = $(document.createElement('li'));
				if (outletsVal !== '') {
					savedOutlets.push(outletsVal);
				}
				savedOutlets.push($selectedItem.data('selectedOutlet'));
				var outletTitle = $selectedItem.data('selected-outlet');
				var outletId = $selectedItem.data('selected-outlet-id');
				var outletConst = $selectedItem.data('outlet-const');

				var outletHtml = $selectedItem.html() + '<input type="hidden" class="outlets" name="outlets[]" value="' + outletId + '" >';
				var removeOutlet = '<a href="#" class="pull-sm-right remove-outlet" data-remove-outlet="' + outletTitle + '"><i class="tf-icon circle-border">x</i></a>';
				$listItem.append(outletHtml + outletTitle + removeOutlet).attr('data-outlet', outletTitle);

				$selectedItem.addClass('saved').removeClass('selected');
				//set input field value
				$('#brandOutlet').val(savedOutlets);
				$selectedList.append($listItem);

				if ($('#selectedOutlets').children('ul').children('li')) {
					toggleBtnClass('#save_outlet', false);
				} else {
					toggleBtnClass('#save_outlet', true);
				}
			} else {
				return;
			}
		});

		//remove brand outlet from list
		$('body').on('click', '.remove-outlet', function() {
			var savedOutlets = $('#brandOutlet').val().split(',');
			var removeOutlet = $(this).data('remove-outlet');
			$('#selectedOutlets li[data-outlet="' + removeOutlet + '"]').slideUp(function() {
				$(this).remove();
				hideNoLength($('#selectedOutlets'));

				var index = savedOutlets.indexOf(removeOutlet);
				savedOutlets.splice(index, 1);
				$('#brandOutlet').val(savedOutlets);
			});
			$('#brandOutlets li[data-selected-outlet="' + removeOutlet + '"]').removeClass('saved').addClass('disabled');

			if (savedOutlets.length > 1) {
				toggleBtnClass('#save_outlet', false);
			} else {
				toggleBtnClass('#save_outlet', true);
			}
		});

		$('#selectedOutlets').on('contentSlidDown', function() {
			hideNoLength($(this));
		});

		$('#addNewUser').on('contentSlidDown', function(event, element) {
			var parentInlineH = $(this).parents('.brand-step').prop('style')['height'];
			var parentH = $(this).parents('.brand-step').height();
			var contentH = $(this).parents('.container-brand-step').outerHeight();
			if (parentInlineH !== 'auto' && contentH > parentH) {
				brandStepH = parentInlineH;
				$(this).parents('.brand-step').css({
					'height': 'auto'
				});
			}
		});

		$('#addNewUser').on('contentSlidUp', function(event, element) {
			$(this).parents('.brand-step').css({
				'height': brandStepH
			});
			$('#userSelect, #addUserInfo').removeAttr('style');
			// $('#userSelect select').val('');
			toggleBtnClass('#addRole', true);
		});

		// Remove selected class from social icons when adding a second.
		$('#addUserLink').on('click', function() {
			$('.brand-step .outlet-list li').removeClass('selected');
			$('.brand-step .outlet-list li').addClass('disabled');
			$('#nameValid').addClass('hide');
			$('#emailValid').addClass('hide');
			$('#emailUniqueValid').addClass('hide');
			$('.editUserToBrand').removeClass('editUserToBrand');
			if ($.trim($('#user_pic_base64').val()) != '') {
				$('#user_pic_base64').val('');
			}
			if ($('#new_user_pic img').attr('src') != '') {
				$('#new_user_pic').removeClass('hasUpload');
				$('#new_user_pic img').remove();
			}
			toggleBtnClass('.editUserToBrand', true);
		})

		// Clear tag field when adding a second tag.
		$('#addTagLink').on('click', function() {		

			$('#newLabel').val("");
			$('#tagLabel').val("");
			$('#tagLabel').attr('data-edit_color', '');
			$('#tagLabel').attr('data-edit_value', '');
			$('#tagLabel').attr('data-edit_index', '');
			$('#tagLabel').attr('data-prev_value', '');
			$('#tagLabel').attr('data-prev_color', '');
			$('#tagLabel').removeClass('edit-process');
			$('#otherTagLabel').hide();
			// $(".tags-to-add").children('li selected').removeClass('selected');
			var selected_tag = $('#selectedTags').find('li');
			$.each(selected_tag, function(a, b) {
				$.each($('.tag-list').children('.tags-to-add').find('li'), function(c, d) {
					if ($(d).attr('data-color') == $(b).find('a:last').attr('data-color')) {
						// if(!$(d).hasClass('tag-custom'))
						// {
							console.log($(d));
							$(d).attr('data-value', $(b).attr('data-value'));
							$(d).removeClass('selected');
							$(d).addClass('saved');
						// }
					}
				});
			});

			$custom_tag = $(".tags-to-add").find('li.custom-tag');			
			console.log($custom_tag);
			$custom_tag.removeClass('selected');
			$custom_tag.removeClass('saved');
			$custom_tag.addClass('hidden');
			$custom_tag.hide();
			$custom_tag.attr('data-value','');

			toggleBtnClass('#addTag', true);
		});

		$('#userRoleSelect').on('change', function() {
			var selectedRole = $(this).val();
			if (selectedRole) {
				if (selectedRole == 'billing') {
					$('.edit-permissions').hide();
				} else {
					$('.edit-permissions').show();
				}

				toggleBtnClass('.addUserToBrand', false);
			} else {
				toggleBtnClass('.addUserToBrand', true);
			}

			var $actPermissions = $('.permission-details:visible');
			if ($actPermissions.length) {
				$actPermissions.fadeOut(function() {
					$('#' + selectedRole + 'Permissions').slideDown();
				});
			} else {
				$('#' + selectedRole + 'Permissions').slideDown();
			}
		});

		$('.edit-permissions').on('click', function() {
			var section = $(this).data('section');
			var $sectionLabel = $('#' + section).find('.permissions-label');
			var $sectionList = $('#' + section).find('.permissions-list');
			$(this).toggleClass('btn-disabled');
			$sectionList.toggleClass('view');
			if ($(this).hasClass('btn-disabled')) {
				$sectionList.find('li').css('display', 'block');
				$sectionLabel.text(language_message.modify_permissions);
			} else {
				$sectionList.find('li.hidden').css('display', 'none');
				$sectionLabel.text(language_message.default_permissions);
			}
		});

		$('.permissions-list .check-box').on('click', function() {
			var $parent = $(this).parent('li');
			$parent.toggleClass('hidden');
		});

		/*Tag Functions*/
		//assign tags to brand
		$('#selectBrandTags .tag').unbind('click').click(function(event) {
			if ($(this).hasClass('save-list-tag')) {
				return;
			}
			if ($(this).hasClass('saved')) {
				return;
			}
			var checked = false;
			var label = $('#tagLabel').val();
			var $checkbox = $(this).find('input');
			if (label === 'other') {
				label = $('#otherTagLabel input').val();
			}
			$(this).toggleClass('selected');
			if ($(this).hasClass('selected')) {
				checked = true;
				var $siblings = $(this).siblings(':not(.saved)');
				var $sibCheckbox = $siblings.find('input');
				if (label !== "") {
					$(this).attr('data-value', label);
				}
				$siblings.removeClass('selected').attr('data-value', '');
				$sibCheckbox.prop('checked', false);
			} else {
				checked = false;
			}
			//set the input value
			$checkbox.prop('checked', checked);
		});

		$('#chooseTagColor').colorpicker({
			format: 'hex'
		}).on('changeColor', function(e) {
			var customColor = e.color.toHex();
			var $custom = $('#selectBrandTags .custom-tag');
			var $icon = $custom.find('.fa');
			$icon.css({
				'color': customColor,
				'border-color': customColor
			});
			$custom.attr('data-color', customColor);
			$custom.show();
			$custom.children().attr('value', customColor);
			customTag = true;
		});

		$('#tagLabel').on('keyup change', function() {
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			if (label) {
				if (label !== 'other') {
					$('#otherTagLabel').hide();
					$tag.attr('data-value', label);
					// toggleBtnClass('#addTag',false);
					var selected_tag = $('#selectedTags').children('ul').children('li');
					//console.log(selected_tag);
					var add_flag = 1;
					var control = this;
					setTimeout(function() {
						$.each(selected_tag, function(a, b) {							
							if ($(b).data('value') == $(control).val()) {
								add_flag = 0;
								$('#labelSelectValid').removeClass('hide');
							}

							if ($(b).data('value') == $(control).val() && $(control).hasClass('edit-process') && $(control).attr('data-edit_color') == $(b).children('a:last').data('color')) {
								add_flag = 1;
								$('#labelSelectValid').addClass('hide');
								toggleBtnClass('#addTag', false);
								return false;
							}
						});
						if (add_flag == 1) {
							$('#labelSelectValid').addClass('hide');
							if ($(control).val()) {
								toggleBtnClass('#addTag', false);
							}
						} else {
							toggleBtnClass('#addTag', true);
						}
					}, 300);
				} else {
					$('#labelSelectValid').addClass('hide');
					$('#otherTagLabel').show(function() {
						$(this).find('input').focus();
					});

					if (!$('#newLabel').val()) {
						toggleBtnClass('#addTag', true);
					} else {
						toggleBtnClass('#addTag', false);
					}
				}
			} else {
				toggleBtnClass('#addTag', true);
			}
		});

		$('#otherTagLabel input').on('keyup blur', function() {
			var $tag = $('#selectBrandTags .selected');
			var label = $(this).val();
			$tag.attr('data-value', label);

			if ($(this).val().length > 0) {
				$('#addTag').prop('disabled', false);
			} else {
				$('#addTag').prop('disabled', true);
			}
		});

		//add tag to list
		$('#addTag').on('click', function() {
			var $selectedItem = $('#selectBrandTags .selected');
			var numberSelected = $selectedItem.length;
			var $selectedList = $('#selectedTags ul');
			var control = this;
			if ($('#tagLabel').hasClass('edit-process')) {
				if (numberSelected > 0) {
					$.each($selectedList.children('li'), function(a, b) {
						if ($('#tagLabel').attr('data-edit_index') == $(b).attr('data-index')) {
							$(b).attr('data-tag', $selectedItem.attr('data-value'));
							$(b).attr('data-value', $selectedItem.attr('data-value'));
							$(b).find('input[type="checkbox"]').val($selectedItem.attr('data-color'));
							$(b).find('i:first').css('color', $selectedItem.attr('data-color'));
							$(b).find('.labels').val($selectedItem.data('value'));
							$(b).find('a:first').attr('data-remove-tag', $selectedItem.attr('data-value'));

							$(b).find('a:last').attr('data-previous_value', $(b).find('a:last').attr('data-value'));
							$(b).find('a:last').attr('data-previous_color', $(b).find('a:last').attr('data-color'));

							$(b).find('a:last').attr('data-value', $selectedItem.attr('data-value'));
							$(b).find('a:last').attr('data-color', $selectedItem.attr('data-color'));
							$(b).find('span:first').text($selectedItem.attr('data-value'));

							$('#tagLabel').attr('data-prev_value', $selectedItem.attr('data-value'));
							$('#tagLabel').attr('data-prev_color', $selectedItem.attr('data-color'));
						}
					});
				} else {
					return
				}
			} else {
				if (numberSelected > 0) {
					var $clone = $selectedItem.clone();

					var $listItem = $clone.remove('input').removeClass('selected');					
					$('.submit_tag').prop('disabled', true);
					setTimeout(function() {
						$listItem.children('.color').attr('name', 'selected_tags[]');						
						var tagTitle = $selectedItem.attr('data-value');
						var editTag = '<a class="pull-sm-right remove-tag" data-remove-outlet="twitter" href="#"><i class="tf-icon circle-border">x</i></a>';
						//reset custom tags so that another can be added
						if (customTag === true) {
							// var $custom = $('#selectBrandTags .custom-tag');
							// var $newCustom = $custom.clone();
							// $newCustom.insertAfter($custom).removeClass('selected').hide();
							// $custom.remove('custom-tag');
							customTag = false;
						}

						$listItem.append('<input type="hidden" name="labels[]" class="labels" value="' + tagTitle + '" >' + tagTitle + editTag).attr('data-tag', tagTitle);
						$selectedItem.addClass('saved').removeClass('selected');
						$selectedList.append($listItem);
					}, 200);
					toggleBtnClass('.submit_tag', false);
					$('.submit_tag').prop('disabled', false);
				} else {
					return;
				}
			}
		});

		$('.edit-tag').unbind('click').click(function() {
			$custom_tag = $(".tags-to-add").find('li.custom-tag');
			$custom_tag.removeClass('selected');
			$custom_tag.removeClass('saved');
			$custom_tag.addClass('hidden');
			$custom_tag.attr('data-value','');

			control = this;
			var li = $(".tags-to-add").children('li');
			var selected = 0;
			var selected_tag = $('#selectedTags').find('li');

			$.each(selected_tag, function(a, b) {
				$.each($('.tag-list').children('.tags-to-add').find('li'), function(c, d) {
					if ($(d).attr('data-color') == $(b).children('a:last').attr('data-color')) {
						$(d).attr('data-value', $(b).data('value'));
						$(d).addClass('saved');
						$(d).removeClass('selected');
					}
				});
			});
			var color_found = 0;
			$.each(li, function(a, b) {
				if ($(b).attr('data-color') == $(control).attr('data-color') && $(b).attr('data-value') == $(control).data('value')) {
					$(b).removeClass('saved');
					$(b).removeClass('hidden');
					$(b).addClass('selected');
					var data_tag_val = $(b).attr('data-value');
					color_found = 1;
				}
			});			
			
			if(color_found == 0)
			{
				$custom_tag.addClass('selected');
				$custom_tag.attr('data-value',$(control).attr('data-value'));
				$custom_tag.attr('data-color',$(control).attr('data-color'));
				$custom_tag.removeClass('hidden');
				$custom_tag.removeClass('saved');
				$custom_tag.find('input[type="checkbox"]').val($(control).attr('data-color'));
			}	

			$('#tagLabel').addClass('edit-process');
			$('#tagLabel').attr('data-edit_value', $(this).attr('data-value'));
			$('#tagLabel').attr('data-edit_color', $(this).attr('data-color'));
			$('#tagLabel').attr('data-edit_index', $(this).data('index'));

			toggleBtnClass('.submit_tag', false);

			$('#tagLabel>option').map(function() {
				if ($(this).val() == $(control).attr('data-previous_value')) {
					$(this).remove();

				}

				if ($(this).val() == $(control).attr('data-value')) {
					$(this).remove();

				}

				if ($(this).val() == 'other') {
					$(this).remove();

				}
			});
			$('#tagLabel').append('<option selected="selected" value="' + $('#tagLabel').attr('data-edit_value') + '">' + $('#tagLabel').attr('data-edit_value') + '</option><option value="other">+ADD LABEL</option>');
			$('#tagLabel').val($('#tagLabel').attr('data-edit_value'));
			$("#tagLabel").trigger('change');
			//alert(language_message.edit_tag_msg);
			getConfirm(language_message.edit_tag_msg,'','alert',function(confResponse) {});
		});

		$('#selectedTags').on('contentSlidDown', function() {
			hideNoLength($(this));
		});

		$('#add-brand-details').on('submit', function() {
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

		$( '#userSelect select' ).unbind( "change").bind("change", function() {
			if ($(this).val() === "Add New") {
				toggleBtnClass('#addRole', true);
				$('#userSelect').slideUp(function() {
					$('#addUserInfo').slideDown(function() {
						equalColumns();
					});
				});
			} else if ($(this).val() !== "") {
				var img_src = $(this).find(':selected').data('img-url');
				$('#new_user_pic').empty();
				$('#user_pic_base64').val('');
				if(img_src.search('default_profile.jpg') == -1){
					$("#new_user_pic").addClass('hasUpload');
					if(!$(".remove-user-img").hasClass('hide')){
						$(".remove-user-img").addClass('hide');
					}
					$('#new_user_pic').prepend($('<img>',{src:img_src}));
					$('#is_user_image').val('already_exists');
				}else{
					$("#new_user_pic").removeClass('hasUpload');
					$('#is_user_image').val('');
				}
				// if($('#user-selected-outlet li'))
				$.each($('#user-selected-outlet li'), function(i, element) {
					if($(element).hasClass('selected')){
						toggleBtnClass('#addRole', false);
					}
				});
				
			} else {
				toggleBtnClass('#addRole', true);
			}
		});

		$('#firstName,#lastName').unbind('keyup change').bind('click change', function() {
			if ($('#lastName').val() && $('#userEmail').val() && validateEmail($('#userEmail').val()) && $('#firstName').val() && validEmail) {
				toggleBtnClass('#addRole', false);
			} else {
				toggleBtnClass('#addRole', true);
			}
		});

		$(document).on('click', '.remove-tag', function() {
			control = this;
			var li = $(".tags-to-add").children('li');
			var selected = 0;
			$.each(li, function(a, b) {
				if ($(b).data('color') == $(control).parents('li').data('color') && $(b).data('value') == $(control).parents('li').data('value')) {
					$(b).removeClass('saved');
				}
				if ($(b).hasClass('saved')) {
					selected++;
				}
			});
			if (selected > 0) {
				toggleBtnClass('.submit_tag', false);
			} else {
				toggleBtnClass('.submit_tag', true);
			}
			$(this).parents('li').remove();
		});

		$(document).on('keyup change', '#userEmail', function() {
			if ($('#firstName').val() && $('#lastName').val() && $(this).val() && validateEmail($(this).val())) {
				toggleBtnClass('#addRole', false);
			} else {
				toggleBtnClass('#addRole', true);
			}

			if (!validateEmail($(this).val())) {
				if ($(this).val().length > 2) {
					$('#emailValid').html(language_message.not_valid_email);
					$('#emailValid').removeClass('hide');
					$('#emailUniqueValid').addClass('hide');
				}

				if (!$(this).val()) {
					$('#emailValid').addClass('hide');
					$('#emailUniqueValid').addClass('hide');
				}
			} else {
				$('#emailValid').addClass('hide');
				$.ajax({
					url: base_url + 'brands/check_email_exist',
					type: 'POST',
					data: {
						'email': $('#userEmail').val(),
						'brand_id': $('#brand_id').val()
					},
					success: function(data) {
						data = $.parseJSON(data);
						if (data.response == 'current_brand') {
							validEmail = false;
							$('#emailUniqueValid').text(language_message.email_present_in_current_brand);
							$('#emailUniqueValid').removeClass('hide');
						} else if (data.response == 'current_account') {
							var message = language_message.email_present_in_current_ac;
							if($('#userEmail').data('user_preference'))
							{
								validEmail = true;
								if($('#emailUniqueValid').hasClass('hide')){
									$('#emailUniqueValid').addClass('hide');
								}
								//message = language_message.present_in_current_ac_preference;
							}else{
								validEmail = false;
								$('#emailUniqueValid').text(message);
								$('#emailUniqueValid').removeClass('hide');
							}
						
						} else if (data.response == 'current_admin') {
							validEmail = false;
							$('#emailUniqueValid').text(language_message.master_admin_email);
							$('#emailUniqueValid').removeClass('hide');
						} else if (data.response == 'account_user') {
							validEmail = false;
							$('#emailUniqueValid').text(language_message.email_is_account_user);
							$('#emailUniqueValid').removeClass('hide');
						} else {
							validEmail = true;
							$('#emailUniqueValid').addClass('hide');
						}

						if ($('#lastName').val() && $('#userEmail').val() && $('#firstName').val() && validEmail) {
							toggleBtnClass('#addRole', false);
						} else {
							toggleBtnClass('#addRole', true);
						}
					}
				});
			}
		});

		$(document).on('click', '.cancel-brand', function(event) {
			event.preventDefault();
			getConfirm(language_message.confirm_cancel,'','alert',function(confResponse) {
		        if(confResponse){
					var brand_id = $('#brand_id').val();
					if (brand_id != '') {
						$.ajax({
							'type': 'get',
							dataType: 'json',
							url: base_url + 'brands/delete/' + brand_id,
							success: function(response) {
								if (response.status != 'success') {
									getConfirm(language_message.try_again,'','alert',function(confResponse) {
										return false;
									});
								}
								else
								{
									window.location = base_url + 'brands/overview';
								}
							}
						});
					}
					else
					{
						window.location = base_url + 'brands/overview';
					}
				}
			});
		});

		$(document).on('keyup blur', '#newLabel', function() {
			var selected_tag = $('#selectedTags').children('ul').children('li');
			var add_flag = 1;
			var control = this;
			$.each(selected_tag, function(a, b) {
				//console.log($(control).val());
				//console.log($(b).data('value'));
				if ($(b).data('value') == $(control).val()) {
					add_flag = 0;
					$('#labelValid').removeClass('hide');
				}
			});

			if (add_flag == 1) {
				$('#labelValid').addClass('hide');
				if ($(this).val()) {
					toggleBtnClass('#addTag', false);
				}
			} else {
				toggleBtnClass('#addTag', true);
			}
		});

		$('#brandName').keyup(function() {
			if ($('#timezone').val() && $(this).val()) {
				toggleBtnClass('.save_brand', false);
			} else {
				toggleBtnClass('.save_brand', true);
			}
		});

		$('#timezone').change(function() {
			if ($(this).val() && $('#brandName').val()) {
				toggleBtnClass('.save_brand', false);
			} else {
				toggleBtnClass('.save_brand', true);
			}
		});

		$('.skip_step').click(function() {
			var slug = $('#slug').val();
			if (brand_id) {
				window.location.href = base_url + 'brands/success/' + slug;
			}
		});

		//save outlet to brand
		$(document).on('click', '#add-brand-details #save_outlet', function() {
			var control = this;
			var brand_id = $('#brand_id').val();
			var elements = $('.outlets');

			var outlet_ids = [];
			var social_media_keys = {};
			var i = 0;
			$.each(elements, function(i, value) {
				outlet_ids.push($(value).val());
				if ($(value).val()) {
					social_media_keys[$(value).val()] = $('#' + $(value).val()).val();
				}
			});

			var data = {
				'brand_id': brand_id,
				'outlets': outlet_ids
			};
			var post_data = {}
			$.extend(post_data, data, social_media_keys);

			if (plan_data.outlets == 'unlimited' || $('#selectedOutlets').children('ul').children('li').length <= plan_data.outlets) {
				$.ajax({
					url: base_url + 'brands/save_outlet',
					data: post_data,
					type: 'POST',
					dataType: 'json',
					success: function(data) {

						if (data.response == 'success') {
							$(control).parents().children('.btn-next-step').trigger('click');
							if (data.html) {
								$('#user-selected-outlet').html(data.html);
							} else {
								$('#user-selected-outlet').html('');
							}
						}
					}
				});
			} else {
				getConfirm(language_message.outlet_limit.replace('%outlet_number%', plan_data.outlets),'','alert',function(confResponse) {
					// alert(language_message.);
				});
			}
		});

		//save tags
		$(document).on('click', '.submit_tag', function() {
			var control = this;
			var brand_id = $('#brand_id').val();
			var slug = $('#slug').val();
			var selected_labels = $('.labels');

			var tags = [];
			$('input[name="selected_tags[]"]:checked').each(function(i) {
				tags[i] = this.value;
			});

			var labels = []
			$.each(selected_labels, function(i, value) {
				labels[i] = $(value).val();
			});

			if ($('#selectedTags').find('li').length <= plan_data.tags || plan_data.tags == 'unlimited') {
				$.ajax({
					url: base_url + 'brands/save_tags',
					data: {
						'brand_id': brand_id,
						'tags': tags,
						'labels': labels
					},
					type: 'POST',
					dataType: 'json',
					success: function(data) {

						if (data.response == 'success') {
							window.location.href = base_url + 'brands/success/' + slug;
						}
					}
				});
			} else {
				getConfirm(language_message.tag_limit.replace('%tag_number%', plan_data.tags),'','alert',function(confResponse) {
					// alert(language_message.tag_limit.replace('%tag_number%', plan_data.tags));
				});
				
			}
		});

		//step3 cancel btn
		$(document).on('click', '.btn-cancel', function() {
			$('#emailValid').addClass('hide');
			$('#nameValid').addClass('hide');
			$('#firstName').val('');
			$('#lastName').val('');
			$('#userTitle').val('');
			$('#userEmail').val('');
			$('#userOutlet').val('');
			$('#userRoleSelect').val('');
			$('#userSelect select').val('');
			$('#userRoleSelect').trigger('change');

			$('.user-img-preview').attr('src', base_url + 'assets/images/default_profile.jpg');
			$('.user_upload_img_div').html('');
			$('.user_upload_img_div').removeClass('has-files');
			var html = '<input id="userFile" class="form__file" type="file" data-multiple-caption="{count} files selected" name="files[]">';
			html += '<label id="userFileLabel" class="file-upload-label" for="userFile">Upload photo</label>';
			html += '<button class="form__button btn btn-sm btn-default" type="submit">Upload</button>';
			$('.user_upload_img_div').html('');
			$('.user_upload_img_div').html(html);
			$('.remove-user-img').hide();
			allFiles = [];
			$('.user-upload-img').hide();
			$('.user-img-preview').show();

			if ($('#userPermissionsList').children('.table').length) {
				toggleBtnClass('#add_user_next', false);
			} else {
				toggleBtnClass('#add_user_next', true);
			}
		});

		$('#firstName').keyup(function() {
			$('.user-name-role').html($(this).val() + ' ' + $('#lastName').val());
		});

		$('#lastName').keyup(function() {
			$('.user-name-role').html($('#firstName').val().toUpperCase() + ' ' + $(this).val().toUpperCase());
		});

		$(document).on('click', '[data-id="connect"]', function() {
			var outlet = $(this).data('outlet-const');
			var brand_id = $('#brand_id').val();
			if (brand_id) {
				var path = base_url + outlet.toLowerCase() + '_connect/' + outlet.toLowerCase() + '/' + brand_id + '/' + $(this).data('selected-outlet-id');
				if ($(this).hasClass('selected')) {
					$.oauthpopup({
						path: path,
						callback: function() {}
					});
				}
			}
		});

		
		$('body').on('click', '#userPermissionsList .remove-user', function(event) {
			event.preventDefault();
			// if(!($('#userPermissionsList .table').length > 1)){
			// 	return false;
			// }
			var aauth_user_id = $(this).data('user-id');
			getConfirm(language_message.delete_user,'', 'alert', function(confResponse) {
	            if(confResponse){
					
					$.ajax({
						url: base_url + 'brands/delete_user',
						type: 'POST',
						data: {
							'aauth_user_id': aauth_user_id
						},
						success: function(data) {
							if (data.trim() == 'success') {
								$('#table_id_' + aauth_user_id).fadeOut(function() {
									$('#table_id_' + aauth_user_id).remove();
								});
							} else {
								language_message.try_again;
							}
						}
					});
				}
			});
		});

		$(document).on('click', '.edit-user-permission', function(e) {
			var aauth_user_id = $(this).data('user-id');
			var brand_id = $(this).data('brand-id');
			validEmail = true;
			$('.addUserToBrand').addClass('editUserToBrand');
			$('.editUserToBrand').removeClass('addUserToBrand');
			$('.editUserToBrand').removeClass('Update');
			toggleBtnClass('.editUserToBrand', false);
			$('.editUserToBrand').text('Update');
			$('#user-select').attr('disabled', 'disabled');
			$('#addUserBtns .btn-cancel').addClass('disabled-drop-down');
			$('#userRoleBtns .btn-cancel').addClass('disabled-drop-down');
			// $('#user-select').val(aauth_user_id);
			toggleBtnClass('#addRole', false);
			$('#userSelect').slideUp(function() {
				$('#addUserInfo').slideDown(function() {
					equalColumns();
				});
			});
			$('#user-select option[value=' + aauth_user_id + ']').attr('selected', 'selected');
			var user_details, user_outlets, user_role;
			$.ajax({
				url: base_url + 'settings/get_user_info',
				type: 'POST',
				dataType: 'json',
				data: {
					'aauth_user_id': aauth_user_id,
					'brand_id': brand_id
				},
				success: function(response) {
					if (response.status == 'success') {
						user_details = response.result.user_details;
						user_outlets = response.result.user_outlets;
						user_role = response.result.user_role;
						var $hiddenInput = $('<input/>', {
							type: 'hidden',
							id: 'aauth_user_id',
							value: aauth_user_id
						});
						$('#addUserInfo').append($hiddenInput);
						$('#firstName').val(user_details.first_name);
						$('#lastName').val(user_details.last_name);
						$('#userTitle').val(user_details.title);
						$('#userEmail').val(user_details.email);
						$('#userEmail').attr('readonly', 'readonly');
						$('#userEmail').attr('disabled', 'disabled');
						$('#userOutlet').val('');

						$('#new_user_pic img').remove();
						$('#addNewUser .remove-user-img').addClass('hide');
						if (response.result.user_profile) {
							var dt = new Date();
							$('.user-img-preview').attr('src', response.result.user_profile);
							$('#new_user_pic').append('<img src="' + response.result.user_profile + '?' + Math.random() + '" >');
							$('#addNewUser .remove-user-img').removeClass('hide');
							$('#addNewUser .remove-user-img').show();
							$('#is_user_image').val('yes');
						} else {
							$('#is_user_image').val('no');
						}

						var newOutlets = [];
						if (user_outlets) {
							$.each($('#user-selected-outlet li'), function(i, element) {
								$.each(user_outlets, function(j, obj) {
									if ($(element).data('selected-outlet') == obj.id) {
										$(element).removeClass('disabled');
										$(element).addClass('selected');
										if ($.inArray(obj.id, newOutlets) === -1)
											newOutlets.push(obj.id);
									}
								});
							});
						}

						$('#userOutlet').val(newOutlets);
						validEmail = true;
						$('#userRoleSelect').val(user_role).trigger('change');

						// var $selected_rol = user_role+'Permissions';
						var selected_role = $('#userRoleSelect :selected').text();
						$.each($('#' + selected_role.toLowerCase() + 'Permissions').find('li'), function() {
							if ($.inArray($(this).find('i').attr('data-value'), response.result.user_permissions) != -1) {
								$(this).find('i').addClass('selected');
								$(this).find('input').attr('checked', 'checked');
								$(this).removeClass('hidden');
							} else {
								$(this).find('i').removeClass('selected');
								$(this).find('input').removeAttr('checked');
								$(this).addClass('hidden');
							}
						});
					}
				}
			});
		});

		$(document).on('click', '.disabled-drop-down', function(e) {
			$('#user-selected-outlet li').addClass('disabled');
			$('#user-selected-outlet li').removeClass('selected');
			$('#userEmail').removeAttr('readonly');
			setTimeout(function() {
				$('#aauth_user_id').remove();
				$('#user-select').removeAttr('disabled');
				$('#user-select').removeAttr('readonly');
				$('#userEmail').removeAttr('readonly');
				$('#userEmail').removeAttr('disabled');
				$('#userOutlet').val('');
				$('.editUserToBrand').text('Add');
				$('.addUserToBrand').removeClass('editUserToBrand');
				$('.editUserToBrand').addClass('addUserToBrand');
				$('#addUserBtns .btn-cancel').removeClass('disabled-drop-down');
				$('#userRoleBtns .btn-cancel').removeClass('disabled-drop-down');
			}, 200);
		});

		//add user to brand
		$(document).on('click', '.editUserToBrand', function(e) {
			var slug;
			if ($('#brand_slug').val() != undefined)
				slug = $('#brand_slug').val();

			var control = this;
			$('.user-upload-img').show();
			$('.user-img-preview').hide();
			// ajax file upload for modern browsers
			e.preventDefault();
			// gathering the form data
			var ajaxData = new FormData();
			var other_data = $('form').serializeArray();
			// ajax request
			var brand_id = $('#brand_id').val();
			var fname = $('#firstName').val();
			var lname = $('#lastName').val();
			var title = $('#userTitle').val();
			var email = $('#userEmail').val();
			var is_user_image = $('#is_user_image').val();
			var selectedOutlets = $('#userOutlet').val();
			var userRoleSelect = $('#userRoleSelect :selected').val();
			var selected_user = $('#aauth_user_id').val();
			var selectedPermissions = [];
			var image_name = '';
			var user_pic = '';
			if ($('#user_pic_base64').val() != '') {
				user_pic = $('#user_pic_base64').attr('value');
			}

			$('input[name="' + userRoleSelect + '-permissions[]"]:checked').each(function(i) {
				selectedPermissions[i] = this.value;
			});

			$.ajax({
				url: base_url + 'Settings/edit_user',
				type: 'POST',
				dataType: 'json',
				contentType: "application/x-www-form-urlencoded;charset=UTF-8",
				data: {
					'brand_id': brand_id,
					'first_name': fname,
					'last_name': lname,
					'title': title,
					'email': email,
					'outlets': selectedOutlets,
					'role': userRoleSelect,
					'permissions': selectedPermissions,
					'image_name': image_name,
					'file': user_pic,
					'user_id': selected_user,
					// 'slug' : slug,
					'is_user_image': is_user_image
				},
				success: function(data) {
					console.log(data);

					if (data.response == 'success') {
						if (data.html) {
							if ($('#userPermissionsList').children('#table_id_' + data.inserted_id).length) {
								$('#userPermissionsList').children('#table_id_' + data.inserted_id).empty();
								$('#userPermissionsList').children('#table_id_' + data.inserted_id).html(data.html);
							}
							$('#userRoleBtns .btn-cancel').trigger('click');
						} else {
							$('.close_brand').trigger('click');
						}
					} else {
						// alert(language_message.try_again);
						getConfirm(language_message.try_again,'','alert',function(confResponse) {
							$('.close_brand').trigger('click');
						});
					}
				}
			});
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

	function validateEmail(email) {
		var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
		return re.test(email);
	}

	function nextStep(i) {
		if (i == 1) {
			if ($('.brand-image').children('.default-img').length) {
				$('.brand-image').children('.default-img').remove();
				$('.brand-image').removeClass('has-files');
			}
		}

		$('.brand-step').removeClass('active').addClass('inactive');
		$('#brandStep' + i).removeClass('inactive').addClass('active');
	}

	function hideNoLength(obj) {
		var numSelected = $(obj).find('li').length;
		if (numSelected < 1) {
			$(obj).hide();
		}
	}

});