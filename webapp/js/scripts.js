window.onload = function() {
	alert('test');
	var currentDay = getUrlVars()['date']; //the day to display
	//if there is a date in the url show it. if not, show today
	if(currentDay == null) {
		setDates(getToday());
	}
	else {
		setDates(new Date(parseInt(currentDay)));
		console.log(new Date(parseInt(currentDay)));
	}
	
	//localStorage.test="hello world";
	alert (localStorage.test);
}

function setDates(date) {
	$("#todaylink").attr("href", "?index.php?date=".concat(parseInt(getToday().getTime())));
	var dateString = document.getElementById("date");
	var prevDay = getPrevDay(date).getTime();
	var nextDay = getNextDay(date).getTime();
	var leftButton = '<a href = "index.php?date='.concat(prevDay, '">&lt</a>');
	var rightButton = '<a href = "index.php?date='.concat(nextDay, '">&gt</a>');
	dateString.innerHTML = leftButton.concat(date.toDateString(), rightButton);
	var monthString = document.getElementById("month");
	var month = getMonthString(date.getMonth());
	monthString.innerHTML = month;
}

//return the date object for today (at midnight)
function getToday() {
	var todayWithTime = new Date();
	var year = todayWithTime.getFullYear();
	var month = todayWithTime.getMonth();
	var day = todayWithTime.getDate();
	var todayMidnight = new Date(year, month, day);
	return todayMidnight;
}

function getPrevDay(initialDay) {
	var prevDay = new Date();
	prevDay.setDate(initialDay.getDate() - 1);
	return prevDay;
}

function getNextDay(initialDay) {
	var nextDay = new Date();
	nextDay.setDate(initialDay.getDate() + 1);
	return nextDay;
}

function getMonthString(monthNum) {
	var month=new Array();
	month[0]="Jan";
	month[1]="Feb";
	month[2]="Mar";
	month[3]="Apr";
	month[4]="May";
	month[5]="Jun";
	month[6]="Jul";
	month[7]="Aug";
	month[8]="Sep";
	month[9]="Oct";
	month[10]="Nov";
	month[11]="Dec";
	
	return month[monthNum];
}

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
