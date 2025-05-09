<?php
session_start();

// $con = mysqli_connect('localhost','Fixteck','Hirumaroons-3246388','dbmovies');
// $con = mysqli_connect('localhost', 'root', '', 'dbmovies');
$con = mysqli_connect('dbmovie.clwk0g86spbf.eu-north-1.rds.amazonaws.com', 'admin', 'Chanuka20021004', 'dbmovies');
if (!$con) {
    die('cannot established DB');
}
