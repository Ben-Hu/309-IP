<html>
<body>
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

    $user = $_SESSION["username"]; 

    // Get the information from the database for the current idea
    $id = $_GET['id'];
    if (!isset($_GET['id'])) {
       // echo "<p>failure</p>";
    } else {
       // echo "<p>success</p>";
    }
   // echo "<p>$id</p>";
    $query = querydb("UPDATE ideas SET likes = likes + 1 WHERE id = $id");

    echo "<script>window.location = 'http://127.0.0.1/ip/idea.php?id=$id'</script>";
   // echo "<script>location.reload();</script>";
?>
</body>
</html>