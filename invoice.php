<?php require_once('connect.php');
session_start();
$User_ID = $_SESSION['User_ID'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body class="p-3 mb-2 bg-light text-dark">
  <nav class="navbar navbar-dark bg-dark">
    <div class="container"> <a class="navbar-brand" href="#">
        <b> Hotel reservation</b>
      </a>
      <ul class="nav pi-draggable" draggable="true">
        <li class="nav-item">
          <a class="btn btn-danger" type="button" href="logout.php">logout</a>
        </li>
      </ul>
    </div>
  </nav>
    <p></p>
    
        <h1>Invoice</h1>
    
    <div class="container">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Hotel Name</th>
                    
                    <th>Cost</th>
                    <th>Payment Type</th>
                    <th>Start Reserve Date</th>
                    <th>End Reserve Date</th>
                    <th>Payment Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = "select booking.transaction_id,hotel_name,total_cost,payment_type,date_start, date_end, payment_status from
                booking 
                inner join transaction on booking.transaction_id = transaction.transaction_id 
                INNER JOIN hotel ON booking.hotel_id = hotel.hotel_id
                INNER JOIN guest_detail ON booking.guest_id = guest_detail.guest_id
                INNER JOIN user ON user.user_id = guest_detail.user_id
                where user.user_id = '$User_ID' GROUP BY transaction_id;";
                $result = $mysqli->query($q);
                if (!$result) {
                    echo "Select failed. Error: " . $mysqli->error;
                    return false;
                }

                while ($row = $result->fetch_array()) { ?>
                <?php if (!isset($row['payment_status'])) {
                      $row['payment_status'] = "Unpaid";
                    } ?>
                <tr>
                    <td><?= $row['transaction_id'] ?></td>
                    <td><?= $row['hotel_name'] ?></td>
                    <td><?= $row['total_cost'] ?></td>
                    <td><?= $row['payment_type'] ?>
                    <td><?= $row['date_start'] ?></td>
                    <td><?= $row['date_end'] ?></td>
                    <td><?= $row['payment_status'] ?></td>

                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
    </ul> <a class="btn btn-primary" href="main.php">Back</a>
</body>

</html>