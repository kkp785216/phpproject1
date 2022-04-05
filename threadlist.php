<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iForum - Threads</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <?php include "partials/_header.php" ?>
    <?php
    // save the threads to the database
    if(isset($_SESSION["logedin"]) && $_SESSION["logedin"]){
        if(isset($_POST["threadTitle"])){
            $threadTitle = $_POST["threadTitle"];
            $threadDesc = $_POST["threadDesc"];
            $threadCatId = $_POST["threadCatId"];
            $threadUserId = $_SESSION["email"];
            if($conn){
                $addThreadSql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`) VALUES ('$threadTitle', '$threadDesc', '$threadCatId', '$threadUserId');";
                $addThreadResult = mysqli_query($conn, $addThreadSql);
                if($addThreadResult){
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> Your Thread was added successfully.
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
            <div id="main" class="col-lg-8 ps-lg-0 mb-3 mb-lg-0">
                <?php
                // Specific Category of post -- e.g. java, python, javascript
                $page_not_found = true;
                ?>
                <div class="card">
                    <div class="card-body">
                        <?php
                        if (isset($_GET["catid"])) {
                            $categoryId = $_GET["catid"];
                            if ($conn) {
                                $singleSql = "SELECT * FROM `categories` WHERE `category_id` = '$categoryId'";
                                $singleResult = mysqli_query($conn, $singleSql);
                                if ($singleResult) {
                                    $num = mysqli_num_rows($singleResult);
                                    if ($num === 1) {
                                        $page_not_found = false;
                                        $row = mysqli_fetch_assoc($singleResult);
                                        echo '<h2 class="card-title">Welcome to ' . $row["category_name"] . ' forums</h2>
                                        <img src="img/category/' . strtolower($row["category_name"]) . '.jpg" class="card-img-top px-md-5 my-3 " alt="...">
                                        <p class="card-text">' . $row["category_description"] . '</p>';
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
                        echo '<h2 class="cark-title mb-3">Ask your question</h2>';
                        echo '
                        <form method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" name="threadTitle" id="threadTitle" placeholder="Question title">
                                <label for="threadTitle">Question title</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" placeholder="Leave a comment here" name="threadDesc" id="threadDesc" style="height: 150px;"></textarea>
                                <label for="threadDesc">Description</label>
                            </div>
                            <input type="hidden" name="threadCatId" value="'.$_GET["catid"].'"></input>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>';
                    }
                    else{
                        echo '<h2 class="cark-title mb-3 text-muted">Ask your question</h2>';
                        echo '
                        <fieldset disabled>
                            <form>
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="threadTitle" id="threadTitle" placeholder="Question title">
                                    <label for="threadTitle">Question title</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <textarea class="form-control" placeholder="Leave a comment here" name="threadDesc" id="threadDesc" style="height: 150px;"></textarea>
                                    <label for="threadDesc">Description</label>
                                </div>
                            <p class="px-3">Please login to add your thread</p>
                            </form>
                        </fieldset>';
                    }
                echo '</div>
                </div>';
                }
                ?>        

                <?php
                // all the threads will be displayed
                if (!$page_not_found) {
                    echo
                    '<div class="px-3">
                        <h2 class="mt-3">Browse Questions</h2>
                        <div class="thread_comments">
                            <style>.thread_comments .mb-3:last-child {margin-bottom: 0 !important;}</style>';
                        if ($conn) {
                            $threadSql = "SELECT * FROM `threads` WHERE `thread_cat_id` = '$categoryId'";
                            $threadResult = mysqli_query($conn, $threadSql);
                            if ($threadResult) {
                                if (mysqli_num_rows($threadResult) >= 1) {
                                    while ($row = mysqli_fetch_assoc($threadResult)) {
                                        
                                        //display when this comment was posted
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

                                        // Show user name
                                        $user_name = "";
                                        if($conn){
                                            $thread_user_id = $row["thread_user_id"];
                                            $userSql = "SELECT first_name, last_name FROM `myusers` WHERE `email` LIKE '$thread_user_id'";
                                            $userResult = mysqli_query($conn, $userSql);
                                            if($userResult){
                                                if(($user_name_row = mysqli_fetch_assoc($userResult)) > 0){
                                                    $user_name = $user_name_row["first_name"] . " " . $user_name_row["last_name"];
                                                }
                                            }
                                        }
                                        echo "<div class='mt-3'></div>";
                                        echo
                                        '<div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <img src="img/user.svg" alt="..." title="'.$user_name.'" width="53px">
                                            </div>
                                            <div class="flex-grow-1 ms-3 overflow-auto">
                                                <p class="mb-1"><strong>'.$user_name.'</strong></p>
                                                <h5 class="card-title"><a class="text-decoration-none" href="/forum/threads.php?'.'thread='. htmlspecialchars($row['thread_id']) .'">' . $row["thread_title"] . '</a></h5>
                                                <p class="card-text mb-1">' . htmlspecialchars($row["thread_desc"]) . '</p>
                                                <p class="card-text"><small class="text-muted">'.$when_posted.'</small></p>
                                            </div>
                                        </div>';
                                    }
                                } else {
                                    echo '
                                    <p class="fs-3 mb-1 mt-3 text-muted">No threads found</p>
                                    Be the first person to comment here';
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
            <div id="main" class="col-lg-4 pe-lg-0">
                <?php include "partials/_sidebar.php" ?>
            </div>
        </div>

    </div>
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>