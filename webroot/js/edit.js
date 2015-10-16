/* 
 * Copyright 2015 Origami Structures
 */

$(document).ready(function(){
    updateTaskList();
})

function updateTaskList(){
    var project_id = $('select#project-id').val();
    //    <select id="task-id" name="task_id"><option value=""></option><option value="16">MenuRefactor</option><option value="17">ProductPurchase</option>
    
    var list = tasks[project_id];
    var select = '<option value=""></option>\n';
    for (key in list){
        select += '<option value="' + key + '">' + list[key] + '</option>';
    }
    x=y;
}