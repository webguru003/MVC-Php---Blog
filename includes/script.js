/**
 * javascript/jquery script.php
 *
 * @author Hameed Ullah Khan - hameed.customphp@gmail.com
 * @version 1.0
 * @date August 13, 2017
 */
 
 $(document).ready(function(){
	
	/* This flag will prevent multiple comment submits: */
	var working = false;
	
	/* Listening for the submit event of the form: */
	$('#addCommentForm').submit(function(e){
	
 		e.preventDefault();
		if(working) return false;
		
		working = true;
		$('#submit').val('Working..');
		$('span.error').remove();
		
		/* Sending the form fileds to /post/addComment: */
		
		$.post($('#url').val()+'/post/addComment',$(this).serialize(),function(msg){

			working = false;
			$('#submit').val('Submit');
			
			if(msg.status){
				$('#not_exist').hide();
				$(msg.html).hide().insertBefore('#Container').slideDown();
				$('#message').val('');
			}
			else {

				/**
				*	If there were errors, loop through the
				*	msg.errors object and display them on the page 
				*/
				
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');

	});
	
	$('#addPostForm').submit(function(e){
 		 if ($('input#website').val().length != 0) {
			return false; 
        } 
		
		e.preventDefault();
		if(working) return false;
		
		
		
		working = true;
		$('#submit').val('Working..');
		$('span.error').remove();
		/* Sending the form fileds to /post/addPost/: */
		$.post($('#url').val()+'/post/addPost',$(this).serialize(),function(msg){
		console.log("output : "+msg); 
			working = false;
			$('#submit').val('Submit');
			
			if(msg.status){
				$('#not_exist').hide();
				$(msg.html).hide().insertAfter('#comments').slideDown();
				$('#message').val('');
			}
			else {

				/**
				*	If there were errors, loop through the
				*	msg.errors object and display them on the page 
				*/
				
				$.each(msg.errors,function(k,v){
					$('label[for='+k+']').append('<span class="error">'+v+'</span>');
				});
			}
		},'json');

	});
	
});