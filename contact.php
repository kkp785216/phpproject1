<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iForum - Contact Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_header.php" ?>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        if (isset($_POST["contact_email"])) {
            if ($conn) {
                $contact_first_name = $_POST["contact_first_name"];
                $contact_last_name = $_POST["contact_last_name"];
                $contact_email = $_POST["contact_email"];
                $contact_phone = $_POST["contact_phone"];
                $contact_message = $_POST["contact_message"];

                $contactSql = "INSERT INTO `contactus` (`first_name`, `last_name`, `email`, `phone`, `message`) VALUES ('$contact_first_name', '$contact_last_name', '$contact_email', '$contact_phone', '$contact_message');";
                $contactResult = mysqli_query($conn, $contactSql);
                if ($contactResult) {
                    echo '<div class="alert alert-success alert-dismissible fade show  mb-0" role="alert">
                    <strong>Success!</strong> Thanks for connecting with us we will reach you soon.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>';
                }
                echo "<script>setTimeout(()=>{location.href = location.href}, 3000)</script>";
            }
        }
    }
    ?>
    <div class="container">
        <div class="row my-3">
            <!-- Main -->
            <div id="main" class="col-lg-8 mx-auto ps-lg-0 my-3">
                <div class="card">
                    <div class="card-body">
                        <h1 class="my-3">Contact Us</h1>
                        <form method="POST" class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label for="contact_first_name" class="form-label">First Name</label>
                                <input type="name" class="form-control" maxlength="55" name="contact_first_name" id="contact_first_name">
                                <div class="invalid-feedback">Please input a valid Name</div>
                            </div>
                            <div class="col-md-6">
                                <label for="contact_last_name" class="form-label">Last Name</label>
                                <input type="name" class="form-control" maxlength="55" name="contact_last_name" id="contact_last_name">
                                <div class="invalid-feedback">Please input a valid Name</div>
                            </div>
                            <div class="col-md-6">
                                <label for="contact_email" class="form-label">Email</label>
                                <input type="email" class="form-control" maxlength="55" name="contact_email" id="contact_email">
                                <div class="invalid-feedback">Please Input a valid email</div>
                            </div>
                            <div class="col-md-6">
                                <label for="contact_phone" class="form-label">Phone No.</label>
                                <input type="tel" class="form-control col-9" maxlength="15" name="contact_phone" id="contact_phone">
                                <div class="invalid-feedback">Please Input valid phone no.</div>
                            </div>
                            <div class="col-md-12">
                                <label for="contact_message" class="form-label">Message</label>
                                <textarea class="form-control" name="contact_message" id="contact_message" cols="30" rows="5"></textarea>
                                <div class="invalid-feedback">Message is Required</div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        response send to email
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="contactBtn" disabled>Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>