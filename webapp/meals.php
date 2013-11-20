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
	$datesec2 = strval($datems/1000);
	$dayOfWeek = date('l', $datesec);
	
	//Connect To Database

	$hostname="cornellfood.db.5837439.hostedresource.com";
	$username="cornellfood";
	$password="CornellFood2@";
	$dbname="cornellfood";
	
	mysql_connect($hostname,$username, $password) or die ("<html><script language='JavaScript'>alert('Unable to connect to database! Please try again later.'),history.go(-1)</script></html>");
	mysql_select_db($dbname);
	
	$locations = array();
	
	//get the a la carte menus
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
	
	//get the all you can eat menus
	$query = "SELECT Location, Time FROM times WHERE Day = \"$dayOfWeek\" AND Meal = \"$mealname\"";
	$locresult = mysql_query($query);
	if($locresult) {
		while($locrow = mysql_fetch_array($locresult)) {
			$location = mysql_real_escape_string($locrow["Location"]);
			$meals = array();
			$query = "SELECT * FROM cornelldining WHERE `location` = \"$location\" AND Meal = \"$mealname\" AND date = \"$datesec2\"";
			$mealresult = mysql_query($query);
			if($mealresult) {
				while($mealrow = mysql_fetch_array($mealresult)) {
					$mealItem = array();
					$mealItem['food'] = $mealrow['menu'];
					$meals[] = $mealItem;
				}
			}
			$locations[] = array("location" => $location, "meals" => $meals);
		}
	}
	
	//get cornell events
	$query = "SELECT * FROM cornellevents WHERE date = \"$datesec2\" AND Meal = \"$mealname\"";
	$result = mysql_query($query);
	if($result) {
		while($row = mysql_fetch_array($result)) {
			$location = mysql_real_escape_string($row["location"]);
			$roomnum = mysql_real_escape_string($row["room_number"]);
			$time = mysql_real_escape_string($row["time"]);
			$title = mysql_real_escape_string($row["title"]);
			$free = mysql_real_escape_string($row["free"]);
			$description = mysql_real_escape_string($row["description"]);
			$locations[] = array("location" => $location, "room_number" => $roomnum, "time" => $time, "title" => $title, "free" => $free, "description" => $description);
		}
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
				
				<h2>
					<!--Sort: &nbsp; Distance &nbsp; Healthiness &nbsp; Price-->
				</h2>
			</header>
			
			<div id = "main">
				<h2><?php echo $mealname;?> for <?php echo $dayOfWeek;?></h2>
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
							echo '<a class = "dininghalllink" href =  "">';
							echo $loc;
							echo '</a>';
							echo '</p>';
							echo "</div>";
							foreach($meals as $meal) {
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
										if(!empty($size)) {
											echo ' | ';
											echo $size;
										}
										if(!empty($price)) {
											echo ' | $';
											echo $price;
										}
										if(!empty ($rating)) {
											echo ' | Healthiness: <span class=\'' . $rating . '\'>' . $rating.'</span>';
										}
										echo '</a>';
										echo '</p>';
										echo "</div>";
									}
								}
							}
						}
						else {
							$eventTitle = stripslashes($location['title']);
							if(!empty($eventTitle)) {
								$eventloc = $location['location'];
								$eventroom = $location['room_number'];
								$eventtime = $location['time'];
								$eventfree = $location['free'];
								$eventdesc = $location['description'];
								
								echo '<div class = "dininghall">';
								echo '<p>';
								echo '<a class = "dininghalllink" href =  "">';
								$eventOverall = "";
								if($eventfree == "free") {
									$eventOverall.= "Free ";
								}
								$eventOverall.= 'Event: '.$eventTitle.' | Location: '.$eventloc.' | Room: '.$eventroom.' | Time: '.$eventtime;
								echo $eventOverall;
								
								echo '</a>';
								echo '</p>';
								echo "</div>";
								
								echo '<div class = "food">';
										echo '<p class = "foodp">';
										echo '<a class = "foodlink" title = "'.$eventOverall.'" href =  "">';
										echo $eventdesc;
										echo '</a>';
										echo '</p>';
										echo "</div>";
							}
						}
					}
				?>
				
				<p id = "eatitp"><a id = "eatita" href = "">Eat it!</a></p>
				<p id = "cancelp"><a id = "cancela" href = "index.php?date=<?php echo $datems;?>">Cancel</a></p>
			</div>
		</div>
		
		<script src = "js/jquery-2.0.3.min.js"></script>
		<script src = "js/scripts.js"></script>
		<script src = "js/meals.js"></script>
		<script src = "js/jquery.redirect.min.js"></script>
	</body>
</html>