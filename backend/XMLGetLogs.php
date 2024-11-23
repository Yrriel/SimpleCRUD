<?php

$host = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "websitedb";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);
    if($conn -> connect_error){
        die("Connection failed: ". $conn->connect_error);
    }


$rows = mysqli_query($conn, "SELECT * FROM `logs` ORDER BY `time` DESC");

?>
<style>

    .tablee{
        border-collapse:collapse;
        width: 100%;
    }

    .tr-rows{
        cursor: pointer;
        height: 40px;
    }
    .tr-rows td{
        color:white;
    }

    .tr-rows:hover{
        background-color: rgba(0, 0, 0, .7);
    }

    .td-center{
        text-align: center;
    }


    thead td{
        text-align: center;
        
    }

    .tablee tbody:nth-of-type(odd){
        background-color: rgba(0, 0, 0, .2);
    }

    /* ------sticky-------- */

    .tablee th{
        background: rgba(0, 0, 0,.8);
        color: #fff;
        height: 50px;
        position: sticky;
        top: 0;
    }
    
    .td-small{
        font-size: 12px;
        
    }

</style>

<table class="tablee" border = 1 cellpadding = 10>
    <thead>
        <tr>
                <th>Time</th>
                <th>Username</th>
                <th>Action</th>         
        </tr>
    </thead>
    <?php foreach($rows as $row) :?>
    <tbody>
    <tr class="tr-rows">
        <td class="td-small"><?php echo $row["time"] ?></td>
        <td class="td-center"><?php echo $row["username"] ?></td>
        <td class="td-center"><?php echo $row["action"] ?></td>    
    </tr>
    </tbody>
    </a>
    <?php endforeach; ?>
</table>