<?php
session_start();
$ID = $_GET['ID'];

$con = mssql_connect('sunserver', 'siminternal', 'Watergate2015');
if (!mssql_select_db('sw_charts', $con)) {
    die('Unable to select database!');
}
$first = $_GET['first'];
$first = strtolower($first);
$first = ucfirst($first);

$last = $_GET['last'];
$last = strtolower($last);
$last = ucfirst($last);

$patientName = $last . ', ' . $first;

//Converting DOS to good format

$date = strtotime($_GET['dos']);
$DOS = date('m-d-Y', $date);
$date = strtotime($_SESSION['patientDOB']);

$DOB = date("m-d-Y", $date);
$query = 'SELECT * FROM dbo.Encounter_Data WHERE EncountID=\''. $ID . '\'';

$result = mssql_query($query);
echo '<table width="100%"><tbody><tr><th width="33%" align="left">' . $patientName . '</th><th width="33%">DOS: ' . $DOS . '</th><th width="34%" align="right">DOB: ' . $DOB .'</th> </tr></tbody></table>';
while ($row = mssql_fetch_array($result)){

    if ($row[2] == 100){
        echo '</br></br><h4 style="display: inline">SUBJECTIVE:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    } elseif ($row[2] == 101) {
        echo '</a></br></br><h4 style="display: inline">OBJECTIVE:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    } elseif ($row[2] == 102) {
        echo '</a></br></br><h4 style="display: inline">ASSESSMENT:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    } elseif ($row[2] == 103) {
        echo '</a></br></br><h4 style="display: inline">PLAN:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    } elseif ($row[2] == 104) {
        echo '</a></br></br><h4 style="display: inline">MEDICATION:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    } elseif ($row[2] == 105) {
        echo '</a></br></br><h4 style="display: inline">FOLLOW UP:</h4><a style="font-family: \'Courier New\'; font-size: 10pt">';
    }

    $temp = $row[3];

    echo $temp;
}