/* 
 * Copyright 2015 Origami Structures
 */

$(document).ready(function(){
    updateTaskList();
})

function updateTaskList(){
    var project_id = $('select#project-id').val();
    var task_id = $('select#task-id').val();
    //    <select id="task-id" name="task_id"><option value=""></option><option value="16">MenuRefactor</option><option value="17">ProductPurchase</option>
    
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