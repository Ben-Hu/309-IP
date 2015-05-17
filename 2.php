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

    $count1 = querydb("SELECT COUNT(*) FROM ideas,tags WHERE ideas.id = tags.id AND tags.tag = 'tag1'");
    $count2 = querydb("SELECT COUNT(*) FROM ideas,tags WHERE ideas.id = tags.id AND tags.tag = 'tag2'");
    $count3 = querydb("SELECT COUNT(*) FROM ideas,tags WHERE ideas.id = tags.id AND tags.tag = 'tag3'");
    $count4 = querydb("SELECT COUNT(*) FROM ideas,tags WHERE ideas.id = tags.id AND tags.tag = 'tag4'");
    $count5 = querydb("SELECT COUNT(*) FROM ideas,tags WHERE ideas.id = tags.id AND tags.tag = 'tag5'");

    $count1 = $count1->fetch_row();
    $count2 = $count2->fetch_row();
    $count3 = $count3->fetch_row();
    $count4 = $count4->fetch_row();
    $count5 = $count5->fetch_row();

    //echo "$count1[0]";
    $a = array($count1, $count2, $count3, $count4, $count5);
    $jason = json_encode($a);

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>amCharts examples</title>
        <link rel="stylesheet" href="style.css" type="text/css">
        <script src="./amcharts/amcharts.js" type="text/javascript"></script>
        <script src="./amcharts/pie.js" type="text/javascript"></script>
        
        <script type="text/javascript">
            var chart;
            var legend;
            var data = <?php echo json_encode($a) ?>;
            var chartData = [{
                country: "tag1",
                litres: data[0]
            }, {
                country: "tag2",
                litres: data[1]
            }, {
                country: "tag3",
                litres: data[2]
            }, {
                country: "tag4",
                litres: data[3]
            }, {
                country: "tag5",
                litres: data[4]
            }];

            AmCharts.ready(function () {
                // PIE CHART
                chart = new AmCharts.AmPieChart();
                chart.dataProvider = chartData;
                chart.titleField = "country";
                chart.valueField = "litres";
                chart.outlineColor = "#FFFFFF";
                chart.outlineAlpha = 0.8;
                chart.outlineThickness = 2;

                // WRITE
                chart.write("chartdiv");
            });
        </script>
    </head>
    
    <body>
        <div id="chartdiv" style="width: 100%; height: 400px;"></div>
    </body>

</html>