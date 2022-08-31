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
</head>
<!-- Header -->

<body>
    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>

    <br>

    <div class="card bg-body container p-4">
        <h2>SALES & EXPENSES</h2>

        <div class="container col-12">
            <div class="col-12 mt-4" id="divChart">
                <canvas id="myChart" width="400" height="200"></canvas>
            </div>
            <br>
            <br>
            <div class="col-12">
                <h4>EXPENSES</h4>

                <div class="container table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody id="tbody_Expenses">
                            <tr>
                                <th scope="row">1</th>
                                <td>Mark</td>
                                <td>Otto</td>
                                <td>@mdo</td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                <div class="container col-6 d-flex justify-content-start">
                    <label class="col-6 m-1">Name</label>
                    <label class="col-3 m-1">Qty.</label>
                    <label class="col-5 m-1">Price</label>

                </div>
                <form class="container col-6" id="divStocks" action="javascript:void(0);">
                    <div class="container d-flex justify-content-start">
                        <input type="text" class="form-control col-6 m-1" id="txtName" name="txtName" />
                        <input type="number" class="form-control col-3 m-1" min="0" id="txtQuantity" name="txtQuantity" />
                        <input type="number" class="form-control col-4 m-1" min="0" id="txtPrice" name="txtPrice" />

                    </div>
                    <div class="container d-flex justify-content-between col-6 m-1">
                        <button class="btn btn-success col-5" id="btnSave">Save</button>
                    </div>
                </form>

            </div>

            <div class="col-6">
                <canvas id="myChart" width="400" height="400"></canvas>
            </div>
        </div>

    </div>






    <br>
    <br>
    <br>


    <!-- Footer -->
    <?php include 'include/footer.php'; ?>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.0/dist/chart.min.js"></script>

</body>

</html>


<script>
    function setChart() {

        var url = "request_chart_sales_expenses.php";

        $.ajax({
            url: url,
            type: 'post',
            data: {},
            success: function(data) {
                $("#divChart").html('');
                $("#divChart").html(data.trim());

            },
            error: function(e) {
                console.log('Get user error.');
            }
        });
    }

    var expenses = [{
        "id": "",
        "name": "",
        "price": "",
        "quantity": ""
    }];


    getExpenses();
    setChart();

    function getExpenses() {
        var url = "request_getExpenses.php";
        $.ajax({
            url: url,
            type: 'post',
            data: {},
            //dataType: 'json',
            success: function(data) {
                $("#tbody_Expenses").html('');
                $("#tbody_Expenses").html(data.trim());
            },
            error: function(e) {
                console.log(e);
            }
        });

    }


    function modifyExpenses() {
        var url = "request_modifyExpenses.php";
        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(document.getElementById('divStocks')),
            //dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                getExpenses();
                setChart();
                $("#txtName").val("");
                $("#txtPrice").val("");
                $("#txtQuantity").val("");
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    document.getElementById("btnSave").onclick = function() {
        modifyExpenses();
    };
</script>