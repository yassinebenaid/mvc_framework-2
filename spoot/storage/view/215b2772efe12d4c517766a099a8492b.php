<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print  $title  ?></title>
    <link rel="stylesheet" href="./bootstrap/dist/css/bootstrap.css">
</head>
<body>
    <nav class="navbar px-5">
        <div class="row ">
            <a href="/" class="col nav-link">Home</a>
            <a href="/" class="col nav-link">Register</a>
            <a href="/" class="col nav-link">Home</a>
        </div>
    </nav>
    <div class="container">
        <?php print  $form  ?>
    </div>
</body>
</html>