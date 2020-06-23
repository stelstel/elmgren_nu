//var updated = "Senast uppdaterad 2018-09-25";
var input = "";

$( document ).ready( function() {    
	//$("#updated").text(updated); // Down right
	//********************************************** Birthdays ********************************************* TABORT?
	var monthsArr = ["Januari", "Februari", "Mars", "April", "Maj", "Juni", "Juli", "Augusti", "September", "Oktober", "November", "December"];
	var monthShown = [0,0,0,0,0,0,0,0,0,0,0,0]; // Array of flags to see if month already has been printed to screen
	var txt = "";
	var updateLogData = "";
	var month;
	var date;
	var person;

	// $('.dropdown-item').on("select", function() { // ?????????????????????????????????? //////////////
	// 	//console.log("selected"); ////////////////////////////////////
	// 	alert("debug");
	// 	//$(".form-inline").submit();
	// 	//$('#btnSearch').trigger( "click" );
	// });

	$("#photosThisYear").on("click", function(){
		$.fancybox.open();
	});

	// Close jumbotron if clicked
	$(".jumbotron, .glyphicon-remove").click(function(){ //The function part is a callback. Waits for fadeout to finish before removing width
    	$(this).fadeOut(function(){
			$(this).css("width", ""); //Remove width attribute
		});
  	});

	//*********************** Emails ***************************** TABORT?
	// Have to use * because emails is added dynamically
	$("*").on("click", "a#emails", function(){
		
		if( $(window).width() >= 768 ) { // Wide
    		$(".jumbotron").css("width", "425px");
		} else { // Mobile
    		$(".jumbotron").css("width", "90%");
    		$(".jumbotron").css("left", "5%");
		}
		
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
	
	$('#btn-closeupdate-log').on('click', function(e){
		$('#collapseUpdateLog').collapse('hide');
	});

	// Added 2018-11-20 1204
	$(".gallery").eq(0).trigger("click"); // Funkar med year och search slides

	// *********************************** Parallex top image effect START **************************
	// Jake Lundberg, https://codepen.io/iamtheWraith/
	
	$bgTopSize = 100; // %
	$heroH1Top = $(".hero h1").css("top");

	$(window).on('scroll', function() {
		if($(window).scrollTop() < 1000) {
			$('.hero').css('background-size', $bgTopSize + parseInt($(window).scrollTop() / 5) + '%');
			$('.hero h1').css('top', $heroH1Top + ( $(window).scrollTop() * .029 ) + 'vh');
			$('.hero h1').css('opacity', 1 - ($(window).scrollTop() * .003));
		}
	});
	// *********************************** Parallex top image effect END ****************************

	// ********************************* Birthday scrolling reminder START *****************************
	// Added 2018-12-01
	$topStartValue = parseInt($('#birthdayReminder').css('top'), 10);
	$topValue = $topStartValue;
	$scrollCounter = 0;
	$maxScrolls = 10;
	$timeBetweenScrolls = 15000;
	$timeBetweenTextMove = 10;
	var repeatVar = setInterval(repeatTimer, $timeBetweenScrolls);
	
	function repeatTimer() {
		if ($('#birthdayReminder').text().length > 0) { // If there is any text to show	
			$scrollCounter += 1;
			var scrollVar = setInterval(scrollTimer, $timeBetweenTextMove); //Time between text moving up

			function scrollTimer() {
				$topValue -= 1;
			    $('#birthdayReminder').css( 'top', $topValue + 'px' );
		
				if ( $topValue < -1000) { // Stop if out of sight above screen
					clearInterval(scrollVar);
					$topValue = $topStartValue
				}
			}

			// Stop showing message
			if ($scrollCounter >= $maxScrolls) {
				clearInterval(repeatVar);
				clearInterval(scrollVar);
			}
		}
	}
	// ********************************** Birthday scrolling reminder END *****************************

	$typeaheadTxt = "";

	$('#search-foton').on('change', function () {
		if ($typeaheadTxt !== $('#search-foton').typeahead().text() ) { // Old input
			$typeaheadTxt = $('#search-foton').typeahead().text(); // The latest input
		}else{
			$typeaheadTxt = "";	
		}
		
    	if ($typeaheadTxt.length > 0) {
    		console.log("<br>1: " + $typeaheadTxt ) ;
    		$( "#btnSearch" ).trigger( "click" );
    	}
	});

}); // End of document ready

// Added 2018-11-20 1204
$('.open-album').click(function(e) {
    var el, id = $(this).data('open-id');
    var indx = $(this).data('index');

    if(id){
        el = $('.image-show[rel=' + id + ']:eq(' + indx + ')');
        e.preventDefault();
        el.click();
    }
});

// Added 2018-11-20 1211
// Not sure why but this is needed. Maybe a modal is hidden by default. Bootstrap modal
$("#msg-to-user-modal").modal('show'); 

// Typeahead. Added 2018-11-25 ******************************************************** START
var path =  "/public/search";
var typeAheadStrings = [];

$('#search-foton').typeahead({
    minLength: 2,
    source:  function (query, process) {
    	return $.get(path, { query: query }, function (data) {

            function stelUnique(array){
                return $.grep(array,function(el,index){
                    return index == $.inArray(el,array);
                });
            }
           
            for (var i = 0; i < data.length; i++) {
				if (data[i].noshow != 1) {
					if (data[i].tags) {
						data[i] = data[i].tags;

						// Remove the commas
						while(data[i].indexOf(",") > -1){ 
							data[i] = data[i].replace(",", "");
						}

						// Remove the dots
						while(data[i].indexOf(".") > -1){ 
							data[i] = data[i].replace(".", "");
						}

						// Remove the "och"
						while(data[i].indexOf("och") > -1){ 
							data[i] = data[i].replace("och", "");
						}

						// Split the string into words
						dataParts = data[i].split(" ");

						// Add the words to array, in lowercase
						for (var j = 0; j < dataParts.length; j++) {
						 	typeAheadStrings.push(dataParts[j].toLowerCase() );
						}
	            	}
	            }
            }

            typeAheadStrings.sort();
            typeAheadStrings = stelUnique( typeAheadStrings ); // Get rid of duplicates

            return process(typeAheadStrings);
        });
    }
});

// Typeahead. Added 2018-11-25 ******************************************************** END