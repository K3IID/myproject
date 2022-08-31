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
        <h2>INVENTORY</h2>

        <div class="col-12 mt-4" id="divChart">
            <canvas id="myChart" width="400" height="200"></canvas>
        </div>
        <br>
        <br>
        <div class="container col-12 d-flex justify-content-between">
            <div class="col-3">
                <h4>INPUT STOCKS</h4>
                <div class="container d-flex justify-content-start">
                    <label class="col-3 m-1">Qty.</label>
                    <label class="col-5 m-1">Price</label>
                    <label class="col-4 m-1">SKU</label>
                    <label class="col-6 m-1">Unit</label>
                    <label class="col-6 m-1">Name</label>
                    <label class="col-6 m-1">Image File</label>
                </div>
                <form class="container" id="divStocks" action="javascript:void(0);">
                    <div class="container d-flex justify-content-start">
                        <input type="number" class="form-control col-3 m-1" min="0" id="txtQuantity" />
                        <input type="number" class="form-control col-4 m-1" min="0" id="txtPrice" />
                        <input type="text" class="form-control col-6 m-1" id="txtName" />
                    </div>

                </form>
                <div class="container d-flex justify-content-between col-12 m-1">
                    <button class="btn btn-success col-5" id="btnAdd">Add</button>
                    <button class="btn btn-success col-5" id="btnSave">Save</button>
                </div>
            </div>

            <div class="col-6">

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
    var products = [{
        "id": "",
        "name": "",
        "price": "",
        "quantity": ""
    }];

    setChart();

    function setChart() {

        var url = "request_chart_inventory.php";

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

    function updateProductValues() {
        var ctr = 0;
        products.forEach(data => {
            products[ctr].name = document.getElementById("txtProductName" + ctr).value;
            products[ctr].quantity = document.getElementById("txtProductQty" + ctr).value;
            products[ctr].price = document.getElementById("txtProductPrice" + ctr).value;
            ctr++;
        });
    }

    function addProduct() {
        updateProductValues();
        products.push({
            "id": "",
            "name": "",
            "price": "",
            "quantity": ""
        });
        loadProducts();
    }
    getProducts();

    function getProducts() {
        var url = "request_getProducts.php";
        $.ajax({
            url: url,
            type: 'post',
            data: {},
            dataType: 'json',
            success: function(data) {
                console.log(data);
                products = data;
                loadProducts();
            },
            error: function(e) {
                console.log(e);
            }
        });

    }

    function removeProduct(index) {
        updateProductValues();
        products.splice(index, 1);
        loadProducts();
    }

    function loadProducts() {
        var parentElement = document.getElementById("divStocks");
        parentElement.innerHTML = "";

        var ctr = 0;
        products.forEach(data => {
            /* WHOLE ROW */
            var childDiv = document.createElement("div");
            childDiv.className = "container d-flex justify-content-start";
            childDiv.id = "divProduct" + ctr;

            var childInputHiddenText = document.createElement("input");
            childInputHiddenText.type = "hidden";
            childInputHiddenText.name = "txtProductId" + ctr;
            childInputHiddenText.value = data.id;
            childDiv.appendChild(childInputHiddenText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-3 m-1";
            childInputText.type = "number";
            childInputText.min = "0";
            childInputText.id = "txtProductQty" + ctr;
            childInputText.name = "txtProductQty" + ctr;
            childInputText.value = data.quantity;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-5 m-1";
            childInputText.type = "number";
            childInputText.min = "0";
            childInputText.id = "txtProductPrice" + ctr;
            childInputText.name = "txtProductPrice" + ctr;
            childInputText.value = data.price;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-4 m-1";
            childInputText.id = "txtProductSKU" + ctr;
            childInputText.name = "txtProductSKU" + ctr;
            childInputText.value = data.sku;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("select");
            childInputText.className = "form-control col-6 m-1";
            childInputText.id = "txtProductUnit" + ctr;
            childInputText.name = "txtProductUnit" + ctr;
            //childInputText.value = data.unit;
            var units = ["per Kilo", "per Half Kilo", "per Sack", "per Box", "per Crate"];
            units.forEach(value => {
                var opt = document.createElement("option");
                opt.value = value;
                opt.innerText = value;
                if (data.unit == value) {
                    opt.selected = true;
                }
                childInputText.appendChild(opt);
            });
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-7 m-1";
            childInputText.id = "txtProductName" + ctr;
            childInputText.name = "txtProductName" + ctr;
            childInputText.value = data.name;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.type = "file";
            childInputText.accept = "image/*";
            childInputText.className = "form-control col-12 m-1";
            childInputText.id = "txtProductFile" + ctr;
            childInputText.name = "txtProductFile" + ctr;
            childDiv.appendChild(childInputText);


            parentElement.appendChild(childDiv);
            ctr++;
        });
    }

    function modifyProducts() {
        updateProductValues();
        var url = "request_modifyProducts.php";
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
                getProducts();
                loadProducts();
            },
            error: function(e) {
                console.log(e);
            }
        });
    }

    document.getElementById("btnAdd").onclick = function() {
        addProduct();
    };
    document.getElementById("btnSave").onclick = function() {
        modifyProducts();
    };
</script>