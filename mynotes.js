//ajax 

$(function(){
	//define vars
	//load notes : ajax call to loadnots.php file
	$.ajax({
		url: "loadnotes.php",
		success: function(data){
			$("#notes").html(data);
		}
		 
	});


	//add new note button : ajax call to create note createnote.php
	$('#addNote').click(function(){
		var activeNote = 0;// note that we are editing
		$.ajax({
			url:'createnote.php',
			success:function(data) {
				if(data == "error"){
					$('#alertContent').text("There was an issue inserting the new note in the database!");
					$('#alert').fadeIn();	
				
				}else {
					//update activeNote to the id of newNote
					activeNote = data;
					$('#textarea').val("");
					//show hide elements
					showHide(['#notepad','#allNotes'], ['#notes','#addNote','#edit','#done']);
					//focus on text area
					$('textarea').focus();


				}
			}
		});
	});
	//typing note : ajax call fileupdate.note
	//click on all notes button
	//click on done after editing...load notes again
	//click on edit button go to edit mode -> show delete buttons, reduce the width
	
	//functions
		//click on a note
		//click on delete





		//show hide function
		function showHide(array1, array2){
			//array id of elements to show array2 id to hide
			for(var i=0 ; i<array1.length; i++){
				$(array1[i]).show();
			}
			for(var i=0 ; i<array2.length; i++){
				$(array2[i]).hide();
			}
		}
});