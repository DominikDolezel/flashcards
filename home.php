<?php
    session_start();
    ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- CSS only -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
     <title>Flashcards</title>
     <link rel="icon" href="https://i.pinimg.com/originals/50/07/d9/5007d95c2848abc9f9bc296c0f5f520e.png">
     <link href='https://fonts.googleapis.com/css?family=Raleway:800' rel='stylesheet' type='text/css'>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&display=swap" rel="stylesheet" type='text/css'>
 	<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300&family=Work+Sans&display=swap" rel="stylesheet" type='text/css'>
 	<link rel="stylesheet" type='text/css' href="../styles.css">
     <style>
     body{
     	font-family: 'Work Sans', sans-serif;
     }

     a.nocolor, a:hover.nocolor, a:focus.nocolor, a:active.nocolor {
     text-decoration: none;
     color: inherit;
}

    .object {
        padding-left: 2em;
        padding-right: 2em;
        padding-bottom: 1em;
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
        $file = fopen("data.json", "r") or die("Unable to open file!");
    $data_file = fread($file, filesize("data.json"));
    fclose($file);
    $data = json_decode($data_file, true);
    $sets_to_show = $_SESSION["user"]["studied"];
    $folders_to_show = $_SESSION["user"]["folders_created"];
    ?>
 </head>
 <body>
     <?php include('templates/header.html'); ?>

     <div class="d-flex flex-column bd-highlight d-flex justify-content-start">
         <div class='object'>
             <h4>Vaše poslední sety</h4>
         </div>
         <div class='d-flex flex-row bd-highlight d-flex justify-content-start'>
         <?php
        if ($sets_to_show == []) {
            echo "<p>Zatím jste nevytvořili žádné sety. Až tak učiníte, objeví se tady.</p>";
        }
           foreach ($sets_to_show as $set_id) {
               foreach ($data["sets"] as $s) {
                   if ((string)$s["id"] == (string)$set_id) {
                       $set = $s;
                       break;
                   }
               }
               echo "<div class='object' style='min-width:30%'><a class='nocolor' href='set.php?set_id=" . (string)$set["id"] . "'><div class='card'><div class='card-body'><h5 class='card-title' style='font-family: Raleway, sans-serif;'>" . $set["name"] . "</h5><h6 class='card-subtitle'>" . (string)count($set["cards"]) . " karet</h6></div></div></a></div>";
           }
    ?>
     </div>
     <div class='object'>
     <hr>
     </div>
     <div class='object'>
         <h4>Vaše složky</h4>
         <div class='d-flex flex-row bd-highlight d-flex justify-content-start'>
         <?php
    if ($folders_to_show == []) {
        echo "<p>Zatím jste nevytvořili žádné složky. Až tak učiníte, objeví se tady.</p>";
    }
       foreach ($folders_to_show as $folder_id) {
           foreach ($data["folders"] as $f) {
               if ((string)$f["id"] == (string)$folder_id) {
                   $folder = $f;
                   break;
               }
           }
           echo "<div class='object' style='min-width:30%'><a href='sets.php?folder_id=" . (string)$folder["id"] . "'><div class='card'><div class='card-body'><h5 class='card-title' style='font-family: Raleway, sans-serif;'>" . $folder["name"] . "</h5><h6 class='card-subtitle'>" . (string)count($folder["sets"]) . " setů</h6></div></div></a></div>";
       }
    ?>
     </div>
 </div>
         </div>
     </div>
 </body>
 </html>
