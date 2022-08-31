<?php
session_start();
$connect = mysqli_connect("localhost", "root", "", "iagri");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>I-Agri</title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <link href="../common/css/bootstrap.css" rel="stylesheet">
    <link href="../common/css/bootstrap.min.css" rel="stylesheet">
    <link href="../common/css/styles.css" rel="stylesheet" />
    <link href="../common/css/index.css" rel="stylesheet" />

    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

</head>
<!-- Header -->

<body>
    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>

    <br>

    <div class="card bg-body container p-4">
        <h2>Dashboard</h2>

        <div class="container row m-0 p-0 d-flex justify-content-between">
            <div class="card bg-info m-1" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title fw-bolder" id="lblTotalSales">$ 101.00</h1>
                    <p class="card-text fw-normal text-light">Total Sales</p>
                </div>
            </div>

            <div class="card bg-success m-1" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title fw-bolder" id="lblNumberOfProducts">$ 101.00</h1>
                    <p class="card-text fw-normal text-light">Number of Products</p>
                </div>
            </div>

            <div class="card bg-warning m-1" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title fw-bolder" id="lblNumberOfUsers">$ 101.00</h1>
                    <p class="card-text fw-normal text-light">Number of Users</p>
                </div>
            </div>

            <div class="card bg-danger m-1" style="width: 18rem;">
                <div class="card-body">
                    <h1 class="card-title fw-bolder" id="lblSalesToday">$ 101.00</h1>
                    <p class="card-text fw-normal text-light">Sales Today</p>
                </div>
            </div>

        </div>

        <br>

        <div class="card bg-body container">
            <div class="container d-flex justify-content-end m-3">

                <select class="form-control col-2 text-center m-2" id="selectChartType">
                    <option>Sales</option>
                    <option>Fast & Slow Moving Products</option>
                    <option>Top 5 Customers</option>
                    <option>Farmers' Exchanges</option>
                </select>

                <select class="form-control col-2 text-center m-2" id="selectDateFrequency">
                    <option>Yearly</option>
                    <option>Quarterly</option>
                    <option>Monthly</option>
                    <option>Daily</option>
                </select>

                <input id="dateRangeFilter" type="text" class="form-control col-2 m-2" name="daterange" value="" />
            </div>

            <div id="divChart">

            </div>


        </div>


    </div>



    <br>
    <br>
    <br>






















    <!-- Footer -->
    <?php include 'include/footer.php'; ?>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>

    <script>
        var filterStartDate = moment().startOf('month').format('YYYY-MM-DD');
        var filterEndDate = moment().format('YYYY-MM-DD');


        $(function() {
            /* $('#dateRangeFilter').daterangepicker({
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            }); */

            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                console.log("set");
                $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });

            $('input[name="daterange"]').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            }, function(start, end, label) {
                filterStartDate = start.format('YYYY-MM-DD');
                filterEndDate = end.format('YYYY-MM-DD');

                setChart(document.getElementById("selectChartType").value);

                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });

            $('input[name="daterange"]').val(moment(filterStartDate).format("MM/DD/YYYY") + " - " + moment(filterEndDate).format("MM/DD/YYYY"));

            $('input[name="daterange"]').data('daterangepicker').setStartDate(moment(filterStartDate).format("MM/DD/YYYY"));
            $('input[name="daterange"]').data('daterangepicker').setEndDate(moment(filterEndDate).format("MM/DD/YYYY"));

            /* $('input[name="daterange"]').daterangepicker({
                startDate: moment().startOf('month').format('MM/DD/YYYY'),
                endDate: moment().format('MM/DD/YYYY')
            }); */


        });
    </script>

    <script>
        function setChartSelects(type) {

            if (type == "Sales") {
                document.getElementById("dateRangeFilter").hidden = true;
                document.getElementById("selectDateFrequency").hidden = false;
                if (document.getElementById("selectDateFrequency").value == "Daily") {
                    document.getElementById("dateRangeFilter").hidden = false;
                }
            }

            if (type == "Fast & Slow Moving Products") {
                document.getElementById("dateRangeFilter").hidden = false;
                document.getElementById("selectDateFrequency").hidden = true;
            }

            if (type == "Top 5 Customers") {
                document.getElementById("dateRangeFilter").hidden = false;
                document.getElementById("selectDateFrequency").hidden = true;
            }

            if (type == "Farmers' Exchanges") {
                document.getElementById("dateRangeFilter").hidden = false;
                document.getElementById("selectDateFrequency").hidden = true;
            }
        }

        function setChart(type) {

            var url = "request_chart.php";
            setChartSelects(type);

            $.ajax({
                url: url,
                type: 'post',
                data: {
                    type: type,
                    dateFrequency: $("#selectDateFrequency").val(),
                    startDate: filterStartDate,
                    endDate: filterEndDate
                },
                success: function(data) {
                    $("#divChart").html('');
                    $("#divChart").html(data.trim());

                },
                error: function(e) {
                    console.log('Get user error.');
                }
            });
        }


        function getTotals() {
            var url = "request_totals.php";
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {

                },
                success: function(data) {
                    $("#lblTotalSales").text(data.totalSales);
                    $("#lblNumberOfProducts").text(data.totalProducts);
                    $("#lblNumberOfUsers").text(data.totalUsers);
                    $("#lblSalesToday").text(data.totalSalesToday);


                },
                error: function(e) {
                    console.log('Get user error.');
                }
            });
        }

        getTotals();
        setChart(document.getElementById("selectChartType").value);

        document.getElementById("selectChartType").onchange = function() {
            setChart(this.value);
        };

        document.getElementById("selectDateFrequency").onchange = function() {
            setChart(document.getElementById("selectChartType").value);
        };
    </script>

</body>

</html>