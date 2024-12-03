<?php
include APP_DIR . 'views/templates/header.php'; // Include header.php
?>

<body class="bg-light">

    <main class="mt-3 pt-3">
        <div class="container">
            <!-- Sales Header -->
            <h2 class="fw-bold text-center mb-4">Point of Sale</h2>
            <!-- Product Selection and Cart Section -->
            <div class="row justify-content-center">
                <!-- Product Section (Left Side) -->
                <div class="col-lg-8 col-md-10 mb-4">
                    <div class="card shadow-lg border-0 rounded-3" style="overflow-y: auto; height: 60vh">
                        <div class="card-body">
                            <h4 class="card-title fw-bold text-dark mb-3">Products</h4>
                            <div class="row">
                                <!-- Loop through each product and display it -->
                                <?php foreach ($products as $product): ?>
                                    <div class="col-lg-4 col-md-6 mb-3" id="product-<?= $product['id']; ?>">
                                        <div class="card border-0 rounded-3 shadow-sm">
                                            <div class="card-body text-center">
                                                <h5 class="card-title text-dark"><?= $product['name']; ?></h5>
                                                <p class="card-text text-muted">₱<?= number_format($product['price'], 2); ?></p>
                                                <p class="card-text text-muted" id="stock-<?= $product['id']; ?>">Stock: <?= $product['stock']; ?></p>
                                                <button class="btn btn-primary add-to-cart"
                                                    data-product-id="<?= $product['id']; ?>"
                                                    data-price="<?= $product['price']; ?>"
                                                    data-name="<?= $product['name']; ?>"
                                                    data-stock="<?= $product['stock']; ?>">Add to Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cart Section (Right Side) -->
                <div class="col-lg-4 col-md-6">
                    <div class="card shadow-lg border-0 rounded-3">
                        <div class="card-body">
                            <h4 class="card-title fw-bold text-dark mb-3">Your Cart</h4>
                            <ul class="list-group" id="cart-items">
                                <!-- Cart items will be displayed here dynamically -->
                            </ul>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h5 class="fw-bold">Total:</h5>
                                <p id="total-amount">₱0.00</p>
                            </div>
                            <button class="btn btn-success w-100" id="checkout-btn" data-bs-toggle="modal" data-bs-target="#checkoutModal">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Checkout Modal -->
    <div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="checkout-form">
                        <div class="mb-3">
                            <label for="customer-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="customer-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="customer-address" required>
                        </div>
                        <div class="mb-3">
                            <label for="customer-phone" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="customer-phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment-method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment-method" required>
                                <option value="" disabled selected>Select Payment Method</option>
                                <option value="credit-card">Credit Card</option>
                                <option value="cash">Cash</option>
                                <option value="gcash">GCash</option>
                            </select>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h5 class="fw-bold">Order Summary</h5>
                            <p id="order-summary">₱0.00</p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirm-checkout">Confirm Checkout</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <script>
    // Script to handle adding products to the cart
    let cart = [];

    $(document).on('click', '.add-to-cart', function () {
        const productId = $(this).data('product-id');
        const productPrice = parseFloat($(this).data('price'));
        const productName = $(this).data('name');
        let productStock = parseInt($(this).data('stock'));

        if (productStock <= 0) {
            alert('Sorry, this product is out of stock.');
            return;
        }

        // Reduce stock when item is added to cart
        productStock -= 1;
        $(this).data('stock', productStock); // Update stock data attribute
        $('#stock-' + productId).text('Stock: ' + productStock); // Update displayed stock

        // Add product to cart
        cart.push({ id: productId, name: productName, price: productPrice });

        // Update cart display
        updateCart();
    });

    function updateCart() {
        // Update cart items
        $('#cart-items').empty();
        let total = 0;
        cart.forEach(item => {
            total += item.price;
            $('#cart-items').append(`
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.name} - ₱${item.price.toFixed(2)}
                    <button class="btn btn-sm btn-danger remove-item" data-product-id="${item.id}">Remove</button>
                </li>
            `);
        });

        // Update total amount
        $('#total-amount').text('₱' + total.toFixed(2));
        $('#order-summary').text('₱' + total.toFixed(2));
    }

    // Handle remove item from cart
    $(document).on('click', '.remove-item', function () {
        const productId = $(this).data('product-id');
        // Find the removed product in the cart
        const removedItemIndex = cart.findIndex(item => item.id === productId);
        if (removedItemIndex > -1) {
            // Increase the stock when an item is removed from the cart
            const product = cart[removedItemIndex];
            let productStock = parseInt($('[data-product-id="'+productId+'"]').data('stock'));
            productStock += 1;
            $('[data-product-id="'+productId+'"]').data('stock', productStock); // Update stock data attribute
            $('#stock-' + productId).text('Stock: ' + productStock); // Update displayed stock

            // Remove the item from the cart
            cart.splice(removedItemIndex, 1);
            updateCart();
        }
    });

    // Handle checkout
    $('#checkout-btn').click(function () {
        // Reset checkout form and order summary before opening the modal
        $('#checkout-form')[0].reset();
        $('#order-summary').text('₱0.00');
        $('#total-amount').text('₱0.00');
    });

    $('#confirm-checkout').click(function () {
        if (cart.length === 0) {
            alert('Your cart is empty. Please add items to the cart before checking out.');
            return;
        }

        // Get customer details from the form
        const customerName = $('#customer-name').val();
        const customerAddress = $('#customer-address').val();
        const customerPhone = $('#customer-phone').val();
        const paymentMethod = $('#payment-method').val();

        // Validate form
        if (!customerName || !customerAddress || !customerPhone || !paymentMethod) {
            alert('Please fill in all fields.');
            return;
        }

        // Generate a unique order ID (could be an actual order ID from the database in a real application)
        const orderId = 'ORD-' + Math.floor(Math.random() * 10000);
        alert('Order placed successfully! Your Order ID is ' + orderId);
        $('#checkoutModal').modal('hide');
        cart = [];
        updateCart();
    });
</script>


</body>
</html>
