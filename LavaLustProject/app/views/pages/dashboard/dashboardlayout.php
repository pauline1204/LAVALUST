<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales & Inventory</title>
    <!-- Add Bootstrap CSS CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Add any additional CSS files -->
</head>

<body class="bg-light">

    <!-- Sidebar and content layout -->
    <div class="d-flex" style="min-height: 100vh;">
        <!-- Sidebar -->
        <?php include APP_DIR . 'views/templates/sidebar.php'; ?>

        <!-- Main content -->
        <div class="flex-fill bg-white">
            <!-- Header -->
            <?php include APP_DIR . 'views/templates/topbar.php'; ?>

            <!-- Main content area -->
            <div class="container-fluid p-2" style="max-height: 100vh; overflow-y: auto;">
                <?php include APP_DIR . 'views/pages/dashboard/dashboard.php'; ?>
            </div>

        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>