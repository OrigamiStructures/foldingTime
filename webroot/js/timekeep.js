$(document).ready(function () {
})
function OutNow(e) {
    e.preventDefault();
    var d = new Date();
    var monthstring = (parseInt(d.getMonth()) + 1).valueOf();
    var month = ('0' + monthstring).substr(-2);
    var day = ('0' + d.getDate()).substr(-2);
    var dstring = d.getFullYear() + '-' + month + '-' + day + ' ' + d.toLocaleTimeString();
    alert(d);
    $(this).parents('form').find('#TimeTimeOut').attr('value', dstring);
}

function AdjustSelect(e) {
    //Get curr datetime
    var d = new Date();
    //set variable for users adjustment selection
    var adj = parseInt($(this).val());
    //Adjust per parameters
    var dadj = d.setMinutes(d.getMinutes() + adj);
    //Set new value to d

    //Reformat for output
    var monthstring = (parseInt(d.getMonth()) + 1).valueOf();
    var month = ('0' + monthstring).substr(-2);
    var day = ('0' + d.getDate()).substr(-2);
    var dstring = d.getFullYear() + '-' + month + '-' + day + ' ' + d.toLocaleTimeString();
//            alert(dadj);
    $(this).parents('form').find('#TimeTimeOut').attr('value', dstring);
}

function timeChange(e, action) {
    var id = $(e.currentTarget).attr('index');
    $.ajax({
        type: "GET",
        url: webroot + controller + action + "/" + id,
        dataType: "JSON",
        success: function (data) {
            if (data.success) {
                replaceRow(data.result, id);
            } else {
                $('#flash_message').html(data.result);
            }
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });
}

function timeStop(e) {
    e.preventDefault();
    timeChange(e, 'timeStop');
}

function timePause(e) {
    e.preventDefault();
    timeChange(e, 'timePause');
}

function timeRestart(e) {
    e.preventDefault();
    timeChange(e, 'timeRestart');
}

function timeReopen(e) {
    e.preventDefault();
    timeChange(e, 'timeRestart');
}

function timeDelete(e) {
    e.preventDefault();
    var id = $(e.currentTarget).attr('index');
    var c = confirm('Are you sure you want to delete this time record?');
    if (!c) {
        return;
    }
    $.ajax({
        type: "POST",
        url: webroot + controller + "deleteActivityRow/" + id,
        dataType: "JSON",
        success: function (data) {
            if (data.success) {
                $('#row_' + id).remove();
            } else {
                alert('The deletion failed, please try again.');
            }
        },
        error: function () {
            alert('Error deleting the time row.')
        }
    });
}

function newTime(e) {
    e.preventDefault();

}

function timeInfo(e) {
    e.preventDefault();
    var target = e.currentTarget;
    var id = $(target).attr('index');
    $.ajax({
        type: "GET",
        dataType: "HTML",
        url: webroot + controller + 'edit/' + id + '/true',
        success: function (data) {
            $('div.times.form').remove();
            $(target).parents('td').prepend(data);
            bindHandlers('div.times.form');
            $('div.times.form').draggable();
        },
        error: function (data) {
            alert('There was an error on the server. Please try again');
        }
    })
}

function cancelTimeEdit(e) {
    e.stopPropagation();
    $('div.times.form').remove();
}

function saveTimeEdit(e) {
    e.preventDefault();
    e.stopPropagation();
    var id = $(e.currentTarget).attr('index');
//	var formData = $('form#TimeEditForm').serialize();
    $.ajax({
        type: "PUT",
        dataType: "HTML",
        data: $('form#TimeEditForm').serialize(),
        url: $('form#TimeEditForm').attr('action'),
        success: function (data) {
            if (data.match(/<tr/) != null) {
                replaceRow(data, id);
            } else {
                $('div.times form').prepend(data);
            }
        },
        error: function (data) {
            alert('failure');
        }
    })
}

/**
 * Replace the row contents with returned row
 */
function replaceRow(data, id) {
    $('#row_' + id).replaceWith(data);
    bindHandlers('#row_' + id);
}

/**
 * Set the default project for new time entries
 */
function setDefaultProject() {
    e.preventDefault();
    alert('Set default project');
}

/**
 * Create a new row for time keeping
 */
function newTimeRow(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: webroot + controller + "newTimeRow",
        dataType: "html",
        success: function (data) {
            $('#TimeTrackForm tbody').append(data);
            updateTableClassing();
            updateTableSortability();
            bindHandlers('table.sortable tr.last');
            initToggles();
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });

}

/**
 * Update table classing for kickstart after AJAX insertion
 */
function updateTableClassing() {
    var rows = $('table.sortable').find('tbody tr');
    rows.removeClass('alt first last');
    var table = $('table.sortable');
    table.find('tr:even').addClass('alt');
    table.find('tr:first').addClass('first');
    table.find('tr:last').addClass('last');

}

/**
 * Update sortability on AJAX inserted row
 */
function updateTableSortability() {
    $(this).find('table.sortable tr.last th,td').each(function () {
        $(this).attr('value', $(this).text());
    });
}

/**
 * Save a single field change on the timekeeping form
 */
function saveField(e) {
    e.stopPropagation();
    var id = $(e.currentTarget).attr('index');
    var fieldName = $(e.currentTarget).attr('fieldName');
    var value = $(e.currentTarget).val();
    var postData = {'id': id, 'fieldName': fieldName, 'value': value};
    $.ajax({
        type: "POST",
        url: webroot + controller + "saveField",
        data: postData,
        dataType: "JSON",
        success: function (data) {
			if (fieldName == 'project_id') {
				location.replace(location.href);
			}
            if (fieldName == 'duration') {
                $('#' + id + 'duration').html(data.duration)
                if ($('#'+id+'TimeDuration').css('display') != 'none') {
                    $('#' + id + 'duration').trigger('click');
                }
            }
            updateTableClassing();
            updateTableSortability();
            bindHandlers('table.sortable tr.last');
        },
        error: function () {
            alert('Error adding the time row.')
        }
    });

}
/**
 * Hide the duration input on blur
 */
function hideDurationInput(e) {
    e.stopPropagation();
    var id = $(e.currentTarget).attr('index');
    if($(e.currentTarget).css('display') != 'none'){
        $('#' + id + 'duration').trigger('click');
    }
	
}

	/**
	 * Handle request to create a new task for a project
	 * 
	 * When the task "New task" is selected, prompt the 
	 * ust for the new task, then save and set it.
	 * 
	 * @param {event} e
	 */
	function taskChoice(e) {
		if ($(e.currentTarget).val() === 'newtask') {
			var task = window.prompt('Enter the new task.');
			if (task != null) {
				var proj = $(e.currentTarget).attr('project_id');
				if (proj == '' || typeof(proj) == 'undefined') {
					alert('You can\'t make new tasks until you specify a project.');
				} else {
				$.ajax({
					type: "POST",
					dataType: "HTML",
					data: {Task : {project_id: proj, name: task}},
					url: webroot+'tasks/add',
					success: function (data) {
						if(data.match(/could not/) != 'could not') {
							location.replace(location.href);
						} else {
							alert('The new task was not saved.');
						}
					},
					error: function (data) {
						alert('ajax failure');
					}
				})

				}
			}
		} else {
			saveField(e);
		}
	}
	
	function plus(e) {
		var delta = 20;
		changeSize(e, delta);
	}
	
	function minus(e) {
		var delta = -20
		changeSize(e, delta);
	}
	
	function changeSize(e, delta) {
		var targets = $('textarea[id*="TimeActivity"]');
		var axis = $(e.currentTarget).hasClass('height') ? 'height' : 'width';
		var start_size = parseInt($(targets[0]).css(axis));
		$(targets).css(axis, start_size + delta);
	}

	function timeDuplicate(e) {
		var id = $(e.currentTarget).attr('index');
		var prompt = window.prompt("New Activity Description", $('div#row_'+ id +' p.activity span.full_text').html());

		if (prompt) {
			e.preventDefault();
			$.ajax({
				type: "POST",
				url: webroot + controller + "duplicateActivityRow/" + id,
				data: {'activity': prompt},
				dataType: "JSON",
				success: function (data) {
					if (data.success) {
						$('section.records').prepend(data.result);
						bindHandlers('div.activities');
					} else {
						$('#flash_message').html(data.result);
					}
				},
				error: function () {
					alert('Error adding the time row.')
				}
			});
		}
	}