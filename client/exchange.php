<?php
session_start();
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
</head>
<!-- Header -->

<body>
    <!-- Navbar -->
    <?php include 'include/navbar.php'; ?>

    <br>

    <div class="card bg-body container p-4">
        <h2>EXCHANGE</h2>

        <div class="container d-flex justify-content-between">
            <div class="container col-5 table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Requestor</th>
                            <th scope="col">Approver</th>
                            <th scope="col">Date</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_Exchanges">
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>Otto</td>
                            <td>@mdo</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="container col-7">
                <form action="javascript:void(0);" id="formExchange" class="container d-flex justify-content-between col-12">
                    <input type="hidden" class="form-control col-5" id="hiddenExchangeId" name="hiddenExchangeId" />
                    <input type="hidden" class="form-control col-5" id="hiddenAction" name="hiddenAction" value="new" />
                    <div class="container col-6 m-0 p-1">
                        <label>Requestor</label>
                        <input id="fromBuyer" name="fromBuyer" type="text" class="form-control" value="<?= isset($_SESSION['username']) ? $_SESSION['username'] : 'NOT LOGGED IN' ?>" readonly />

                        <div class="container p-0 m-0" id="divFromProducts">
                            <div class="container d-flex justify-content-between p-0 mt-1">
                                <input type="text" class="form-control col-5" />
                                <input type="number" class="form-control col-3" />
                                <select class="form-control col-3">
                                    <option>per Kilo</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-success m-1" id="btnAddFromItem">
                            Add
                        </button>
                    </div>


                    <div class="container col-6 m-0 p-1">
                        <label>Approver</label>
                        <input id="toBuyer" name="toBuyer" list="buyers" type="text" class="form-control" value="" />
                        <datalist id="buyers">
                            <option value="Edge">
                        </datalist>

                        <div class="container p-0 m-0" id="divToProducts">
                            <div class="container d-flex justify-content-between p-0 mt-1">
                                <input type="text" class="form-control col-5" />
                                <input type="number" class="form-control col-3" />
                                <select class="form-control col-3">
                                    <option>per Kilo</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-success m-1" id="btnAddToItem">
                            Add
                        </button>
                    </div>
                </form>

                <div class="container col-12">
                    <button class="btn btn-success" id="btnNew">New Request</button>
                    <button class="btn btn-success" id="btnSend">Send Request</button>
                    <button class="btn btn-success" id="btnApprove" hidden>Approve Request</button>
                </div>
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
</body>


<script>
    var fromItems = [{
        "id": "",
        "product_name": "",
        "product_unit": "per Kilo",
        "quantity": "0"
    }];

    var toItems = [{
        "id": "",
        "product_name": "",
        "product_unit": "per Kilo",
        "quantity": "0"
    }];



    function getBuyers() {
        $.ajax({
            url: "request_getBuyers.php",
            type: 'post',
            data: {},
            success: function(data) {
                $("#buyers").html('');
                $("#buyers").html(data.trim());

            },
            error: function(e) {
                console.log('Get user error.');
            }
        });
    }

    function getExchanges() {
        $.ajax({
            url: "request_getExchanges.php",
            type: 'post',
            data: {},
            success: function(data) {
                $("#tbody_Exchanges").html('');
                $("#tbody_Exchanges").html(data.trim());

            },
            error: function(e) {
                console.log('Get user error.');
            }
        });
    }

    function getExchangeItems(exchangeId) {
        document.getElementById("hiddenAction").value = "approve";
        document.getElementById("btnSend").hidden = true;
        document.getElementById("btnApprove").hidden = false;
        $.ajax({
            url: "request_exchangeItems.php",
            type: 'post',
            dataType: 'json',
            data: {
                exchangeId: exchangeId
            },
            success: function(data) {
                console.log(data);
                $("#fromBuyer").val(data[0].from_buyer);
                $("#toBuyer").val(data[0].to_buyer);
                fromItems = data[0].fromItems;
                toItems = data[0].toItems;
                $("#hiddenExchangeId").val(data[0].id);

                loadProducts();

                document.getElementById("toBuyer").readOnly = true;
                document.getElementById("btnAddFromItem").hidden = true;
                document.getElementById("btnAddToItem").hidden = true;

                $("#formExchange :input").prop("readOnly", true);
                $("select").prop("disabled", true);

                if (data[0].status == "APPROVED") {
                    document.getElementById("btnApprove").disabled = true;
                } else {
                    if (data[0].own == "true") {
                        document.getElementById("btnApprove").disabled = false;
                    } else {
                        document.getElementById("btnApprove").disabled = true;
                    }

                }

            },
            error: function(e) {
                console.log('Get user error.');
            }
        });
    }

    function updateProductValues() {
        var ctr = 0;
        fromItems.forEach(data => {
            fromItems[ctr].product_name = document.getElementById("txtFromProductName" + ctr).value;
            fromItems[ctr].product_unit = document.getElementById("txtFromProductUnit" + ctr).value;
            fromItems[ctr].quantity = document.getElementById("txtFromProductQuantity" + ctr).value;
            ctr++;
        });

        ctr = 0;
        toItems.forEach(data => {
            toItems[ctr].product_name = document.getElementById("txtToProductName" + ctr).value;
            toItems[ctr].product_unit = document.getElementById("txtToProductUnit" + ctr).value;
            toItems[ctr].quantity = document.getElementById("txtToProductQuantity" + ctr).value;
            ctr++;
        });
    }

    function addProduct(type) {
        updateProductValues();
        if (type == "requestor") {
            fromItems.push({
                "id": "",
                "product_name": "",
                "product_unit": "",
                "quantity": ""
            });
        }

        if (type == "approver") {
            toItems.push({
                "id": "",
                "product_name": "",
                "product_unit": "",
                "quantity": ""
            });
        }

        loadProducts();
    }

    loadProducts();

    function loadProducts() {
        var parentElement = document.getElementById("divFromProducts");
        parentElement.innerHTML = "";

        var ctr = 0;
        fromItems.forEach(data => {
            /* WHOLE ROW */
            var childDiv = document.createElement("div");
            childDiv.className = "container d-flex justify-content-between p-0 mt-1";
            childDiv.id = "divFromProduct" + ctr;

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-5";
            childInputText.type = "text";
            childInputText.id = "txtFromProductName" + ctr;
            childInputText.name = "txtFromProductName" + ctr;
            childInputText.value = data.product_name;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-3";
            childInputText.type = "number";
            childInputText.min = "0";
            childInputText.id = "txtFromProductQuantity" + ctr;
            childInputText.name = "txtFromProductQuantity" + ctr;
            childInputText.value = data.quantity;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("select");
            childInputText.className = "form-control col-3";
            childInputText.id = "txtFromProductUnit" + ctr;
            childInputText.name = "txtFromProductUnit" + ctr;
            //childInputText.value = data.unit;
            var units = ["per Kilo", "per Half Kilo", "per Sack", "per Box", "per Crate"];
            units.forEach(value => {
                var opt = document.createElement("option");
                opt.value = value;
                opt.innerText = value;
                if (data.product_unit == value) {
                    opt.selected = true;
                }
                childInputText.appendChild(opt);
            });
            childDiv.appendChild(childInputText);

            parentElement.appendChild(childDiv);
            ctr++;
        });


        parentElement = document.getElementById("divToProducts");
        parentElement.innerHTML = "";
        ctr = 0;
        toItems.forEach(data => {
            /* WHOLE ROW */
            var childDiv = document.createElement("div");
            childDiv.className = "container d-flex justify-content-between p-0 mt-1";
            childDiv.id = "divToProduct" + ctr;

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-5";
            childInputText.type = "text";
            childInputText.id = "txtToProductName" + ctr;
            childInputText.name = "txtToProductName" + ctr;
            childInputText.value = data.product_name;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("input");
            childInputText.className = "form-control col-3";
            childInputText.type = "number";
            childInputText.min = "0";
            childInputText.id = "txtToProductQuantity" + ctr;
            childInputText.name = "txtToProductQuantity" + ctr;
            childInputText.value = data.quantity;
            childDiv.appendChild(childInputText);

            /* TEXTBOX */
            var childInputText = document.createElement("select");
            childInputText.className = "form-control col-3";
            childInputText.id = "txtToProductUnit" + ctr;
            childInputText.name = "txtToProductUnit" + ctr;
            //childInputText.value = data.unit;
            var units = ["per Kilo", "per Half Kilo", "per Sack", "per Box", "per Crate"];
            units.forEach(value => {
                var opt = document.createElement("option");
                opt.value = value;
                opt.innerText = value;
                if (data.product_unit == value) {
                    opt.selected = true;
                }
                childInputText.appendChild(opt);
            });
            childDiv.appendChild(childInputText);

            parentElement.appendChild(childDiv);
            ctr++;
        });
    }

    document.getElementById("btnAddFromItem").onclick = function() {
        addProduct("requestor");
    };

    document.getElementById("btnAddToItem").onclick = function() {
        addProduct("approver");
    };



    document.getElementById("btnSend").onclick = function() {
        modifyProducts();
    };

    document.getElementById("btnApprove").onclick = function() {
        modifyProducts();
    };


    function resetFields() {
        $("#formExchange :input").prop("readOnly", false);
        $("select").prop("disabled", false);

        document.getElementById("fromBuyer").readOnly = true;

        document.getElementById("toBuyer").readOnly = false;
        document.getElementById("toBuyer").value = "";
        document.getElementById("hiddenAction").value = "new";
        document.getElementById("btnSend").hidden = false;
        document.getElementById("btnApprove").hidden = true;

        document.getElementById("btnAddFromItem").hidden = false;
        document.getElementById("btnAddToItem").hidden = false;





        fromItems = [{
            "id": "",
            "product_name": "",
            "product_unit": "per Kilo",
            "quantity": "0"
        }];

        toItems = [{
            "id": "",
            "product_name": "",
            "product_unit": "per Kilo",
            "quantity": "0"
        }];

        loadProducts();

    }



    document.getElementById("btnNew").onclick = function() {
        resetFields();
    };

    function modifyProducts() {
        updateProductValues();
        var url = "request_modifyExchange.php";
        $.ajax({
            url: url,
            type: 'post',
            data: new FormData(document.getElementById('formExchange')),
            //dataType: 'json',
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data);
                resetFields();
                getExchanges();
            },
            error: function(e) {
                console.log(e);
            }
        });
    }



    getBuyers();
    getExchanges();
</script>


</html>