<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iForum - Threads Answers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_header.php" ?>
    <?php
    // save the threads to the database
    if(isset($_SESSION["logedin"]) && $_SESSION["logedin"]){
        if(isset($_POST["comments"])){
            $Comment = $_POST["comments"];
            $threadId = $_POST["threadId"];
            $commentUserId = $_SESSION["email"];
            if($conn){
                $addThreadSql = "INSERT INTO `comments` (`comment_desc`, `thread_id`, `comment_user_id`) VALUES ('$Comment', '$threadId', '$commentUserId');";
                $addThreadResult = mysqli_query($conn, $addThreadSql);
                if($addThreadResult){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Comment was added successfully.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                }
            }
        }
    }
    ?>
    <div class="container">

        <div class="row my-3">
            <!-- Main -->
            <div id="main" class="col-lg-8 mx-auto ps-lg-0 mb-3 mb-lg-0">
                <?php
                // Specific thrads start here
                $page_not_found = true;
                ?>
                <div class="card py-3" style="background-color: #f7f7f7;">
                    <div class="card-body">
                        <?php
                        if (isset($_GET["thread"])) {
                            $threadId = $_GET["thread"];
                            if ($conn) {
                                $singleSql = "SELECT * FROM `threads` WHERE `thread_id` = '$threadId'";
                                $singleResult = mysqli_query($conn, $singleSql);
                                if ($singleResult) {
                                    $num = mysqli_num_rows($singleResult);
                                    if ($num === 1) {
                                        $page_not_found = false;
                                        $row = mysqli_fetch_assoc($singleResult);
                                        echo '<h2 class="card-title">Q: ' . $row["thread_title"] . '</h2>
                                        <p class="card-text"><strong>Problem: </strong>' . $row["thread_desc"] . '</p>';

                                        $postedEmail = $row["thread_user_id"];
                                        $postedSql = "SELECT * FROM `myusers` WHERE `email` LIKE '$postedEmail'";
                                        $postedResult = mysqli_query($conn, $postedSql);
                                        if ($postedResult) {
                                            $postedRow = mysqli_fetch_assoc($postedResult);
                                            echo '<p class="text-muted"><small>Posted by: <strong>' . $postedRow["first_name"] . ' ' . $postedRow["last_name"] . '</strong></small></p>';
                                        }
                                    } else {
                                        $page_not_found = true;
                                        echo "Page not found";
                                    }
                                }
                            }
                        }
                        ?>

                    </div>
                </div>

                <!-- Form for submit answer -->
                <?php
                if(!$page_not_found){
                    echo '<div class="card mt-5">
                    <div class="card-body">';
                    if(isset($_SESSION["logedin"]) && $_SESSION["logedin"] === true){
                        echo '<h2 class="cark-title mb-3">Post Your Reply</h2>';
                        echo '
                        <form method="POST">
                            <input type="hidden" name="threadId" value="'.$threadId.'">
                            <div class="mb-3 form-check p-0">
                                <textarea class="form-control" name="comments" id="comments" cols="30" rows="5" placeholder="Submit your reply."></textarea>
                            </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        </form>';
                    }
                    else{
                        echo '<h2 class="text-muted cark-title mb-3">Post Your Reply</h2>';
                        echo '
                        <fieldset disabled>
                            <form>
                                <input type="hidden" name="threadId" value="'.$threadId.'">
                                <div class="mb-3 form-check p-0">
                                    <textarea class="form-control" name="comments" id="comments" cols="30" rows="5" placeholder="Submit your reply."></textarea>
                                </div>
                                <p>Please login to submit a reply</p>
                            </form>
                        </fieldset>';
                    }
                    echo '</div>
                    </div>';
                }
                ?>        

                <?php
                // Users Repies for specific threads will be displayed here
                if (!$page_not_found) {
                    echo
                    '<div class="px-3">
                        <h2 class="mt-3">Browse Discussions</h2>
                        <div class="thread_comments">
                            <style>.thread_comments .mb-3:last-child {margin-bottom: 0 !important;}</style>';
                        if ($conn) {
                            $threadSql = "SELECT * FROM `comments` WHERE `thread_id` = $threadId";
                            $threadResult = mysqli_query($conn, $threadSql);
                            if ($threadResult) {
                                if (mysqli_num_rows($threadResult) >= 1) {
                                    while ($row = mysqli_fetch_assoc($threadResult)) {
                                        // Show user name
                                        $user_name = "";
                                        if($conn){
                                            $comment_user_id = $row["comment_user_id"];
                                            $userSql = "SELECT first_name, last_name FROM `myusers` WHERE `email` LIKE '$comment_user_id'";
                                            $userResult = mysqli_query($conn, $userSql);
                                            if($userResult){
                                                if(($user_name_row = mysqli_fetch_assoc($userResult)) > 0){
                                                    $user_name =$user_name_row["first_name"] . " " . $user_name_row["last_name"];
                                                }
                                            }
                                        }


                                        //display when this comments was posted
                                            date_default_timezone_set('Asia/Kolkata'); // for set time format to asia kolkata timezone

                                            $start_date = new DateTime($row["date"]);
                                            $since_start = $start_date->diff(new DateTime(date("Y-m-d H:i:s")));
                                            // echo $since_start->days.' days total<br>';
                                            // echo $since_start->y.' years<br>';
                                            // echo $since_start->m.' months<br>';
                                            // echo $since_start->d.' days<br>';
                                            // echo $since_start->h.' hours<br>';
                                            // echo $since_start->i.' minutes<br>';
                                            // echo $since_start->s.' seconds<br>';

                                            $when_posted = "";

                                            $commentTime = strtotime($row["date"]);
                                            $currnetTime = strtotime(date("Y-m-d H:i:s"));
                                            $diffInSeconds = $currnetTime - $commentTime;
                                            if($diffInSeconds < 60){
                                                $when_posted = "Last updated " . $since_start->s.' seconds ago';
                                            }
                                            else if ($diffInSeconds < 3600){
                                                $when_posted = "Last updated " . $since_start->i.' minutes ago';
                                            }
                                            else if($diffInSeconds < 86400){
                                                $when_posted = "Last updated " . $since_start->h.' hours ago';
                                            }
                                            else if ($diffInSeconds < 2592000){
                                                $when_posted = "Last updated " . $since_start->d.' days ago';
                                            }
                                            else if($diffInSeconds < 31104000){
                                                $when_posted = "Last updated " . $since_start->m.' months ago';
                                            }
                                            else{
                                                $when_posted = "Last updated " . $since_start->y.' years ago';
                                            }


                                        echo "<div class='mt-3'></div>";
                                        echo
                                        '<div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <img src="img/user.svg" alt="..." title="'.$user_name.'" width="53px">
                                            </div>
                                            <div class="flex-grow-1 ms-3 overflow-auto">
                                                <p class="m-0"><strong>'.$user_name.'</strong></p>
                                                <p class="card-text mb-1">' . htmlspecialchars($row["comment_desc"]) . '</p>
                                                <p class="card-text"><small class="text-muted">'.$when_posted.'</small></p>
                                            </div>
                                        </div>';
                                    }
                                } else {
                                    echo '
                                    <p class="fs-3 mb-1 mt-3 text-muted">No answers found</p>
                                    Be the first person to comments here';
                                }
                            }
                        }
                        echo
                        '</div>
                    </div>';
                }
                ?>

            </div>

            <!-- Sidebar -->
            <!-- <div id="main" class="col-lg-4 pe-lg-0">
                <?php // include "partials/_sidebar.php" ?>
            </div> -->
            
        </div>

    </div>
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>