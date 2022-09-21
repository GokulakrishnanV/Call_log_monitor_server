<!DOCTYPE html>
<html>

<head>
    <title>Home Page</title>
    <link rel="icon" href="<?= base_url() ?>images/favicon.ico" type="image/ico">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
</head>

<body>
    <table border="1" style="width:80%;" align="center">
        <tr>
            <th>Id</th>
            <th>Username</th>
            <th>Caller name</th>
            <th>Caller number</th>
            <th>Call duration</th>
            <th>Call type</th>
            <th>Date and Time</th>
        </tr>
        <?php
        //print_r($result->result());
        foreach ($result->result() as $user_data) {
            echo "<tr>";
            echo "<td>" . $user_data->id . "</td>";
            echo "<td>" . $user_data->user_name . "</td>";
            echo "<td>" . $user_data->caller_name . "</td>";
            echo "<td>" . $user_data->caller_number . "</td>";
            echo "<td>" . $user_data->call_duration . "</td>";
            echo "<td>" . $user_data->call_type . "</td>";
            echo "<td>" . $user_data->date_time . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

</body>


</html>