<?php
/**
 * Created by PhpStorm.
 * User: SimInternal
 * Date: 1/11/2019
 * Time: 12:00 PM
 */


include ('../fetchPatientData/patientInfo.php');

session_start();

$patientInfo = new Patient;
$patientInfo->SelectPatient($_SESSION['currentPatient']);

$conReferrals = new mysqli('localhost', $_SESSION['username'], $_SESSION['password'], 'Referrals');

$groupValue = 0;

if ($_GET['message'] == ''){
    header($_SESSION['previous']);
    die;
} else {
    //TODO add to Change log
    $toSend = str_replace("'", "\'",$_GET['message']);
    $toSend = str_replace('"', '\"', $toSend);
    echo $toSend;
    $query = 'INSERT INTO MessageAboutPatient(PatientID, UserID, Message, UserGroup) values (\'' . $_SESSION['currentPatient'] . '\', \'' . $_SESSION['name'] . '\', \'' . $toSend . '\',\'' . $_SESSION['group'] . '\')';

}

$result = $conReferrals->query($query);

echo $conReferrals->error;


$_SESSION['previous'] = "location:/patientInfo/Patient.php?last=" . $patientInfo->GetLastName() . "&date=" . $patientInfo->GetDOB();

header($_SESSION['previous']);
