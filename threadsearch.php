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
    <?php $searchHeaderSearch = true // // for avoid search redirect on threadsearch page  
    ?>
    <?php include "partials/_header.php" ?>
    <div class="container">

        <div class="row my-3">
            <!-- Main -->
            <div id="main" class="col-lg-8 ps-lg-0 mb-3 mb-lg-0">
                <!-- main section -->
                <div class="card">
                    <div class="card-body">
                        <h1>Search result for <?php echo isset($_GET["threadsearch"]) ? '<em>"' . $_GET["threadsearch"] . '"</em>' :  "" ?></h1>

                        <div class="px-3">
                            <h2 class="mt-3">Browse Threads</h2>
                            <div class="thread_comments">
                                <style>
                                    .thread_comments .mb-3:last-child {
                                        margin-bottom: 0 !important;
                                    }
                                </style>
                                <?php
                                if ($conn) {
                                    if(isset($_GET["threadsearch"])){
                                        $searchWord = $_GET["threadsearch"];
                                        $threadSql = "SELECT * FROM `threads` WHERE `thread_title` LIKE '%$searchWord%' OR `thread_desc` LIKE '%$searchWord%' OR `thread_cat_id` LIKE '%$searchWord%'";
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
                                                            <h5 class="card-title"><a class="text-decoration-none" href="/threads.php?'.'thread='. htmlspecialchars($row['thread_id']) .'">' . $row["thread_title"] . '</a></h5>
                                                            <p class="card-text mb-1">' . htmlspecialchars($row["thread_desc"]) . '</p>
                                                            <p class="card-text mb-0"><small class="text-muted">'.$when_posted.'</small></p>
                                                            <small><p>Category - <a href="/threadlist.php?catid='.$row["thread_cat_id"].'" class="card-text text-decoration-none"><strong><em>'.$row["thread_cat_id"].'</em></strong></a></p></small>
                                                        </div>
                                                    </div>';
                                                }
                                            } else {
                                                echo '
                                                <p class="fs-3 mb-1 mt-3 text-muted">No result found</p>
                                                <li>Make sure that all words are spelled correctly.</li>
                                                <li>Try different keywords.</li>
                                                <li>Try more general keywords.</li>
                                                ';
                                                
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
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