<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>

<canvas id="myChart" width="400" height="150"></canvas>

<?php


$labels = array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");;
$dataSet1 = [];
$dataSet2 = [];


for ($i = 1; $i < COUNT($labels); $i++) {
    $total = 0;
    $cyear = date("Y");
    $query = "SELECT SUM(price*quantity) AS 'total' FROM expenses WHERE MONTH(created_at) = '" . $i . "' AND YEAR(created_at) = '" . $cyear . "'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $total = $row["total"] ? $row["total"] : 0;
        }
    }

    array_push($dataSet1, $total);


    $total = 0;
    $query = "SELECT SUM(price*quantity) AS 'total' FROM order_items WHERE MONTH(created_at) = '" . $i . "' AND YEAR(created_at) = '" . $cyear . "'";
    $result = mysqli_query($connect, $query);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $total = $row["total"] ? $row["total"] : 0;
        }
    }
    array_push($dataSet2, $total);
}

?>



<script id="result-data1" type="application/json">
    <?= json_encode($dataSet1) ?>
</script>

<script id="result-data2" type="application/json">
    <?= json_encode($dataSet2) ?>
</script>

<script id="result-labels" type="application/json">
    <?= json_encode($labels) ?>
</script>

<script>
    var resultLabels = JSON.parse(document.getElementById('result-labels').textContent);
    var resultData1 = JSON.parse(document.getElementById('result-data1').textContent);
    var resultData2 = JSON.parse(document.getElementById('result-data2').textContent);

    //console.log(resultLabels);
    //console.log(resultData);

    if (document.getElementById("myChart")) {
        var labels = resultLabels;
        var dataSet1 = resultData1;
        var dataSet2 = resultData2;
        loadChart(labels, dataSet1, dataSet2);
    }

    function loadChart(labels, dataSet1, dataSet2) {
        const data = {
            labels: labels,
            datasets: [{
                    label: 'Expenses',
                    data: dataSet1,
                    backgroundColor: "red",
                    borderColor: "red"
                },
                {
                    label: 'Sales',
                    data: dataSet2,
                    backgroundColor: "blue",
                    borderColor: "blue"
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Sales & Expenses'
                    }
                }
            },
        };

        const ctx = document.getElementById('myChart').getContext('2d');

        const myChart = new Chart(ctx, config);
    }
</script>

<?php
