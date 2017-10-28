var imageTag = {
	mouseX : 0,
	mouseY : 0,
	top_position : 0,
	left_position : 0,
	label : null,
	outline_width : 106,
	outline_height : 106,
	tooltip_width_padding : 40,
	tooltip_height_padding : 8,
	tag_container : '<div class="outline"></div><div class="tools"><label class="label">Type name</label><input type="text" name="tag-name" id="tag-name" class="field" /><a href="#" id="saveTag" class="button button_green mr_r4">Save</a><a href="#" id="cancelTag" class="button button_red">Cancel</a></div>',
	image_wrapper : $('#image'),
	createDialog : function(e) {
		
		// get position of the mouse when the click event was triggered
		this.mouseX = e.pageX - this.image_wrapper.offset().left;
		this.mouseY = e.pageY - this.image_wrapper.offset().top;
		
		// remove any existing tag-containers
		this.removeDialog();
		
		this.image_wrapper.append(this.tag_container);
		
		this.mouseY = this.mouseY - (this.outline_height / 2);
		this.mouseX = this.mouseX - (this.outline_width / 2);
		
		$('.outline').css({ top : this.mouseY, left : this.mouseX });
		$('.tools').css({ top : this.mouseY + this.outline_height, left : this.mouseX - 22 });
		
		$('.outline').draggable({
			containment: imageTag.image_wrapper,
			scroll: false,
			cursor: 'pointer',
			drag : function(event, ui) {
				$('.tools').css({ top : ui.position.top + imageTag.outline_height, left : ui.position.left - 22 });
				$('.outline').css('border', 'solid 3px #982560');
			},
			stop : function(event, ui) {
				var pos = ui.position;
				imageTag.mouseX = pos.left;
				imageTag.mouseY = pos.top;
				$('.outline').css('border', 'solid 3px #fff');
			}
		});
		
		$('#tag-name').focus();
		
	},
	removeDialog : function() {
		$('.outline').remove();
		$('.tools').remove();
	},
	saveTag : function() {
		
		this.label = $('#tag-name').val();
		
		if (this.label !== '') {
		
			// add outline and tooltip to the image
			var divs = '<div class="tag-outline" id="view"> </div>';
			divs += '<div class="tag-tooltip" id="tooltip_view">'+this.label+'</div>';
			
			$('#image').append(divs);
			
			// amend the position of the view
			$('#view').css({ top : this.mouseY, left : this.mouseX });
			
			// get new element's width and height together with their padding
			var tooltip_width = $('#tooltip_view').width() + 
				this.tooltip_width_padding;
			var tooltip_height = $('#tooltip_view').height() + 
				this.tooltip_height_padding;
				
			this.top_position = this.mouseY + (this.outline_height / 2) -
				parseInt((tooltip_height / 2), 10);
			this.left_position = this.mouseX + (this.outline_width / 2) -
				parseInt((tooltip_width / 2), 10);
				
			this.saveRecord();
					
		}		
		
	},
	saveRecord : function() {
		var id = $('#image_id').text();
		$.getJSON('/mod/add-tag.php', {
			id : id,
			label : imageTag.label,
			view_top : imageTag.mouseY,
			view_left : imageTag.mouseX,
			tooltip_top : imageTag.top_position,
			tooltip_left : imageTag.left_position
		}, function(data) {
			
			if (!data.error) {
				
				$('#view').replaceWith(data.div_view);
				$('#tooltip_view').replaceWith(data.div_tooltip);
				$('#tags').append(data.span_link);
				
				imageTag.removeDialog();
				
			}
			
		});
	},
	removeDialog : function() {
		$('.outline').remove();
		$('.tools').remove();
	},
	showOutline : function(obj, event) {
		var id = obj.attr("class");
		if (event.type == 'mouseover') {
			$('#' + id).addClass('link');
		} else {
			$('#' + id).removeClass('link');
		}
	},
	showTooltip : function(obj, event) {
		var id = obj.attr("id");
		if (event.type == 'mouseover') {
			$('#tooltip_' + id).addClass('hover');
		} else {
			$('#tooltip_' + id).removeClass('hover');
		}
	},
	removeTag : function(obj) {
		var identity = obj.parent().attr('class');
		var id = identity.split('_');
		$.getJSON('/mod/remove-tag.php', { id : id[1] }, function(data) {
			if (!data.error) {
				obj.parent().fadeOut(300, function() {
					$('#'+identity).remove();
					$('#tooltip_'+identity).remove();
				});
			}
		});
	},
	removeImage : function(obj) {
		var id = obj.attr('rel');
		$.getJSON('/mod/remove-image.php', { id : id }, function(data) {
			if (!data.error) {
				obj.parent('div').fadeOut(300, function() {
					$(this).remove();
				});
			}
		});
	}
}
$(function() {

	$('#form_upload').live('submit', function() {
		$(this).find('.loader').prev('input').hide();
		$(this).find('.loader').show();
	});
	
	
	$('#image img').live('click', function(e) {
		imageTag.createDialog(e);
	});
	
	$('#saveTag').live('click', function() {
		imageTag.saveTag();
		return false;
	});
	
	$('#tag-name').live('keypress', function(e) {
		if (e.which == 13) {
			imageTag.saveTag();
			return false;
		}
	});
	
	
	$('#tags span').live('mouseover mouseout', function(event) {
		imageTag.showOutline($(this), event);
	});
	
	
	$('.tag-outline').live('mouseover mouseout', function(event) {
		imageTag.showTooltip($(this), event);
	});
	
	$('#tags a.remove').live('click', function() {
		imageTag.removeTag($(this));
		return false;
	});
	
	$('#cancelTag').live('click', function() {
		imageTag.removeDialog();
		return false;
	});
	
	$('.remove_image').live('click', function() {
		imageTag.removeImage($(this));
		return false;
	});

});




