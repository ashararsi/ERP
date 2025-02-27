<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamic Rows</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-4">
    <button type="button" class="btn btn-success mb-2" id="addRow">Add Row</button>

    <div id="rowsContainer">
        <div class="row input-row" data-id="1">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Inventory</label>
                    <select name="inventory[]" class="form-control">
                        <option>Select option</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Type</label>
                    <select name="type[]" class="form-control">
                        <option>Select option</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Qty</label>
                    <input type="text" class="form-control qty" name="qty[]" data-id="1" id="qty-1">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Price</label>
                    <input class="form-control price" type="text" name="price[]" data-id="1" id="price-1">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Total</label>
                    <input class="form-control total" type="text" name="total[]" data-id="1" id="total-1">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeRow">Remove</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        let rowId = 1;

        // Add new row
        $("#addRow").click(function () {
            rowId++;
            let newRow = `<div class="row input-row" data-id="${rowId}">
            <div class="col-md-2">
                <div class="form-group">
                    <label>Inventory</label>
                    <select name="inventory[]" class="form-control">
                        <option>Select option</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Type</label>
                    <select name="type[]" class="form-control">
                        <option>Select option</option>
                    </select>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Qty</label>
                    <input type="text" class="form-control qty" name="qty[]" data-id="${rowId}" id="qty-${rowId}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Price</label>
                    <input class="form-control price" type="text" name="price[]" data-id="${rowId}" id="price-${rowId}">
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Total</label>
                    <input class="form-control total" type="text" name="total[]" data-id="${rowId}" id="total-${rowId}">
                </div>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-danger removeRow">Remove</button>
            </div>
        </div>`;

            $("#rowsContainer").append(newRow);
        });

        // Remove row
        $(document).on("click", ".removeRow", function () {
            $(this).closest(".input-row").remove();
        });

        // Auto-calculate total when qty or price changes
        $(document).on("input", ".qty, .price", function () {
            let row = $(this).closest(".input-row");
            let qty = row.find(".qty").val();
            let price = row.find(".price").val();
            let total = (qty * price) || 0;
            row.find(".total").val(total);
        });
    });
</script>

</body>
</html>
