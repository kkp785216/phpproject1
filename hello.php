<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <div class="container">

        <div class="row my-3">
            <!-- Main -->
            <div id="main" class="col-lg-8 m-auto ps-lg-0 mb-3 mb-lg-0">
                <!-- main section -->
                <h1 class="my-3">Hello World</h1>
                <?php
                // Script to conenct to the database
                $servername = "sql6.freemysqlhosting.net";
                $username = "sql6484048";
                $password = "t9A6W6H5cP";
                $database = "sql6484048";
                $conn = mysqli_connect($servername, $username, $password, $database);
                if ($conn) {
                    echo "connection successfully";
                }
                else{
                    echo "connectin faild";
                }
                ?>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>