<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>New Age - Start Bootstrap Theme</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="landing_page/css/styles.css" rel="stylesheet" />
        <style>
            body {
              background: #007bff;
              background: linear-gradient(to right, #0062E6, #33AEFF);
            }

            .card-img-left {
              width: 45%;
              /* Link to your background image using in the property below! */
              background: scroll center url('https://source.unsplash.com/WEQbe2jBg40/414x512');
              background-size: cover;
            }

            .btn-login {
              font-size: 0.9rem;
              letter-spacing: 0.05rem;
              padding: 0.75rem 1rem;
            }
        </style>
    </head>
    <body>

    <div class="row" style="width:100%">
      <div class="col-lg-10 col-xl-9 mx-auto">
        <div class="card flex-row my-5 border-0 shadow rounded-3 overflow-hidden">

          <div class="card-body p-4 p-sm-5">
            <h5 class="card-title text-center mb-5 fw-light fs-5">Register</h5>
            <form class="user" action="" method="post" novalidate>

              <div class="form-floating mb-3">
                <input type="text" name="username" class="form-control" id="username" placeholder="myusername" required autofocus>
                <label for="username">Username</label>
              </div>

              <div class="form-floating mb-3">
                <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com">
                <label for="email">Email address</label>
              </div>

              <hr>

              <div class="form-floating mb-3">
                <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                <label for="password">Password</label>
              </div>

              <div class="form-floating mb-3">
                <input type="password" name="password2" class="form-control" id="password2" placeholder="Confirm Password">
                <label for="password2">Confirm Password</label>
              </div>

              <div class="d-grid mb-2">
                <button class="btn btn-lg btn-primary btn-login fw-bold text-uppercase" type="submit">Register</button>
              </div>

              <a class="d-block text-center mt-2 small" href="login.php">Have an account? Log in.</a>

            </form>

            <?php
            	// define variables and set to empty values
            	$username = $email = $password = $password2 = "";

            	if ($_SERVER["REQUEST_METHOD"] == "POST") {
            		$username = test_input($_POST["username"]);
            		$email = test_input($_POST["email"]);
            		$password = test_input($_POST["password"]);
            		$password2 = test_input($_POST["password2"]);
            		$file = fopen("data.json", "r") or die("Unable to open file!");
            		$data_file = fread($file, filesize("data.json"));
            		fclose($file);
            		$data = json_decode($data_file, true);
                    $number_of_users = 0;
                    if ($password != $password2) {
                        echo "passwords don't match";
                        die();
                    }
            		$to_add = array('id'=>(int)($data["users"][-1]["id"] + 1), 'login'=>(string)$username, 'password'=>password_hash($password, PASSWORD_DEFAULT), 'email'=>$email, 'sets_created'=>[], 'folders_created'=>[], 'studied'=>[]);
            		array_push($data["users"], $to_add);
            		$myfile = fopen("data.json", "w") or die("Unable to open file!");
            		fwrite($myfile, json_encode($data, JSON_PRETTY_PRINT));
            		fclose($myfile);
                    $_SESSION["user_id"] = $to_add["id"];
                    $_SESSION["user"] = $to_add;
            		header('Location: home.php');
            		die();
            	}

            	function test_input($data) {
            	  $data = trim($data);
            	  $data = stripslashes($data);
            	  $data = htmlspecialchars($data);
            	  return $data;
            	}
            ?>
          </div>

      </div>
    </div>
  </div>
</body>
</html>
