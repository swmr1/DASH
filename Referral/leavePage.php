<?php
/**
 * Created by PhpStorm.
 * User: SimInternal
 * Date: 3/5/2019
 * Time: 11:27 AM
 */

echo 'test';
$conReferrals = new mysqli('localhost', $_SESSION['username'], $_SESSION['password'], 'Referrals');

$query = "DELETE FROM Referrals.PagesBeingViewed WHERE ItemId=" . $_GET['id'] . " AND type=1";

$test = $conReferrals->query($query);
$row = $test->fetch_row();
$test->close();

