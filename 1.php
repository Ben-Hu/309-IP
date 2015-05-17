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
    
<body>
 	<div id="info-form">
        <form method="post">
		<input type="date" name="begin">
        <input type="date" name="end">
        <input type="number" name="num" min="1" max="5">
        <input class="btn btn-primary" name="submit" value="submit" type="submit">
    </div>
        
    <?php
    session_start();
    if (isset($_POST['submit'])) {
        $begin = $_POST['begin'];
        $end = $_POST['end'];
        $num = $_POST['num'];
        echo "$begin";
        $dbconn = mysql_connect('127.0.0.1', 'root', '309kerebe');
        if (!$dbconn) {
            //echo "failure";
        }
        mysql_select_db('ip', $dbconn);
        $json_response = array();
        
        $result = mysql_query("SELECT * FROM ideas where DATE(date) >= '$begin' AND DATE(date) <= '$end' ORDER BY likes LIMIT $num", $dbconn);
    
        while ($row = mysql_fetch_array($result, MYSQL_ASSOC)){
            $row_array['id'] = $row['id'];
            $row_array['poster'] = $row['poster'];
            $row_array['title'] = $row['title'];
            $row_array['description'] = $row['description'];
            $row_array['likes'] = $row['likes'];
            $row_array['date'] = $row['date'];
            array_push($json_response, $row_array);
        }
        echo json_encode($json_response);
        @fclose($dbconn);
    }
?>
</body>

</html>