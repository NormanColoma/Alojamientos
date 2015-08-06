$(document).ready(function () {
    $(".add-task").click(function () {
        createTask()
    })
})

$(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            }
        });
});

function createTask(){
	var text = $(".task-text").val()
	
	var task = { name: text}

	//var data = JSON.stringify(task);
	var port = location.port;
    var uri = "http://localhost:" + port + "/laravel_example/api/task";

	$.post(uri,{name: text})  // If you need to stringify, you will pass data:stingyifyed_var
		.done(function( data ) {
    		addTask(data);
    });

	/* post form via ajax
	$.ajax({
	     type: "POST",
	     url: uri,
	     data: $("#myForm").serialize(),
	     success: function(data) {
	          alert(data);
	     }
	});
	*/
}

function addTask(task){
	var new_task = "<li>"+task.name+"<div class='delete-icon'><span class='glyphicon glyphicon-trash' id='"+task.id+"'></span></div></li>";
	$(".task-list").append(new_task);
}