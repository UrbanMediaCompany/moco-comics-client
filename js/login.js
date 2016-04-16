$(document).ready(function(){
    $("#login").submit(function(event) {
	 	event.preventDefault();
		$.ajax({ type: "POST", url: "deploy.php", data: $("#login").serialize(),
				success: function(data){
					window.location.replace("admin");
				}
		});
		return false;
    });

    $(".settings").click(function(){
        window.location.replace("mailto:soporte@codify.mx");
    });
});