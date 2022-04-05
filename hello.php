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
                <!-- <form> -->
                    <div class="mb-3">
                        <textarea name="validpost" class="form-control" id="validpost" cols="30" rows="10"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="submit" class="btn btn-primary" id="format">Format</button>
                    <p>&amp;lt</p>
                <!-- </form> -->
            </div>
            <hr>

            <p>how to run this &lt;script&gt;Hello this is krishna&lt;/script&gt;</p>
            <pre><h1>Hellow</h1></pre>
            
            <?php echo htmlspecialchars('<strong>something</strong>') ?>

            <?php
            // $hii = "";
            // $hii = preg_replace('/\</', " hihi ", "< > < > & &");
            // $hii = preg_replace('/\>/', " haha ", $hii);
            // $hii = preg_replace('/\&/', " jaja ", $hii);
            // echo $hii;
            ?>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- <script>
        let format = document.getElementById('format');
        format.onclick = ()=>{
            let validpost = document.getElementById('validpost');
            validpost.value = validpost.value.replace(/\</g, '&lt;').replace(/\>/g, '&gt;').replace(/\&/g, '&amp;');
            console.log(validpost.value);
        }
    </script> -->
</body>

</html>