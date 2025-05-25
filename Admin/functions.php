<?php 
include ('db_conn.php');

function getAll($table)
{
    global $con;
    $query = "SELECT * FROM $table";
    return $queryrun = mysqli_query($con, $query);
}

?>