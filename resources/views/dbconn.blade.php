<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel & MySQL DB Connection</title>
</head>
<body>
    <div>
        <?php
            if (DB::connection()->getPdo()) {
                echo "Successfully connected to DB and DB Name is " . DB::connection()->getDatabaseName();
            }
        ?>
    </div>
</body>
</html>