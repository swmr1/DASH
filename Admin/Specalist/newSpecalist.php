<?php
session_start();

/**
 * Created by PhpStorm.
 * User: SimInternal
 * Date: 11/2/2018
 * Time: 11:56 AM
 */

$con = new mysqli('localhost', $_SESSION['username'], $_SESSION['password'], 'Referrals');
if($con->connect_error){
    header('location:/index.html');
} else {
    $query = 'SELECT * FROM Referrals.Users WHERE UserName="' . $_GET['user'] .'"';
}

$speciality = '<select name="Speciality">';
$query = 'SELECT * FROM Referrals.Specialty';
$result = $con->query($query);
while ($row = $result->fetch_row()){
    $speciality .= "<option value='" . $row[0] . "'> ". $row[1] . "</option>";
}

$speciality .= '</select>';


?>

<!DOCTYPE html>
<html>
<head>
    <!--    <link rel="stylesheet" href="updateForm.css">-->
    <title>DASH</title>
    <style>
        .login-page {
            width: 600px;
            padding: 8% 0 0;
            margin: auto;
        }
        .form {
            position: relative;
            z-index: 1;
            background: #FFFFFF;
            max-width: 600px;
            margin: 0 auto 100px;
            padding: 45px;
            text-align: center;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        .form input {
            font-family: "Roboto", sans-serif;
            outline: 0;
            background: #f2f2f2;
            width: 100%;
            border: 0;
            margin: 0 0 15px;
            padding: 15px;
            box-sizing: border-box;
            font-size: 14px;
        }
        .form button {
            font-family: "Roboto", sans-serif;
            text-transform: uppercase;
            outline: 0;
            background: #4CAF50;
            width: 100%;
            border: 0;
            padding: 15px;
            color: #FFFFFF;
            font-size: 14px;
            -webkit-transition: all 0.3 ease;
            transition: all 0.3 ease;
            cursor: pointer;
        }
        .form button:hover,.form button:active,.form button:focus {
            background: #43A047;
        }
        .form .message {
            margin: 15px 0 0;
            color: #b3b3b3;
            font-size: 12px;
        }
        .form .message a {
            color: #4CAF50;
            text-decoration: none;
        }
        .form .register-form {
            display: none;
        }
        .container {
            position: relative;
            z-index: 1;
            max-width: 600px;
            margin: 0 auto;
        }
        .container:before, .container:after {
            content: "";
            display: block;
            clear: both;
        }
        .container .info {
            margin: 50px auto;
            text-align: center;
        }
        .container .info h1 {
            margin: 0 0 15px;
            padding: 0;
            font-size: 36px;
            font-weight: 300;
            color: #1a1a1a;
        }
        .container .info span {
            color: #4d4d4d;
            font-size: 12px;
        }
        .container .info span a {
            color: #000000;
            text-decoration: none;
        }
        .container .info span .fa {
            color: #EF3B3A;
        }
        body {
            background: #76b852; /* fallback for old browsers */
            background: -webkit-linear-gradient(right, #76b852, #8DC26F);
            background: -moz-linear-gradient(right, #76b852, #8DC26F);
            background: -o-linear-gradient(right, #76b852, #8DC26F);
            background: linear-gradient(to left, #76b852, #8DC26F);
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

    </style>
</head>
<div class="login-page">
    <div class="form">
        <form action="Specilist.php" class="login-form">
            <table width="100%">
                <tbody>
                <tr>
                    <td width="50%">
                        <input type="text" name="DrName" placeholder="Dr Name">
                    </td>
                    <td width="50%">
                        Speciality <?php echo $speciality?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="text" name="address" placeholder="Address">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="phone" placeholder="Phone Number">
                    </td>
                    <td>
                        <input type="text" name="fax" placeholder="Fax Number">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <textarea id="note" name="note" placeholder="Notes" style="height: 50px; width: 100%;"></textarea>
                    </td>
                </tr>
                </tbody>
            </table>
            <button>Submit</button>
        </form>
    </div>
</div>
</html>