<?php
	$mealnum = strip_tags($_GET['mealnum']);
	$mealname = "";
	if($mealnum == "one") {
		$mealname = "Breakfast";
	}
	if($mealnum == "two") {
		$mealname = "Lunch";
	}
	if($mealnum == "three") {
		$mealname = "Dinner";
	}
	
	$datems = strip_tags($_GET['date']);
	$datesec = $datems/1000 + 60*60*24;
	$dayOfWeek = date('l', $datesec);
	
	//Connect To Database

	$hostname="cornellfood.db.5837439.hostedresource.com";
	$username="cornellfood";
	$password="CornellFood2@";
	$dbname="cornellfood";
	
	mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
	mysql_select_db($dbname);
	
	$locations = array();
	
	$query = "SELECT Location, Time FROM times WHERE Day = \"$dayOfWeek\" AND Meal = \"$mealname\"";
	
	$locresult = mysql_query($query);
	
	if($locresult) {
		while($locrow = mysql_fetch_array($locresult)) {
			$location = mysql_real_escape_string($locrow["Location"]);
			$meals = array();
			$query = "SELECT * FROM cornellmenus WHERE `dining location` = \"$location\"";
			$mealresult = mysql_query($query);
			if($mealresult) {
				while($mealrow = mysql_fetch_array($mealresult)) {
					$mealItem = array();
					$mealItem['food'] = $mealrow['food item'];
					$mealItem['price'] = $mealrow['price'];
					$mealItem['size'] = $mealrow['size'];
					$mealItem['health rating'] = $mealrow['health rating'];
					$meals[] = $mealItem;
				}
			}
			$locations[] = array("location" => $location, "meals" => $meals);
		}
	}
	/*
	foreach($locations as $location) {
		$meals = $location['meals'];
		echo $location['location'];
		foreach($meals as $meal) {
			echo $meal["food"];
			echo $meal["price"];
		}
		echo "<br>";
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
				
				<h2>
					Sort: &nbsp; Distance &nbsp; Healthiness &nbsp; Price
				</h2>
			</header>
			
			<div id = "main">
				<p>
					Select a location, select food(s), and then click "Eat it!" at the bottom.
				</p>
				<?php
					foreach($locations as $location) {
						$meals = $location['meals'];
						if(!empty($meals)) {
							$loc = stripslashes($location['location']);
							echo '<div class = "dininghall">';
							echo '<p>';
							echo '<a class = "dininghalllink unselectedloc" href =  "">';
							echo $loc;
							echo '</a>';
							echo '</p>';
							echo "</div>";
							foreach($meals as $meal) {
								//echo $meal["food"];
								//echo $meal["price"];
								//print_r($meal);
								//echo '<br><br>';
								if(!empty($meal)){
									$food = $meal["food"];
									$price = $meal["price"];
									$size = $meal["size"];
									$rating = $meal["health rating"];
								
									if(!empty($food)) {
										echo '<div class = "food">';
										echo '<p class = "foodp">';
										echo '<a class = "foodlink" title = "'.$loc.'" href =  "">';
										echo $food;
										echo $price;
										echo '<span class=\'' . $rating . '\'>' . $rating;
										echo '</a>';
										echo '</p>';
										echo "</div>";
									}
								}
							}
						}
					}
				?>

<!--				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Trillium&mealnum=<?php echo($mealnum); ?>">Trillium</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Terrace&mealnum=<?php echo($mealnum); ?>">Terrace</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating C">C</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Mattins&mealnum=<?php echo($mealnum); ?>">Mattin's</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating A">A</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Bethe%20House&mealnum=<?php echo($mealnum); ?>">Bethe House</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating F">F</p>
					<p><a class = "dininghalllink" href = "index.php?loc=West%20Side%20Express&mealnum=<?php echo($mealnum); ?>">West Side Express</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating C">C</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Macs%20Cafe&mealnum=<?php echo($mealnum); ?>">Mac's Cafe</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a class = "dininghalllink" href = "index.php?loc=Ivy%20Room&mealnum=<?php echo($mealnum); ?>">Ivy Room</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a class = "dininghalllink" href = "index.php?loc=104%20West&mealnum=<?php echo($mealnum); ?>">104 West!</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating A">A</p>
					<p><a class = "dininghalllink" href = "index.php?loc=One%20World%20Cafe&mealnum=<?php echo($mealnum); ?>">One World Cafe</a></p>
				</div>
				-->
			</div>
		</div>
		
		<script src = "js/jquery-2.0.3.min.js"></script>
		<script src = "js/scripts.js"></script>
		<script src = "js/meals.js"></script>
	</body>
</html>