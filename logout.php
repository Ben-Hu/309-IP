<html>
<body>
<?php
        session_start();
        unset($_SESSION['username']);
        session_unset(); // Unset $_SESSION['username']
        session_destroy();
        echo "<script>window.location = 'http://127.0.0.1/ip/'</script>";
       // echo "<script>location.reload();</script>";
?>
</body>
</html>