<?php
  session_start();
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
                <a class="navbar-brand page-scroll" href="http://127.0.0.1/ip/">IP</a>
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
                        echo "<li><a class='page-scroll' href='http://127.0.0.1/ip/#myideas'>My Ideas</a></li><li><a class='page-scroll' href='http://127.0.0.1/ip/#newidea'>New Idea</a></li>";    
                    }
                    ?>
                    <li>
                        <a class="page-scroll" href="http://127.0.0.1/ip/#curideas">Explore Ideas</a>
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
    
     <?php
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

    $user = $_SESSION["username"]; 

    // Get the information from the database for the current idea
    $id = $_GET['id'];
    if (!isset($_GET['id'])) {
        //echo "<p>failure</p>";
    } else {
        //echo "<p>success</p>";
    }
    //echo "<p>$id</p>";
    $query = querydb("SELECT poster, title, description, likes from ideas WHERE id = $id");
    $info = $query->fetch_row() 
        //0 = poster
        //1 = title
        //2 = desc
        //3 = likes

    ?>
    
    <!-- Intro Section -->
    <section id="newidea\" class="new-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1><?php echo "$info[1]"; ?></h1>
                     <a href='idea.php?id=<?php echo "$id";?>'>
                             <img class='img-circle img-responsive img-center' src='http://placehold.it/200x200' alt=''></a>
                    </br>
                    <h3>Poster: <?php echo "$info[0]"; ?></h3>
                    <h3>Description: <?php echo "$info[2]"; ?></h3>
                    <h3>Likes: <?php echo "$info[3]"; ?></h3>
                    </br>
                    <div class="ratings">
							<p class="center">
                                <?php 
                                echo "
								<a class=\"button\" href='like.php?id=$id'><span class=\"glyphicon glyphicon-thumbs-up\"></span></a>
                                <a class=\"button\" href='dislike.php?id=$id'><span class=\"glyphicon glyphicon-thumbs-down\"></span></a>";
                                ?>
							</p>
                    </div>
                    </br>      
                </div>
            </div>
        </div>
    </section>
    
    
    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Scrolling Nav JavaScript -->
    <script src="js/jquery.easing.min.js"></script>
    <script src="js/scrolling-nav.js"></script>
    
    <!-- likes -->
    <script>
		var user = <?php echo json_encode($user); ?>;
		var lid = <?php echo "$id"; ?>;
		var ifLiked = <?php echo "$liked"; ?>;
		var likedVal = <?php echo json_encode($likedResult[0]); ?>;
	</script>
	<script src="js/listing.js"></script>
    
?>

</body>

</html>