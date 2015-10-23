/* 
 * Copyright 2015 Origami Structures
 */

$(document).ready(function(){
    updateTaskList();
    updateNewTaskButton();
    updateNewProjectButton();
})

function chooseProject(){
    updateTaskList();
    updateNewTaskButton();
    updateNewProjectButton();
}

function updateTaskList(){
    var project_id = $('select#project-id').val();
    var task_id = $('select#task-id').val();
    
    if (project_id != "") {
        var list = tasks[project_id];
        var select = '<option value=""></option>\n';
        var curr_val = $('select#task-id').val();
        for (key in list) {
            if (key == task_id) {
                select += '<option selected="selected" value="' + key + '">' + list[key] + '</option>\n';
            } else {
                select += '<option value="' + key + '">' + list[key] + '</option>\n';
            }       
        }
        $('select#task-id').html(select);
    }
}

function updateNewTaskButton(){
    var replacement = '/tasks/add/' + $('select#project-id').val() + '/1'; 
    $('li.newTaskButton a').attr('href', replacement);
}

function updateNewProjectButton(){
    var replacement = '/projects/add/' + $('select#project-id').val() + '/1'; 
    $('li.newProjectButton a').attr('href', replacement);
}