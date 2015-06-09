function checkPass() {
	var p1 = $("#pass").val();
	var p2 = $("#cpass").val();
	if( p1.length > 0 && p2.length > 0 ) {
		$("#match").text( p1 != p2 ? "Passwords don't match." : "");
	} 
	return (p1 != p2 ? "Passwords don't match." : "");
}

$(document).ready(function() {
	$("#prompt").hide();
	$("#pass").on('input',checkPass);
	$("#cpass").on('input',checkPass);
	
	$("#uname").on('input',function() {
		if( $("#uname").val().length > 0 ) {
			$.ajax({
				url : "includes/controller.php",
				method : "POST",
				data : {
					'request' : 'username',
					'uname' : $("#uname").val()
				},
				success : function(a) {
					a = a == 'true';
					$("#taken").text( a ? "Username is taken" : "" );
				} 
			});
		} else {
			$("#taken").text("");
		}
	});
	
	$("#luname").on('input',function() {
		if( $("#luname").val().length > 0 ) {
			$.ajax({
				url : "includes/controller.php",
				method : "POST",
				data : {
					'request' : 'username',
					'uname' : $("#luname").val()
				},
				success : function(a) {
					a = a != 'true';
					$("#exists").text( a ? "Username is not regis" 
										+ "tered" : "" );
				} 
			});
		} else {
			$("#exists").text("");
		}
	});
	
	$("form#register").submit(function() {
		var errors = $("#taken").text();
		errors += (errors.length == 0 ? "" : "<br />") 
					+ $("#match").text();

		if( errors.length != 0 ) {
			$("#promptContent").html(errors);
			$("#prompt").show(500);
			return false;
		} else {
			return true;
		}
	});

	$("form#login").submit(function() {
		var errors = $("#exists").text();

		if( errors.length != 0 ) {
			$("#promptContent").html(errors);
			$("#prompt").show(500);
			return false;
		} else {
			return true;
		}
	});

	$("#ok").click(function() {
		$("#prompt").hide(500);
	});
});