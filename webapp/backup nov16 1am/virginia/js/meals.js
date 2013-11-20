window.onload = function() {
	//set the current day to the date in the url
	var currentDay = getUrlVars()['date'];
	
	//if there is no date in the url, set the date to today
	if(currentDay == null) {
		currentDay = parseInt(getToday().getTime());
	}
	
	//add the date we're currently dealing with to the urls of the links
	addDateToLinks(currentDay);
	
	$( ".dininghalllink" ).click(function() {
	  var loc = this.innerHTML;
	  if($('a[title="'+loc+'"]').parent().parent().hasClass('showfood')) {
		  $('a[title="'+loc+'"]').parent().parent().hasClass('showfood');
	  }
	  else {
		  $('.food').removeClass("showfood");
		  $('.food').removeClass("selectedfood");
		  $('.foodp a').removeClass('selectedfood');
		  $('a[title="'+loc+'"]').parent().parent().addClass('showfood');
		  return false;
	  }
	});
	
	alert('test');
	
	$('.foodp a').click(function(e) {
	  alert('hello');
	  //e.preventDefault();
	  //if($(this).hasClass('selectedfood')) {
	//	$(this).removeClass('selectedfood');
	  //}
	  //else {
	   	//$(this).addClass('selectedfood');
	  //}
	  return false;
	});
	
	/*
	$( ".foodlink" ).click(function() {	  
	  $('.foodp a').click(function(e) {
	    e.preventDefault();
	    if($(this).hasClass('selectedfood')) {
		    $(this).removeClass('selectedfood');
	    }
	    else {
	    	$(this).addClass('selectedfood');
	    }
	  });
	  
	  return false;
	});
	*/
}

//add the date we're currently dealing with to the urls of the find meal links
function addDateToLinks(currentDay) {
	var links = document.getElementsByClassName('dininghalllink');
	for(var i=0; i < links.length; i++) {
		links[i].href = links[i].href.concat("&date=", currentDay);
	}
}