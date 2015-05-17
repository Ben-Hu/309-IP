<?php
    session_start();
    /* Return the result of a database query. */
    function querydb($query) {
        $dbconn = new mysqli('127.0.0.1', 'root', '309kerebe', 'ip');
        if ($dbconn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            //echo 'great work';
        }
        $result = $dbconn->query($query);
        if ($result == TRUE) {
           // echo 'success';
        } else {
            //echo 'failure';
        }
        $dbconn->close();
        return $result;
    }

    if (isset($_POST['delete'])) {
        $id = $_POST['delete'];
        //echo "<script> alert('deleting $id'); </script>";
        $query = querydb("DELETE FROM ideas WHERE id = $id");
    }
    
    if (isset($_POST['save'])) {
        $id = $_POST['save'];
		$newDesc = $_POST['newDesc'];
		$newTitle = $_POST['newTitle'];
        $descres = querydb("UPDATE ideas SET description = '$newDesc' where id='$id'");
        $titleres = querydb("UPDATE ideas SET title = '$newTitle' where id='$id'");
        //echo "<script> alert('editing $id'); </script>";
        //$query = querydb("DELETE FROM ideas WHERE id = $id");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IP</title>

    <!-- Bootstrap CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/scrolling-nav.css" rel="stylesheet">

</head>
    
<!-- The #page-top ID is part of the scrolling feature - the data-spy and data-target are part of the built-in Bootstrap scrollspy function -->

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">IP</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a class="page-scroll" href="#page-top"></a>
                    </li>
                    
                    <?php 
                    if (isset($_SESSION['username'])){
                        echo "<li><a class='page-scroll' href='#myideas'>My Ideas</a></li><li><a class='page-scroll' href='#newidea'>New Idea</a></li>";    
                    }
                    ?>
                    <li>
                        <a class="page-scroll" href="#curideas">Explore Ideas</a>
                    </li>
                    <?php 
                    if (!isset($_SESSION['username'])){
                        echo "<li><a class='page-scroll' href='#' data-toggle='modal'data-target='#login'>Login/Register</a></li>";
                    } else { 
						echo "<li><a href='logout.php'>Logout</a></li>";    
                    }
                    ?>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Intro Section -->
    <section id="intro" class="intro-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Welcome</h1>
                    <br/>
                    <a class="btn btn-default page-scroll" href="#curideas">Explore</a>
                    <br/>
                    <br/>
                    <?php if (isset($_SESSION['username'])) {
                        echo "<a class=\"btn btn-default page-scroll\" href=\"#newidea\">Create</a>";
                    }
                    ?>
                    <br/>
                    <br/>
                    <br/>
                    <!-- random carousel -->
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
							<ol class="carousel-indicators">
								<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
								<li data-target="#carousel-example-generic" data-slide-to="1"></li>
								<li data-target="#carousel-example-generic" data-slide-to="2"></li>
							</ol>
							
							<!-- Images to scroll through for the three recently addded ideas. -->
                            <div class="carousel-inner">
                            <?php 
                                 $result = querydb("SELECT id FROM ideas ORDER BY id DESC LIMIT 3");
                                 $first = 0;
                                 while ($row = $result->fetch_row()) {
                                     if ($first == 0) {
                                         echo "								
                                         <div class=\"item active\">
                                         <a href=\"idea.php?id=$row[0]\">
                                            <img class=\"slide-image\" src=\"http://placehold.it/1200x300\\\" alt=\"\">
                                         </a>
                                         </div>";
                                         $first = $first + 1;
                                     } else {
                                         echo "								
                                         <div class=\"item\">
                                         <a href=\"idea.php?id=$row[0]\">
                                            <img class=\"slide-image\" src=\"http://placehold.it/1200x300\" alt=\"\">
                                         </a>
                                         </div>";
                                     }
                                 }
                            ?>
                            </div>
                            
							<!-- Arrows to click for scrolling through the three recently added listings. -->
							<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
								<span class="glyphicon glyphicon-chevron-left"></span>
							</a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
						</div>

                </div>
            </div>
        </div>
    </section>
    
    <!-- begin if -->
    <!-- My ideas Section -->
    <?php
    if (isset($_SESSION['username'])){
        echo "
    <section id=\"myideas\" class=\"myideas-section\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-lg-12\">
                    <h1>My Ideas</h1>
                    </br>
                </div>";}
    ?>
                <?php
                    if (isset($_SESSION['username'])){ 
                        $user = $_SESSION['username'];
                        $result = querydb("SELECT id, poster, title, description, likes FROM ideas WHERE poster='$user' ORDER BY likes DESC");
                        while ($row = $result->fetch_row()) {
                            echo "<div class='col-lg-4 col-sm-6 text-center'>
                                 <a href='idea.php?id=$row[0]'>
                                 <img class='img-circle img-responsive img-center' src='http://placehold.it/200x200' alt=''></a>
                                 <h3><a href='idea.php?id=$row[0]'><p> ID: $row[0] </p></a>
                                     <small>
                                     <p>Title: $row[2] </p>
                                     <!-- <p>Poster: $row[1]</p> --> 
                                     <p>Description: $row[3]</p>
                                     </small>
                                 </h3>
                                 <p>Likes: $row[4]</p>
                                 <form method=\"POST\">
                                 <button class=\"btn btn-primary\" name=\"delete\" value=$row[0] type=\"submit\">Delete</button>
                                 
                                 <button type=\"button\" class=\"btn btn-primary\" data-toggle=\"modal\" data-target=\"#edit\">Edit</button>
                                 
                                 <!-- Idea Edit Form -->
                                 <div class=\"modal fade\" id=\"edit\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"edit\" aria-hidden=\"true\">
                                    <div class=\"modal-dialog\">
                                        <div class=\"modal-content\">
                                            <div class=\"modal-header\">
                                                <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-hidden=\"true\">X</button>
                                                <h4 class=\"modal-title\">Register</h4>
                                            </div>
                                            <div class=\"modal-body\">
                                                <form method=\"post\">
                                                    <div>
                                                        <p>Title</p>
                                                        <input type=\"text\" class=\"form-control\" name=\"newTitle\" value=\"$row[2]\">
                                                        </br>
                                                        <p>Description</p>
                                                        <input type=\"text\" class=\"form-control\" name=\"newDesc\" value=\"$row[3]\">
                                                        </br>
                                                        <button class=\"btn btn-primary\" name=\"save\" value=$row[0] type=\"submit\">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                 </div>

                                 </form>
                                 </br>
                                 </div> ";	 
                        }
                    }
              ?>
    <?php 
    if (isset($_SESSION['username'])){
        echo "
            </div>
        </div>
    </section>";
    }
    ?>
        
    <!-- New Idea Section -->
    <?php
     if (isset($_SESSION['username'])){
         echo "
    <section id=\"newidea\" class=\"new-section\">
        <div class=\"container\">
            <div class=\"row\">
                <div class=\"col-lg-12\">
                    <h1>New Idea</h1>
                        </br>
                        <div id='listing-form'>
                            <form method='post' action='post.php'>
                                <div>
                                    <input type='text' class='form-control' maxlength='125' name='title' placeholder='Title' required>
                                <br />
                                    <input type='text' class='form-control' maxlength='250' name='description' placeholder='Description' required>
                                <br />
                                    <input type='text' class='form-control' data-role='tagsinput' name='tags' placeholder='Comma-Separated Tags' required> 
                                <br />
                                    <button type='submit' class='btn btn-default' name='post'>Post</button>
                                </div>
                            </form>
                        </div> 
                </div>
            </div>
        </div>
    </section>";
     }
    ?>
    <!-- end if -->
    
    <!-- curideas Section -->
    <section id="curideas" class="curideas-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1>Current Ideas</h1>
                    </br>
                </div>
                <?php
                    $result = querydb("SELECT id, poster, title, description, likes FROM ideas ORDER BY likes DESC");
                    while ($row = $result->fetch_row()) {
                        echo "<div class='col-lg-4 col-sm-6 text-center'>
                             <a href='idea.php?id=$row[0]'>
                             <img class='img-circle img-responsive img-center' src='http://placehold.it/200x200' alt=''></a>
                             <h3><a href='idea.php?id=$row[0]'><p> ID: $row[0] </p></a>
                                 <small>
                                 <p>Title: $row[2] </p>
                                 <p>Poster: $row[1]</p> 
                                 <p>Description: $row[3]</p>
                                 </small>
                             </h3>
                             <p>Likes: $row[4]</p>
                             </div> ";	   
                     }    
              ?>  
            </div>
        </div>
    </section>
        
    <!-- Login form -->
    <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- Close button -->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title">Login/Register</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div>
                            <input type="text" class="form-control" name="user" maxlength="25" placeholder="Username">
                            <br />
                            <input type="password" class="form-control" name="pass" maxlength="25" placeholder="Password">
                            <br />
                            <button class="btn btn-primary" name="login" value="login" type="submit">Login</button>
                        </div>
                    </form>
                </div>

                <!-- Register button -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#register">Register</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Registration form -->
    <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                    <h4 class="modal-title">Register</h4>
                </div>
                <div class="modal-body">
                    <form method="post">
                        <div>
                            <input type="text" class="form-control" name="username" maxlength="25" placeholder="Username" required>
                            <br />
                            <input type="password" class="form-control" name="password" maxlength="25" placeholder="Password" required>
                            <br />
                            <input type="text" class="form-control" name="firstname" maxlength="25" placeholder="First name" required>
                            <br />
                            <input type="text" class="form-control" name="lastname" maxlength="25" placeholder="Last name" required>
                            <br />
                            <button class="btn btn-primary" name="register" value="register" type="submit">Register</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Login / Register Functions -->
    <?php       
        // Function for user registration
        if (isset($_POST['register'])) {
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $first = $_POST['firstname'];
            $last = $_POST['lastname'];
            echo "$user";
            $result = querydb("INSERT INTO users VALUES('$user', '$pass', '$first', '$last')");
            if (!$result) { // If the username is already taken
                echo "<script> alert('Your username is already taken. Unsuccessful registration.'); </script>";
            } else {
                echo "<script> alert('You have successfully registered! You may now login.'); </script>";
            }
            unset($_POST['register']);
        }

        // Function for login
        if (isset($_POST['login'])) {
            $user = $_POST['user'];
            $pass = $_POST['pass'];
            // Query the database to see if there is a combination that matches the
            // user input.
            $query = "SELECT * FROM users WHERE username='$user' AND password='$pass'";
            $result = querydb($query);
            $numrows = mysqli_num_rows($result);

            if ($numrows == 0) {
                echo "<script>alert('Incorrect username/password combination.')</script>";
            } else {
                // Start a new user session and set the username
                
                    @session_start();
                    $_SESSION["username"] = $user;
                    session_write_close();
                    unset($_POST['login']);
                
                    //echo "<script>location.reload();</script>";
                // Close the session temporarily after writing to it.
            }
        }

        // If the user clicks the "Logout" link, destroy the logged in user session
        if (isset($_GET['logout'])) {
            unset($_GET['logout']);
            unset($_SESSION['username']);
            session_unset(); // Unset $_SESSION['username']
            session_destroy();
            echo "<script>location.reload();</script>";
        }
    ?>
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>

</body>

</html>