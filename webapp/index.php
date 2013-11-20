<?php
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
				<h2 id = "month"></h2>
			</header>
			
			<div id = "main">
				<section id = "datebar">
					
				</section>
				
				<div class = "mealrow">
					<h2 class = "findmeal"><a href = "meals.php?mealnum=one">Find Meal 1</a></h2>
					<p class = "checkbox"><?php if($_SESSION['meal1'] != "") {echo "X";} ?></p>
					
					<p class = "selectedloc"><?php echo $_SESSION['meal1'];?></p>
				</div>
				
				<div class = "mealrow">
					<h2 class = "findmeal"><a href = "meals.php?mealnum=two">Find Meal 2</a></h2>
					<p class = "checkbox"><?php if($_SESSION['meal2'] != "") {echo "X";} ?></p>
					
					<p class = "selectedloc"><?php echo $_SESSION['meal2'];?></p>
				</div>
				
				<div class = "mealrow">
					<h2 class = "findmeal"><a href = "meals.php?mealnum=three">Find Meal 3</a></h2>
					<p class = "checkbox"><?php if($_SESSION['meal3'] != "") {echo "X";} ?></p>
					
					<p class = "selectedloc"><?php echo $_SESSION['meal3'];?></p>
				</div>
				
			</div>
			
			<footer>
				<p>Healthy eating tip: an apple a day keeps the doctor away!</p>
			</footer>
		</div>
		
		<script src = "js/jquery-2.0.3.min.js"></script>
		<script src = "js/scripts.js"></script>
	</body>
</html>