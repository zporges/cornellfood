<?php
/*
	session_start();
	if(!isset($_SESSION['meal1'])) {
		$_SESSION['meal1'] = "";
	}
	if(!isset($_SESSION['meal2'])) {
		$_SESSION['meal2'] = "";
	}
	if(!isset($_SESSION['meal3'])) {
		$_SESSION['meal3'] = "";
	}
	
	$loc = "";
	$mealnum = "";
	
	if(isset($_GET['loc'])) {
		$loc = strip_tags($_GET['loc']);
	}
	
	if(isset($_GET['mealnum'])) {
		$mealnum = strip_tags($_GET['mealnum']);
	}
	
	if($mealnum == "one") {
		$_SESSION['meal1'] = $loc;
	}
	if($mealnum == "two") {
		$_SESSION['meal2'] = $loc;
	}
	if($mealnum == "three") {
		$_SESSION['meal3'] = $loc;
	}	
*/
?>

<!doctype html>
<html>
	<head>
		<title>Cornell Healthy Eating</title>
		<meta name="viewport" content="width=device-width">
		<link rel = "stylesheet" href = "styles/main.css">
	</head>
	<body>
		<div id = "wrapper">
			<header>
				<h1>Cornell Food</h1>
				
				<h2 id = "today"><a id = "todaylink" href ="#">Today</a></h2>
				<h2 id = "date"></h2>
				<!--<h2 id = "month"></h2>-->
			</header>
			
			<div id = "main">
				<section id = "datebar">
					
				</section>
				
				<div class = "mealrow">
					<div class = "mealrowright">
						<h2 class = "findmeal"><a class = "findmeallink" href = "meals.php?mealnum=one">Find Breakfast</a></h2>
						<p class = "selectedloc" id = "loc1"><?php /*echo $_SESSION['meal1'];*/?></p>
					</div>
					
					<p class = "checkbox" id = "checkbox1"><?php /*if($_SESSION['meal1'] != "") {echo "X";}*/ ?></p>
				</div>
				
				<div class = "mealrow">
					<div class = "mealrowright">
						<h2 class = "findmeal"><a class = "findmeallink" href = "meals.php?mealnum=two">Find Lunch</a></h2>
						<p class = "selectedloc" id = "loc2"><?php /*echo $_SESSION['meal2'];*/?></p>
					</div>
					<p class = "checkbox" id = "checkbox2"><?php /*if($_SESSION['meal2'] != "") {echo "X";} */?></p>
					
				</div>
				
				<div class = "mealrow">
					<div class = "mealrowright">
						<h2 class = "findmeal"><a class = "findmeallink" href = "meals.php?mealnum=three">Find Dinner</a></h2>
						<p class = "selectedloc" id = "loc3"><?php/* echo $_SESSION['meal3'];*/?></p>
					</div>
					<p class = "checkbox" id = "checkbox3"><?php /*if($_SESSION['meal3'] != "") {echo "X";}*/ ?></p>
					
				</div>
				
			</div>
			
			<footer>
				<p>Healthy eating tip: an apple a day keeps the doctor away!</p>
			</footer>
		</div>
		
		<script src = "js/jquery-2.0.3.min.js"></script>
		<script src = "js/scripts.js"></script>
		<script  src = "js/home.js"></script>
	</body>
</html>