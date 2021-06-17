<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['sex']) && isset($_POST['date']) &&
    isset($_POST['age']) 
        {
        
        $sex = $_POST['sex'];
        $date = $_POST['date'];
        $age = $_POST['age'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "prodb";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else 
        {
            $Select = "SELECT date FROM pdata WHERE date = ? LIMIT 1";
            $Insert = "INSERT INTO pdata (sex,date,age) values(?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("i", $date);
            $stmt->execute();
            $stmt->bind_result($resulteid);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) 
            {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("sii",$sex,$date,$age);
                if ($stmt->execute()) 
                {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>