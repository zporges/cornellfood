<?php
	session_start();
	$mealnum = strip_tags($_GET['mealnum']);
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
				
				<div class = "dininghall">
					<p class = "rating A">A</p>
					<p><a href = "index.php?loc=Cook%20House&mealnum=<?php echo($mealnum); ?>">Cook House</a></p>
				</div>
                
                <div class="wrapper">
                    <div class="black"></div>
                    <div class="blue "></div>
                    <div class="red"></div>
                    <div class="green"></div>
                </div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a href = "index.php?loc=Trillium&mealnum=<?php echo($mealnum); ?>">Trillium</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a href = "index.php?loc=Terrace&mealnum=<?php echo($mealnum); ?>">Terrace</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating C">C</p>
					<p><a href = "index.php?loc=Mattins&mealnum=<?php echo($mealnum); ?>">Mattin's</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating A">A</p>
					<p><a href = "index.php?loc=Bethe%20House&mealnum=<?php echo($mealnum); ?>">Bethe House</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating F">F</p>
					<p><a href = "index.php?loc=West%20Side%20Express&mealnum=<?php echo($mealnum); ?>">West Side Express</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating C">C</p>
					<p><a href = "index.php?loc=Macs%20Cafe&mealnum=<?php echo($mealnum); ?>">Mac's Cafe</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a href = "index.php?loc=Ivy%20Room&mealnum=<?php echo($mealnum); ?>">Ivy Room</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating B">B</p>
					<p><a href = "index.php?loc=104%20West&mealnum=<?php echo($mealnum); ?>">104 West!</a></p>
				</div>
				
				<div class = "dininghall">
					<p class = "rating A">A</p>
					<p><a href = "index.php?loc=One%20World%20Cafe&mealnum=<?php echo($mealnum); ?>">One World Cafe</a></p>
				</div>
				
			</div>
		</div>
		
		<script src = "js/jquery-2.0.3.min.js"></script>
		<script src = "js/scripts.js"></script>
        <script src = "js/expand.js"></script>
	</body>
</html>