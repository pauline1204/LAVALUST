<?php include APP_DIR . 'views/templates/header.php'; // Include header.php ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .table thead th {
            cursor: pointer;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>

<body>

    <main class="mt-3 pt-3">
        <div class="container">
            <div class="row justify-content-between align-items-center">
                <div class="col-md-6">
                    <h2 class="fw-bold">Products</h2>
                </div>
                <div class="col-md-6 text-end">
                    <!-- Search Field -->
                    <input type="text" id="searchProduct" class="form-control mb-2" placeholder="Search products...">
                    <!-- Add Product Button -->
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="fas fa-plus"></i> Add Product
                    </button>
                </div>
            </div>
        </div>

        <div class="container mb-4">
            <div class="row">
                <!-- Table Example -->
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th scope="col" data-sort="id">#</th>
                            <th scope="col" data-sort="name">Product Name</th>
                            <th scope="col" data-sort="price">Price</th>
                            <th scope="col" data-sort="stock">Stock</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <th scope="row"><?= $product['id'] ?></th>
                                <td><?= $product['name'] ?></td>
                                <td>₱<?= number_format($product['price'], 2) ?></td>
                                <td><?= $product['stock'] ?></td>
                                <td>
                                    <!-- Edit Product Button -->
                                    <button class="btn btn-info btn-sm edit-product" data-bs-toggle="modal"
                                        data-bs-target="#editProductModal" data-id="<?= $product['id'] ?>"
                                        data-name="<?= $product['name'] ?>" data-price="<?= $product['price'] ?>"
                                        data-stock="<?= $product['stock'] ?>" title="Edit Product">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <!-- Delete Product Button -->
                                    <button class="btn btn-danger btn-sm delete-product" data-id="<?= $product['id'] ?>"
                                        title="Delete Product">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination (optional) -->
        <div class="text-center">
            <ul class="pagination" id="pagination"></ul>
        </div>
    </main>

    <!-- Add Product Modal -->
    <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addProductModalLabel">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addProductForm">
                        <div class="mb-3">
                            <label for="productName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="productName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="productPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="productStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="productStock" name="stock" required>
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Product Modal -->
    <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" name="id" id="editProductId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Price (₱)</label>
                            <input type="number" class="form-control" id="editProductPrice" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editProductStock" name="stock" required>
                        </div>
                        <div class="mb-3 text-end">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.0.19/sweetalert2.all.min.js"></script>

    <script>
        // Search functionality
        $('#searchProduct').on('keyup', function () {
            const value = $(this).val().toLowerCase();
            $('#productTable tr').filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });
        });

        // Sorting functionality
        $('th[data-sort]').on('click', function () {
            const table = $(this).parents('table').eq(0);
            const rows = table.find('tbody > tr').toArray().sort((a, b) => {
                const col = $(this).data('sort');
                const valA = $(a).find(`td:nth-child(${this.cellIndex + 1})`).text();
                const valB = $(b).find(`td:nth-child(${this.cellIndex + 1})`).text();
                return valA.localeCompare(valB, undefined, { numeric: true });
            });
            this.asc = !this.asc;
            if (!this.asc) rows.reverse();
            table.append(rows);
        });

        // Populate Edit Modal
        $(document).on('click', '.edit-product', function () {
            const productId = $(this).data('id');
            const productName = $(this).data('name');
            const productPrice = $(this).data('price');
            const productStock = $(this).data('stock');

            $('#editProductId').val(productId);
            $('#editProductName').val(productName);
            $('#editProductPrice').val(productPrice);
            $('#editProductStock').val(productStock);
        });

        // Handle Add Product Form
        $('#addProductForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'addProduct.php', // Your PHP file to handle the add product logic
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire('Product Added!', response.message, 'success');
                    location.reload();
                }
            });
        });

        // Handle Edit Product Form
        $('#editProductForm').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: 'editProduct.php', // Your PHP file to handle the edit product logic
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire('Product Updated!', response.message, 'success');
                    location.reload();
                }
            });
        });

        // Handle Delete Product Action
        $(document).on('click', '.delete-product', function () {
            const productId = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: 'This will permanently delete the product.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: 'deleteProduct.php',
                        data: { id: productId },
                        success: function (response) {
                            Swal.fire('Product Deleted!', response.message, 'success');
                            location.reload();
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>
