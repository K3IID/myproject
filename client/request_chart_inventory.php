<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>

<canvas id="myChart" width="400" height="150"></canvas>

<?php


$labels = [];
$data = [];


$query = "SELECT name,SUM(p.quantity), SUM(oi.quantity), SUM(p.quantity) - SUM(oi.quantity) as 'total' FROM tbl_product p
            LEFT JOIN order_items oi ON oi.item_id = p.id
            GROUP BY p.id, oi.item_id";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_array($result)) {
        $total = $row["total"] ? $row["total"] : 0;
        array_push($labels, $row["name"]);
        array_push($data, $total);
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


    //console.log(resultLabels);
    //console.log(resultData);

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
                    label: 'Stocks',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y',
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
