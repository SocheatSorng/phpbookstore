<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error</title>
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <div class="container mt-5">
        <div class="alert alert-danger">
            <h4 class="alert-heading">Error!</h4>
            <p><?php echo htmlspecialchars($_GET['message'] ?? 'An error occurred'); ?></p>
            <hr>
            <p class="mb-0">Please try again later or contact the administrator.</p>
            <a href="index.php" class="btn btn-primary mt-3">Go Back</a>
        </div>
    </div>
</body>
</html>
