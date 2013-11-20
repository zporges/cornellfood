window.onload = function() {
	//set the current day to the date in the url
	var currentDay = getUrlVars()['date'];
	
	//if there is no date in the url, set the date to today
	if(currentDay == null) {
		currentDay = parseInt(getToday().getTime());
	}
	
	//set the dates in the html to the current day
	setDates(new Date(parseInt(currentDay)));
	
	//store the meal selected in the local storage
	updateMeals(currentDay);
	
	//add the date we're currently dealing with to the urls of the links
	addDateToFindMeal(currentDay);
	
	//add the selected dining hall locations to the page
	showSelectedLocations(currentDay);
}

//store the meals selected in the local storage
function updateMeals(currentDay) {
	var mealnum = getUrlVars()['mealnum'];
	var loc = getUrlVars()['loc'];
	console.log(loc);
	
	if(localStorage[currentDay] == null) {
		localStorage[currentDay] = "{}";
	}
	
	if(loc != null) {
		var day = JSON.parse(localStorage[currentDay]);
		day[mealnum] = unescape(loc);
		localStorage[currentDay] = JSON.stringify(day);
	}
}

//add the date we're currently dealing with to the urls of the find meal links
function addDateToFindMeal(currentDay) {
	var links = document.getElementsByClassName('findmeallink');
	for(var i=0; i < links.length; i++) {
		links[i].href = links[i].href.concat("&date=", currentDay);
	}
}

//add the selected dining hall locations to the page
function showSelectedLocations(currentDay) {
	var meals = localStorage[currentDay];
	meals = JSON.parse(meals);
	if(meals.one != null) {
		var meal1 = document.getElementById('loc1');
		meal1.innerHTML = meals.one;
		var checkbox1 = document.getElementById('checkbox1');
		checkbox1.innerHTML = "X";
	}
	if(meals.two != null) {
		var meal2 = document.getElementById('loc2');
		meal2.innerHTML = meals.two;
		var checkbox2 = document.getElementById('checkbox2');
		checkbox2.innerHTML = "X";
	}
	if(meals.three != null) {
		var meal3 = document.getElementById('loc3');
		meal3.innerHTML = meals.three;
		var checkbox3 = document.getElementById('checkbox3');
		
		checkbox3.innerHTML = "X";
	}
}