<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>iForum</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body>
    <!-- Header -->
    <?php $homeHeaderSearch = true; // for avoid search redirect on homepage ?>
    <?php include "partials/_header.php" ?>
    <!-- Crousle -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/crousle/1.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/crousle/2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="img/crousle/3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <!-- Main -->
    <div class="container">
        <h1 class="mb-3 mt-4">Welcome to iForum - Coding Discuss</h1>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 mb-4">
            <!-- Use a for loop to itrate the categoris -->
            <?php
            include "partials/_dbconnect.php";
            if ($conn) {
                if(!isset($_GET["search"])){
                    $sql = "SELECT * FROM `categories`";
                }
                else{
                    $searchedWord = $_GET["search"];
                    $sql = "SELECT * FROM `categories` WHERE `category_name` LIKE '$searchedWord' OR `category_description` LIKE '%$searchedWord%';";
                }
                $result = mysqli_query($conn, $sql);
                if ($result) {

                    // how much post I want to show per page
                    $totalPost = mysqli_num_rows($result);
                    $perPagePost = 6;

                    $totalPage;
                    if(fmod($totalPost, $perPagePost) > 0){
                        $totalPage = intval(floor($totalPost/$perPagePost)) + 1;
                    }
                    else{
                        $totalPage = intval(floor($totalPost/$perPagePost));
                    }

                    $pageIndex = 1;
                    if(isset($_GET["page"])){
                        if($_GET["page"] > 0){
                            $pageIndex = $_GET["page"];
                        }
                    }
                    if($perPagePost >= $totalPost){
                        $pageIndex = 1;
                    }
                    
                    if ($pageIndex <= $totalPage && $pageIndex > 0) {
                        if ($pageIndex === 1) {
                            for ($i = 0; $i < $perPagePost; $i++) {
                                if($i === $totalPost){
                                    break;
                                }
                                $row = mysqli_fetch_assoc($result);
                                $desc = strlen($row["category_description"]) >= 200 ? substr($row["category_description"], 0, 200) . "..." : $row["category_description"];
                                echo '
                                <div class="col">
                                    <div class="card h-100">
                                        <img src="img/category/' . strtolower($row["category_name"]) . '.jpg" class="card-img-top" alt="...">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div>
                                            <h5 class="card-title"><a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="text-decoration-none">' . $row["category_name"] . '</a></h5>
                                            <p class="card-text">' . $desc . '</p></div>
                                            <a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="btn btn-primary btn-sm mt-4 " style="margin-right: auto;">View Threads</a>
                                        </div>
                                    </div>
                                </div>';
                            }
                        }
                        else if ($pageIndex === $totalPage) {
                            $break = false;
                            $continue = false;

                            $wantedIndex = [];
                            for ($i = ($pageIndex - 1) * $perPagePost; $i < (($pageIndex - 1) * $perPagePost) + ($totalPost % $perPagePost !==0 ? $totalPost % $perPagePost : $perPagePost); $i++) {
                                if($i === $totalPost){
                                    break;
                                }
                                array_push($wantedIndex, $i);
                            }
                            $nextIndex = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                foreach($wantedIndex as $value){
                                    if($nextIndex !== $value){
                                        $continue = true;
                                    }
                                    else{
                                        $continue = false;
                                        break;
                                    }
                                }
                                $nextIndex++;
                                if($continue){
                                    continue;
                                }
                                $desc = strlen($row["category_description"]) >= 200 ? substr($row["category_description"], 0, 200) . "..." : $row["category_description"];
                                echo '
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="img/category/' . strtolower($row["category_name"]) . '.jpg" class="card-img-top" alt="...">
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div>
                                                <h5 class="card-title"><a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="text-decoration-none">' . $row["category_name"] . '</a></h5>
                                                <p class="card-text">' . $desc . '</p></div>
                                                <a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="btn btn-primary btn-sm mt-4 " style="margin-right: auto;">View Threads</a>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                        else {
                            $break = false;
                            $continue = false;

                            $wantedIndex = [];
                            for ($i = ($pageIndex - 1) * $perPagePost; $i < ($perPagePost * $pageIndex); $i++) {
                                if($i === $totalPost){
                                    break;
                                }
                                array_push($wantedIndex, $i);
                            }
                            $nextIndex = 0;
                            while ($row = mysqli_fetch_assoc($result)) {
                                foreach($wantedIndex as $value){
                                    if($nextIndex !== $value){
                                        $continue = true;
                                    }
                                    else{
                                        $continue = false;
                                        break;
                                    }
                                }
                                $nextIndex++;
                                if($continue){
                                    continue;
                                }
                                $desc = strlen($row["category_description"]) >= 200 ? substr($row["category_description"], 0, 200) . "..." : $row["category_description"];
                                echo '
                                    <div class="col">
                                        <div class="card h-100">
                                            <img src="img/category/' . strtolower($row["category_name"]) . '.jpg" class="card-img-top" alt="...">
                                            <div class="card-body d-flex flex-column justify-content-between">
                                                <div>
                                                <h5 class="card-title"><a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="text-decoration-none">' . $row["category_name"] . '</a></h5>
                                                <p class="card-text">' . $desc . '</p></div>
                                                <a href="/threadlist.php?' . 'catid=' . $row['category_id'] . '" class="btn btn-primary btn-sm mt-4 " style="margin-right: auto;">View Threads</a>
                                            </div>
                                        </div>
                                    </div>';
                            }
                        }
                    }
                    else if($pageIndex > $totalPage){
                        if(isset($_GET["search"])){
                            echo '<p class="display-5 px-3">No result found</p>';
                        }
                        else{
                            echo '<p class="display-5 px-3">page not found</p>';
                        }
                    }
                }
            }
            ?>
        </div>

        <!-- Page Navigation Start -->
        <?php
        if(isset($totalPage) && isset($pageIndex)){
            if($pageIndex == 1){
                $previousBtn = "disabled";
            }
            else{
                $previousBtn = "";
            }
            if($pageIndex == $totalPage){
                $nextBtn = "disabled";
            }
            else{
                $nextBtn = "";
            }
            if((stripos($_SERVER['REQUEST_URI'], "?")) > 0){
                if(isset($_GET["page"])){
                    $pageUrl = preg_replace("/page\=[1-9]+/i", "page=", $_SERVER['REQUEST_URI']);
                }
                else{
                    $pageUrl = $_SERVER['REQUEST_URI'] . "&page=";
                }
            }
            else{
                $pageUrl = $_SERVER['REQUEST_URI'] . "?page=";
            }
            // if($totalPage != $pageIndex){
                echo '<nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li class="page-item '.$previousBtn.'">
                            <a href="'.$pageUrl.($pageIndex - 1).'" class="page-link">Previous</a>
                        </li>';
                        // echo '<li class="page-item active"><a class="page-link" href="/?page=1">1</a></li>
                        // <li class="page-item"><a class="page-link" href="/?page=2">2</a></li>
                        // <li class="page-item"><a class="page-link" href="/?page=3">3</a></li>';
                        // for($i=1; $i<=3; $i++){
                        //     if($i <= $totalPage){
                        //         if($i == $pageIndex){
                        //             echo '<li class="page-item active"><a class="page-link" href="/?page='.(($pageIndex + $i) - 1).'">'.(($pageIndex + $i) - 1).'</a></li>';
                        //         }
                        //         else{
                        //             echo '<li class="page-item"><a class="page-link" href="/?page='.(($pageIndex + $i) - 1).'">'.(($pageIndex + $i) - 1).'</a></li>';
                        //         }
                        //     }
                        // }
                        // echo '<p><pre class="m-0 mt-auto"> ... </pre></p>';
                        echo '<p><pre class="m-0 mt-auto"> '.$pageIndex.' of '.$totalPage.' </pre></p>';
                        // echo '<li class="page-item"><a class="page-link" href="/?page=7">7</a></li>
                        // <li class="page-item"><a class="page-link" href="/?page=8">8</a></li>
                        // <li class="page-item"><a class="page-link" href="/?page=9">9</a></li>';
                        echo '<li class="page-item '.$nextBtn.'">
                            <a class="page-link" href="'.$pageUrl.($pageIndex + 1).'">Next</a>
                        </li>
                    </ul>
                </nav>';
            // }
        }

        ?>
        <!-- <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item active"><a class="page-link" href="/?page=1">1</a></li>
                <li class="page-item"><a class="page-link" href="/?page=2">2</a></li>
                <li class="page-item"><a class="page-link" href="/?page=3">3</a></li>
                <p><pre class="m-0 mt-auto"> ... </pre></p>
                <li class="page-item"><a class="page-link" href="/?page=7">7</a></li>
                <li class="page-item"><a class="page-link" href="/?page=8">8</a></li>
                <li class="page-item"><a class="page-link" href="/?page=9">9</a></li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav> -->
        <!-- Page Navigation end -->

    </div>
    <!-- Footer -->
    <?php include "partials/_footer.php" ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>