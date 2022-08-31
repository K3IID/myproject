<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>

<?php
function getPostData($name)
{
    if (isset($_POST[$name])) {
        return $_POST[$name];
    }
    return "";
}
?>

<?php

$type = getPostData("type");
$dateFrequency = getPostData("dateFrequency");
$startDate = getPostData("startDate");
$endDate = getPostData("endDate");

$labels = [];
$data = [];

?>


<?php
if ($type == "Sales") {
?>
    <canvas id="myChart" width="400" height="100"></canvas>

    <?php
    if ($dateFrequency == "Yearly") {
        $cyear = date("Y");
        for ($i = 4; $i >= 0; $i--) {
            $total = 0;
            $newyear = $cyear - $i;
            $query = "SELECT SUM(price*quantity) AS 'total' FROM order_items WHERE YEAR(created_at) = '" . $newyear . "'";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $total = $row["total"] ? $row["total"] : 0;
                }
            }
            array_push($labels, $newyear);
            array_push($data, $total);
        }
    }

    if ($dateFrequency == "Quarterly") {
        $cyear = date("Y");
        for ($i = 1; $i < 5; $i++) {
            $total = 0;
            $query = "SELECT SUM(price*quantity) AS 'total' FROM order_items WHERE QUARTER(created_at) = '" . $i . "' AND YEAR(created_at) = '" . $cyear . "'";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $total = $row["total"] ? $row["total"] : 0;
                }
            }
            array_push($labels, "Q" . $i);
            array_push($data, $total);
        }
    }

    if ($dateFrequency == "Monthly") {
        $cyear = date("Y");
        $months = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");
        for ($i = 1; $i < COUNT($months); $i++) {
            $total = 0;
            $query = "SELECT SUM(price*quantity) AS 'total' FROM order_items WHERE MONTH(created_at) = '" . $i . "' AND YEAR(created_at) = '" . $cyear . "'";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $total = $row["total"] ? $row["total"] : 0;
                }
            }
            array_push($labels, $months[$i - 1]);
            array_push($data, $total);
        }
    }

    if ($dateFrequency == "Daily") {
        $cyear = date("Y");


        $period = new DatePeriod(
            new DateTime($startDate),
            new DateInterval('P1D'),
            new DateTime($endDate . " 23:59:59")
        );

        foreach ($period as $key => $value) {
            $total = 0;
            $query = "SELECT DATE(created_at) AS 'date', SUM(price*quantity) AS 'total' FROM order_items 
            WHERE STR_TO_DATE('" . $value->format('Y-m-d')  . "', '%Y-%m-%d') = DATE(created_at)";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result)) {
                    $total = $row["total"] ? $row["total"] : 0;
                }
            }
            array_push($labels, $value->format('Y-m-d'));
            array_push($data, $total);
        }
    }
}

if ($type == "Fast & Slow Moving Products") {
    ?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name(Top 5 Fast Moving) </th>
                    <th scope="col">Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.name, SUM(oi.price * oi.quantity) as 'total' FROM order_items oi
                LEFT JOIN tbl_product p ON oi.item_id = p.id
                WHERE STR_TO_DATE('" . $startDate . "', '%Y-%m-%d') <= DATE(oi.created_at)
                AND STR_TO_DATE('" . $endDate . "', '%Y-%m-%d') >= DATE(oi.created_at) 
                GROUP BY oi.item_id
                ORDER BY total DESC
                LIMIT 5";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    $ctr = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $ctr++;
                ?>
                        <tr>
                            <th scope="row"><?= $ctr ?></th>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["total"] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>

            </tbody>
        </table>
    </div>


    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name(Top 5 Slow Moving)</th>
                    <th scope="col">Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.name, SUM(oi.price * oi.quantity) as 'total' FROM order_items oi
                LEFT JOIN tbl_product p ON oi.item_id = p.id
                WHERE STR_TO_DATE('" . $startDate . "', '%Y-%m-%d') <= DATE(oi.created_at)
                AND STR_TO_DATE('" . $endDate . "', '%Y-%m-%d') >= DATE(oi.created_at) 
                GROUP BY oi.item_id
                ORDER BY total ASC
                LIMIT 5";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    $ctr = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $ctr++;
                ?>
                        <tr>
                            <th scope="row"><?= $ctr ?></th>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["total"] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
}

if ($type == "Top 5 Customers") {
?>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Customer Name</th>
                    <th scope="col">Total Sales</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT b.username, oi.buyer_username, SUM(oi.price * oi.quantity) as 'total' FROM order_items oi
                LEFT JOIN buyer b ON b.username = oi.buyer_username
                WHERE STR_TO_DATE('" . $startDate . "', '%Y-%m-%d') <= DATE(oi.created_at)
                AND STR_TO_DATE('" . $endDate . "', '%Y-%m-%d') >= DATE(oi.created_at) 
                GROUP BY oi.buyer_username
                ORDER BY total DESC
                LIMIT 5";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    $ctr = 0;
                    while ($row = mysqli_fetch_array($result)) {
                        $ctr++;
                ?>
                        <tr>
                            <th scope="row"><?= $ctr ?></th>
                            <td><?= $row["username"] ? $row["username"] : $row["buyer_username"] ?></td>
                            <td><?= $row["total"] ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
<?php
}


if ($type == "Farmers' Exchanges") {
?>
    <canvas id="myChart" width="400" height="100"></canvas>
<?php
    $cyear = date("Y");


    $total = 0;
    $query = "SELECT buyer_username_from, COUNT(*) AS 'total' FROM exchange 
        WHERE STR_TO_DATE('" . $startDate . "', '%Y-%m-%d') <= DATE(created_at)
        AND STR_TO_DATE('" . $endDate . "', '%Y-%m-%d') >= DATE(created_at) 
        GROUP BY buyer_username_from";

    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $total = $row["total"] ? $row["total"] : 0;

            array_push($labels, $row["buyer_username_from"]);
            array_push($data, $total);
        }
    }
}
?>

<script id="result-data" type="application/json">
    <?= json_encode($data) ?>
</script>

<script id="result-labels" type="application/json">
    <?= json_encode($labels) ?>
</script>

<script>
    var resultLabels = JSON.parse(document.getElementById('result-labels').textContent);
    var resultData = JSON.parse(document.getElementById('result-data').textContent);


    console.log(resultLabels);
    console.log(resultData);

    if (document.getElementById("myChart")) {
        var labels = resultLabels;
        var data = resultData;
        loadChart(labels, data);
    }

    function loadChart(labels, data) {
        const ctx = document.getElementById('myChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: "<?= $type ?>",
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>

<?php
