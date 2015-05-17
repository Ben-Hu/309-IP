<?php
	session_start();

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
	$user = $_SESSION['username'];

	// Get the information entered in the form.
	$title = $_POST['title'];
	$description = $_POST['description'];		
	$tagString = $_POST['tags'];

	$tags = explode(",", $tagString);
		
	$ideaInsert = "INSERT INTO ideas (poster, title, description, likes) VALUES ('$user', '$title', '$description', 0)";
	
	querydb($ideaInsert);
		
    
    // id of new idea
	$getid = querydb("SELECT id FROM ideas WHERE title='$title' AND poster='$user'AND description='$description'");
    while ($row = $getid->fetch_row()) {
		// Insert the tags
	   foreach ($tags as &$tag) {
		  querydb("INSERT INTO tags VALUES($row[0], '$tag')");
       }
	}
    
	 echo "<script>window.location = 'http://127.0.0.1/ip/'</script>";
?>