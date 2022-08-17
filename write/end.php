<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Konec cvičení</title>
    <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
    <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
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
    .top-padding{
    	padding-top: 15px;
    }
    </style>
    <?php
    	$back_arrow = "<svg xmlns='http://www.w3.org/2000/svg' width='20' height='20' fill='currentColor' class='bi bi-arrow-left' viewBox='0 0 20 20'><path fill-rule='evenodd' d='M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z'/></svg>";
    ?>
    <?php
    	$emojis = array("https://images.emojiterra.com/twitter/512px/1f389.png", "https://i.redd.it/m4ohq8yp2mu41.png", "https://images.emojiterra.com/twitter/v13.0/512px/1f525.png", "https://cdn-0.emojis.wiki/emoji-pics/twitter/partying-face-twitter.png", "https://images.emojiterra.com/twitter/v13.0/512px/1f3c5.png");
    	$phrases = array("Hotovo! Dobrá práce!", "Dáme to ještě jednou?", "...ani to nebolelo", "1000 ‰", "Toť vše.");
    	$set_id = $_GET["set_id"];
    	$file = fopen("../data.json", "r") or die("Unable to open file!");
		$data_file = fread($file, filesize("../data.json"));
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
<div class="d-flex flex-row bd-highlight">
<div class="d-flex flex-column p-3 bg-light" style="width: 280px;height:100vh;">
  <div class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
  		<img src="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png" width="50px" height="50px">
    <span class="fs-4 py3" style="font-family: Raleway, sans-serif;"><?php echo $set["name"]; ?></span>
  </div>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item d-flex justify-content-center">
  		<div><a href="../set.php?set_id=<?php echo $set["id"]; ?>"><?php echo $back_arrow; ?>zpět</a></div>
    </li>
  </ul>
  </div>
<div style="padding:2em;width:50%">
	<div class="card">
	  <div class="card-body">
	  	<div class="d-flex justify-content-between align-items-center">
	  		<div class="d-flex justify-content-start align-items-center" style="padding-right:10px">
	  			<img src="<?php echo $emojis[array_rand($emojis, 1)] ?>" width="50px"><h3 style="padding-left:15px"><?php echo $phrases[array_rand($phrases, 1)] ?></h3>
	  		</div>
	  		<div class="d-flex justify-content-end align-items-center">
	  			<button type="button" class="btn btn-primary" autofocus onclick="location.href='select_card.php?set_id=<?php echo (string)$set_id; ?>';">začít od znova</button>
	  		</div>
	  	</div><hr>
	  	<?php
	  		if(isset($_COOKIE["focus_on"])){
	  			echo "<p>Zaměřte se na:</p>";
	  		} else {
	  			echo "<p>Dobrá práce, toto cvičení bylo bez jediné chybičky.</p>";
	  		}
	  	?>
		<ul class="list-group list-group">
		<?php
			foreach($set["cards"] as $card){
				if(isset($_COOKIE["focus_on"])){
				if (strpos((string)$_COOKIE["focus_on"], (string)$card["id"])){
					echo "<li class='list-group-item d-flex justify-content-between align-items-start'><div class='ms-2 me-auto'><div class='fw-bold'>" . $card["term"] . "</div>" . $card["definition"] . "</div></li>";
				}
			}}
		?>
		</ul>
	  </div>
	</div>
</div>
</div>
</div>
</body>
</html>
<?php
	setcookie("focus_on", "", time() - 3600, "/");
?>
