window.onload = function() {
	//set the current day to the date in the url
	var currentDay = getUrlVars()['date'];
	var mealnum = getUrlVars()['mealnum'];
	
	//if there is no date in the url, set the date to today
	if(currentDay == null) {
		currentDay = parseInt(getToday().getTime());
	}
	
	//add the date we're currently dealing with to the urls of the links
	addDateToLinks(currentDay);
	
	processLocationClicks();
	 
	processFoodClicks();
	
	processEatItClick(currentDay, mealnum);
}

//add the date we're currently dealing with to the urls of the find meal links
function addDateToLinks(currentDay) {
	var links = document.getElementsByClassName('dininghalllink');
	for(var i=0; i < links.length; i++) {
		links[i].href = links[i].href.concat("&date=", currentDay);
	}
}

function processFoodClicks() {
	$('.foodp a').click(function(e) {
	  e.preventDefault();
	  if($(this).hasClass('selectedfood')) {
	    $(this).removeClass('selectedfood');
	  }
	  else {
	  	$(this).addClass('selectedfood');
	  }
	  return false;
	});
}

function processLocationClicks() {
	$( ".dininghalllink" ).click(function() {
	  var loc = this.innerHTML;
	  //if($('a[title="'+loc+'"]').parent().parent().hasClass('showfood')) {

	  //}
	  //else {
	  	  $('.dininghalllink').removeClass('selectedloc');
	  	  $(this).addClass('selectedloc');
		  $('.food').removeClass("showfood");
		  $('.food').removeClass("selectedfood");
		  $('.foodp a').removeClass('selectedfood');
		  $('a[title="'+loc+'"]').parent().parent().addClass('showfood');
		  return false;
	  //}
	});
}

function processEatItClick(currentDay, mealnum) {
	$( "#eatita" ).click(function(e) {
		e.preventDefault();
		var eventName = "";
		var loc = "";
		var time = "";
		var food1 = "";
		var food2 = "";
		var food3 = "";
		var food4 = "";
		var food5 = "";
		
		loc = $('.selectedloc').text();
		var foods = $('.selectedfood');
		if(foods.length > 0)
			food1 = foods[0].innerHTML;
		if(foods.length > 1)
			food2 = foods[1].innerHTML;
		if(foods.length > 2)
			food3 = foods[2].innerHTML;
		if(foods.length > 3)
			food4 = foods[3].innerHTML;
		if(foods.length > 4)
			food5 = foods[4].innerHTML;
		
		$().redirect('index.php', {'date': currentDay, 'mealnum': mealnum, 'loc': loc, 'food1': food1, 'food2': food2, 'food3': food3, 'food4': food4, 'food5': food5}, 'GET');
	});
}