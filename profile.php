<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iForum - Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_header.php" ?>
    <?php
    $show_details = false;
    if ($conn) {
        if(isset($_SESSION["email"])){
            $show_details = true;
            $session_email = $_SESSION["email"];
            $profileSql = "SELECT * FROM `myusers` WHERE `email` LIKE '$session_email'";
            $profileResult = mysqli_query($conn, $profileSql);
            if ($profileResult) {
                if($row = mysqli_fetch_assoc($profileResult)){
                    $user_firstname = $row["first_name"];
                    $user_lastname = $row["last_name"];
                    $user_email = $row["email"];
                }
            }
        }
    }
    ?>
    <div class="container">
        <?php
        if($show_details){
            echo '<h1 class="my-3 text-center">Welcome '.$user_firstname.' '.$user_lastname.'</h1>
            <table class="table">
                <tbody>
                    <tr>
                        <th scope="row">Name</th>
                        <td>'.$user_firstname.' '.$user_lastname.'</td>
                    </tr>
                    <tr>
                        <th scope="row">Email</th>
                        <td>'.$user_email.'</td>
                    </tr>
                </tbody>
            </table>';
        }
        else{
            echo "Login frist to show profile info!";
        }
        ?>
    </div>
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>