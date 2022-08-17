<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>CM kvízy</title>
    <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
    <link href='https://fonts.googleapis.com/css?family=Raleway:800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet" type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
	<link rel="stylesheet" type='text/css' href="../styles.css">
    <style>
    body{
    	font-family: 'Work Sans', sans-serif;
    }
    .nav-item{
    	padding-top: 5px;
    	padding-bottom: 5px;
    }
	.progress-title{
		padding-bottom:5px;
	}
	.line{
    	padding-top: 10px;
    }
    </style>
    <?php
    	$back_arrow = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z'/></svg>";
    ?>
    <?php
    	$set_id = $_GET["set_id"];
    	$file = fopen("data.json", "r") or die("Unable to open file!");
		$data_file = fread($file, filesize("data.json"));
		fclose($file);
		$data = json_decode($data_file, true);
    	foreach($data["sets"] as $s){
    		if ((string)$s["id"] == (string)$set_id){
    			$set = $s;
    		}
    	}
    ?>
</head>
<body>
    <?php include('templates/header.html'); ?>

    <div class="d-flex flex-row bd-highlight d-flex justify-content-center">
        <div style="padding:2em;min-width:50%">
        	<div class="card">
        	  <div class="card-body">
        			<h2 style="font-family: Raleway, sans-serif;"><?php echo $set["name"]; ?></h2><hr>
        			<p><?php echo $set["description"]; ?></p>
        			<button type="button" class="btn btn-primary" onclick="location.href='select_card.php?set_id=<?php echo (string)$set_id; ?>';">Spustit</button>
        			<div style="padding-top:10px">
        			<hr>
        			<h6>Karty:</h6>
        			<table class="table">
        			  <tbody>
        			  	<?php
        			  		foreach($set["cards"] as $card){
        			  			echo "<tr><td>" . $card["term"] . "</td><td>" . $card["definition"] . "</td></tr>";
        			  		}
        			  	?>
        			  </tbody>
        			</table>
        			</div>
        	  </div>
        	</div>
        </div>
        </div>
    </div>
</body>
</html>
