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
	var loc = decodeURIComponent(getUrlVars()['loc']);
	if(localStorage[currentDay] == null) {
		localStorage[currentDay] = "{}";
	}
	if(loc != null) {
		loc = loc.replace(/\+/g, " ");
		loc = loc.replace("%27", "'");
		loc = loc.replace("%7C", "|");
		loc = loc.replace("%3A", ":");
		
		var food1 = decodeURIComponent(getUrlVars()['food1']);
		var food2 = decodeURIComponent(getUrlVars()['food2']);
		var food3 = decodeURIComponent(getUrlVars()['food3']);
		var food4 = decodeURIComponent(getUrlVars()['food4']);
		var food5 = decodeURIComponent(getUrlVars()['food5']);
		
		var day = JSON.parse(localStorage[currentDay]);
		if(food1 != null) {
			food1 = food1.replace(/\+/g, " ");
		}
		if(food2 != null) {
			food2 = food2.replace(/\+/g, " ");
		}
		if(food3 != null) {
			food3 = food3.replace(/\+/g, " ");
		}
		if(food4 != null) {
			food4 = food4.replace(/\+/g, " ");
		}
		if(food5 != null) {
			food5 = food5.replace(/\+/g, " ");
		}
		day[mealnum] = {"loc": loc, "food1": food1, "food2": food2, "food3": food3, "food4": food4, "food5": food5};
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
		var meal1 = $('#loc1');
		meal1.append(decodeURIComponent(meals.one.loc));
		if(meals.one.food1 != null) {
			meal1.append("<br>");
			meal1.append(meals.one.food1);
		}
		if(meals.one.food2 != "undefined") {
			meal1.append("<br>");
			meal1.append(meals.one.food2);
		}
		if(meals.one.food3 != "undefined") {
			meal1.append("<br>");
			meal1.append(meals.one.food3);
		}
		if(meals.one.food4 != "undefined") {
			meal1.append("<br>");
			meal1.append(meals.one.food4);
		}
		if(meals.one.food5 != "undefined") {
			meal1.append("<br>");
			meal1.append(meals.one.food5);
		}
		var checkbox1 = document.getElementById('checkbox1');
		checkbox1.innerHTML = "X";
	}
	if(meals.two != null) {
		var meal2 = $('#loc2');
		meal2.append(decodeURIComponent(meals.two.loc));
		if(meals.two.food1 != null) {
			meal2.append("<br>");
			meal2.append(meals.two.food1);
		}
		if(meals.two.food2 != "undefined") {
			meal2.append("<br>");
			meal2.append(meals.two.food2);
		}
		if(meals.two.food3 != "undefined") {
			meal2.append("<br>");
			meal2.append(meals.two.food3);
		}
		if(meals.two.food4 != "undefined") {
			meal2.append("<br>");
			meal2.append(meals.two.food4);
		}
		if(meals.two.food5 != "undefined") {
			meal2.append("<br>");
			meal2.append(meals.two.food5);
		}
		var checkbox2 = document.getElementById('checkbox2');
		checkbox2.innerHTML = "X";
	}
	if(meals.three != null) {
		var meal3 = $('#loc3');
		meal3.append(decodeURIComponent(meals.three.loc));
		if(meals.three.food1 != null) {
			meal3.append("<br>");
			meal3.append(meals.three.food1);
		}
		if(meals.three.food2 != "undefined") {
			meal3.append("<br>");
			meal3.append(meals.three.food2);
		}
		if(meals.three.food3 != "undefined") {
			meal3.append("<br>");
			meal3.append(meals.three.food3);
		}
		if(meals.three.food4 != "undefined") {
			meal3.append("<br>");
			meal3.append(meals.three.food4);
		}
		if(meals.three.food5 != "undefined") {
			meal3.append("<br>");
			meal3.append(meals.three.food5);
		}
		var checkbox3 = document.getElementById('checkbox3');
		checkbox3.innerHTML = "X";
	}
}