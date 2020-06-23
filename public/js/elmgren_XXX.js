var updated = "Senast uppdaterad 2018-06-27;
var input = "";

$( document ).ready( function() {    
	$("#updated").text(updated); // Down right on page
	//********************************************** Birthdays *********************************************
	var monthsArr = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
	var monthShown = [0,0,0,0,0,0,0,0,0,0,0,0]; // Array of flags to see if month already has been printed to screen
	var txt = "";
	var updateLogData = "";
	var month;
	var date;
	var person;
	
	$.get('birthdays.txt', function(data) {
			input = data.split('\n'); //input from file is split into array input[]
	});
	
	$("#photosThisYear").on("click", function(){
		$.fancybox.open();
	});

	// Close jumbotron if clicked
	$(".jumbotron, .glyphicon-remove").click(function(){ //The function part is a callback. Waits for fadeout to finish before removing width
    	$(this).fadeOut(function(){
			$(this).css("width", ""); //Remove width attribute
		});
  	});

	//*********************** Emails *****************************
	// Have to use * because emails is added dynamically
	$("*").on("click", "a#emails", function(){
		$(".jumbotron").css("width", "425px");
		$(".jumbotron").html('<span class="glyphicon glyphicon-remove close-jumbo" aria-hidden="true"></span>'); // Close cross
		$(".jumbotron").append("<h3>Emailadresser</h3>");
		$(".jumbotron").append('<br><br>Stefan Elmgren <a href="mailto:stefan@elmgren.nu">stefan@elmgren.nu</a><br>');
		$(".jumbotron").append('Daniel Elmgren <a href="mailto:daniel@elmgren.nu">daniel@elmgren.nu</a><br>');
		$(".jumbotron").append('Karin Elmquist <a href="mailto:karin.elmquist@chello.se">karin.elmquist@chello.se</a><br>');
		$(".jumbotron").append('Jessica Elmgren <a href="mailto:jessica@elmgren.nu">jessica@elmgren.nu</a><br>');
		$(".jumbotron").append('Mikael Sjöblom <a href="mailto:micke@elmgren.nu">micke@elmgren.nu</a><br>');
		$(".jumbotron").append('Boine Elmgren <a href="mailto:boine@elmgren.nu">boine@elmgren.nu</a><br>');
		$(".jumbotron").fadeIn();
	});
	
	//******************** Birthdays ***********************
	// Have to use * because emails is added dynamically
	$("*").on("click", "a#birthdays", function(){
		if(txt == ""){													
			for (i = 0; i < input.length; i++) {
				month = input[i].substr(0,2); //Extract month number
				date = input[i].substr(3,2); //Extract date number
				person = input[i].substr(6); //Extract person
				
				if(monthShown[month-1] == 0 ){
					txt += "<br><b>" + monthsArr[month-1] + "</b><br>";
					monthShown[month-1] = 1; //Set flag
				} 
				
				txt += "&nbsp" + date + " " + person + "<br>";
			} // For loop end 
		}
		
		$(".jumbotron").css("width", "350px");
		$(".jumbotron").html('<span class="glyphicon glyphicon-remove close-jumbo" aria-hidden="true"></span>'); // The close cross
		$(".jumbotron").append("<h3>Födelsedagar</h3>");
		$(".jumbotron").append("<br>");
		$(".jumbotron").append(txt);
		$(".jumbotron").fadeIn();
	});
	
	//******************** Update log ***********************
	// Have to use * because emails is added dynamically
	$("*").one("click", "a#updateLog", function(){
		$("*").off("click", "a#updateLog"); // Removes event handler.
		$(".jumbotron").css("width", "50%");
		$(".jumbotron").html('<span class="glyphicon glyphicon-remove close-jumbo" aria-hidden="true"></span>'); // The close cross
		$(".jumbotron").append("<h3>Uppdateringslogg</h3>");
		$(".jumbotron").append("<br>");
		
		$.get('uppdateringslogg.txt', function(updateLogData) {
			$updateLogDataLength = updateLogData.length;
			$(".jumbotron").append(updateLogData);
		}, 'text');
		
		$(".jumbotron").fadeIn();
	});
	
	//Dropdown effect on foton
	$('.dropdown').on('show.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).slideDown();
     });
      
	 $('.dropdown').on('hide.bs.dropdown', function(e){
		$(this).find('.dropdown-menu').first().stop(true, true).slideUp("fast");
     });
	
});


