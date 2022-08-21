<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Špatně</title>
    <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
    <link href='https://fonts.googleapis.com/css?family=Raleway:500' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
    <link rel="stylesheet" type='text/css' href="../styles.css">
    <style>
        body {
            font-family: 'Work Sans', sans-serif;
        }
        .nav-item {
            padding-top: 5px;
          	padding-bottom: 5px;
        }
      	.progress-title {
      		padding-bottom:5px;
      	}
      	.line {
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
    	$set_id = $_GET["set_id"];
    	$card_id = $_GET["card_id"];
    	$you_said = $_GET["you_said"];
    	$file = fopen("../data.json", "r") or die("Unable to open file!");
		$data_file = fread($file, filesize("../data.json"));
		fclose($file);
		$data = json_decode($data_file, true);
    	foreach($data["sets"] as $s){
    		if ((string)$s["id"] == (string)$set_id){
    			$set = $s;
    		}
    	}
    	foreach($set["cards"] as $name=>$c){
    		if ((string)$name == (string)$card_id){
    			$card = $c;
    		}
    	}
        $number_correct = 0;
    	$number_of_cards = count($set["cards"]);
        if (isset($_COOKIE["correct"])) {
            $number_correct = strlen($_COOKIE["correct"])/3;
        }

    	$number_wrong = strlen($_COOKIE["wrong"])/3;
    	$number_done = $number_correct + $number_wrong;
    	$remaining = ($number_of_cards - $number_done) / $number_of_cards * 100;
    	$correct = $number_correct / $number_of_cards * 100;
    	$wrong = $number_wrong / $number_of_cards * 100;
    ?>
    <script src='https://code.responsivevoice.org/responsivevoice.js'></script>
</head>
<body onmouseover="this.onmouseover = null;responsiveVoice.speak('<?php echo $card["term"] ?>', 'Deutsch Male');">
<div class="d-flex flex-row bd-highlight">
<div class="d-flex flex-column p-3 bg-light" style="width: 15%;height:100vh;">
  <div class="d-flex align-items-center justify-content-between mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
  		<img src="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png" width="50px" height="50px">
    <span class="fs-4 py3" style="font-family: Raleway, sans-serif;"><?php echo $set["name"]; ?></span>
  </div>
  <hr>
  <ul class="nav nav-pills flex-column mb-auto">
  	<li class="nav-item">
  		<div class="progress-title">Zbývá:</div>
      	<div class="progress">
		  	<div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $remaining; ?>%" aria-valuenow="<?php echo $remaining; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
    </li>
    <li class="nav-item">
    	<div class="progress-title">Správně:</div>
      	<div class="progress">
		  	<div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $correct; ?>%" aria-valuenow="<?php echo $correct; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
    </li>
    <li class="nav-item">
    	<div class="progress-title">Špatně:</div>
      	<div class="progress">
		  	<div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $wrong; ?>%" aria-valuenow="<?php echo $wrong; ?>" aria-valuemin="0" aria-valuemax="100"></div>
		</div>
    </li>
    <hr>
    <li class="nav-item d-flex justify-content-center">
  		<div><a href="../set.php?set_id=<?php echo $set["id"]; ?>"><?php echo $back_arrow; ?>zpět</a></div>
    </li>
  </ul>
  </div>
<div style="padding:2em;width:50%">
	<div class="card">
	  <div class="card-body">
	  	<h2 class="text-danger">Špatně</h2><hr>
	  	<small>ZADÁNÍ</small>
		<h5 class="top-padding"><b><?php if($card["definition"]) {echo $card["definition"];} elseif($card["question"]){ echo $card["question"]; } ?></b></h5>
		<?php
			if($card["images"]){
				echo "<img src='" . $card["images"][array_rand($card["images"], 1)] . "' style='max-width:50%;max-height:50vh'>";
			}
		?>
		<hr>
		<small>VAŠE ODPOVĚĎ</small>
        <div class="d-flex flex-row justify-content-between">
		<p class="top-padding text-danger"><?php echo $you_said;  ?></p>
        <a class="top-padding" href="override.php?set_id=<?php echo $set_id; ?>">Měl jsem pravdu</a>
    </div>
        <hr>
		<small>SPRÁVNĚ</small>
		<div class="d-flex justify-content-between">
			<h5 class="top-padding text-success"><?php echo $card["term"]; ?></h5>
			<button type="button" class="btn btn-primary" autofocus onclick="location.href='select_card.php?set_id=<?php echo $set_id; ?>';">pokračovat</button>
		</div>
	  </div>
	</div>
</div>
</div>
</div>
</body>
</html>
