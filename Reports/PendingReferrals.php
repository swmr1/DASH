<?php
/**
 * Created by PhpStorm.
 * User: SimInternal
 * Date: 12/6/2018
 * Time: 8:05 AM
 */
session_start();
if (sizeof($_SESSION) == 0){
    header('location:../index.html');
}

?>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        border: 1px solid #dddddd;*/
    border: 1px solid #a9a9a9;

        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;

    }
    tr:nth-child(odd) {
        background-color: #FFFFFF;

    }
</style>
<!--<table width="100%">-->
<table id="pending">
    <tbody>
    <tr>
        <th onclick="sortTable1(0)" width="13%">Patient Name</th>
        <th onclick="sortTable1(1)" width="12%">DOB</th>
        <th onclick="sortTable1(2)" width="12%">Referring Provider</th>
        <th onclick="sortTable1(3)" width="12%">Reason</th>
        <th onclick="sortTable1(4)" width="11%">Specialist</th>
        <th onclick="sortTable1(5)" width="12%">Specialist Phone number</th>
        <th onclick="sortTable1(6)" width="12%">Specialty</th>
        <th onclick="sortTable1(7)" width="8%">Date Sent</th>
        <th onclick="sortTable1(8)" width="8%">Priority</th>

    </tr>
    <?php
        $query = 'SELECT * FROM Referrals.Referrals WHERE Status<>"4"';
        $result = $conReferrals->query($query);
        while ($row = $result->fetch_row()){
            $dob = null;
            echo "<tr><td>";
                $query = 'SELECT * FROM Referrals.PatientData WHERE ID="' . $row[2] . '"';
                $temp = $conReferrals->query($query);
                $tr = $temp->fetch_row();
                $id = "" . $tr[1];

                if (strpos($id, "-")){
                    $con = new mysqli('localhost', $_SESSION['username'], $_SESSION['password'], 'Referrals');
                    $query = 'SELECT * FROM dbo.Gen_Demo WHERE Patient_ID=\''. $id . '\'';
                    $temp = mssql_query($query);
                    $tr = mssql_fetch_array($temp);
                    echo $tr[2] . " " . $tr[1];
                    $dob = $tr[21];
                } else {
                    $query = 'SELECT * FROM Referrals.TempPatient WHERE ID="' . $tr[1] . '"';
                    $temp = $conReferrals->query($query);
                    $tr = $temp->fetch_row();
                    echo $tr[1] . " " . $tr[2];
                    $dob = $tr[3];
                }
            echo "</td><td>";
                $date = date_create($dob);
                echo date_format($date, "m/d/Y");
            echo "</td><td>";
                $query = "SELECT * FROM Referrals.Provider WHERE Provider.ID='" . $row[1] . "'";
                $temp = $conReferrals->query($query);
                $tr = $temp->fetch_row();
                echo $tr[1];
            echo "</td><td>";
            echo $row[6];
            echo "</td><td>";
                $query = 'SELECT * FROM Referrals.Specialist WHERE ID="' . $row[9] . '"';
                $temp = $conReferrals->query($query);
                $tr = $temp->fetch_row();
                echo $tr[2];
            echo "</td><td>";
            if(ctype_digit( $tr[4]) && strlen( $tr[4]) == 10) {

                $tr[4] = substr( $tr[4], 0, 3) .'-'. substr( $tr[4], 3, 3) .'-'. substr( $tr[4], 6);
            } else {

                if(ctype_digit( $tr[4]) && strlen( $tr[4]) == 7) {
                    $tr[4] = substr( $tr[4], 0, 3) .'-'. substr( $tr[4], 3, 4);
                }
            }
                echo $tr[4];

            echo "</td><td>";
                $query = 'SELECT * FROM Referrals.Specialty WHERE ID="' . $row[8] . '"';
                $temp = $conReferrals->query($query);
                $tr = $temp->fetch_row();
                echo $tr[1];
            echo "</td><td>";
            if ($row[10] == ""){
                echo "Has not been sent yet";
            } else {
                $date = date_create($row[10]);
                echo date_format($date, "m/d/Y");
            }
            echo "</td><td>";
            switch ($row[4]) {
                case 1:
                    echo 'ASAP';
                    break;

                case 2:
                    echo 'Complete Date';
                    break;

                case 3:
                    echo 'Routine';
                    break;

                case 4:
                    echo 'Patient Referral';
                    break;
            }
            echo "</td></tr>";
        }
    ?>
    </tbody>
</table>
<script>
    function sortTable1(n) {
        var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
        table = document.getElementById("pending");
        switching = true;
        // Set the sorting direction to ascending:
        dir = "asc";
        /* Make a loop that will continue until
        no switching has been done: */
        while (switching) {
            // Start by saying: no switching is done:
            switching = false;
            rows = table.rows;
            /* Loop through all table rows (except the
            first, which contains table headers): */
            for (i = 1; i < (rows.length - 1); i++) {
                // Start by saying there should be no switching:
                shouldSwitch = false;
                /* Get the two elements you want to compare,
                one from current row and one from the next: */
                x = rows[i].getElementsByTagName("TD")[n];
                y = rows[i + 1].getElementsByTagName("TD")[n];
                /* Check if the two rows should switch place,
                based on the direction, asc or desc: */
                if (dir == "asc") {
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                } else if (dir == "desc") {
                    if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                        // If so, mark as a switch and break the loop:
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                /* If a switch has been marked, make the switch
                and mark that a switch has been done: */
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                // Each time a switch is done, increase this count by 1:
                switchcount ++;
            } else {
                /* If no switching has been done AND the direction is "asc",
                set the direction to "desc" and run the while loop again. */
                if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }
    }
</script>

