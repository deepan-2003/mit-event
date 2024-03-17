<?php include 'includes/header.php';?>
<!DOCTYPE html>
<?php include 'includes/navbar.php';?>

<head>
    <title>Madras Institute of Technology</title>
    <style>
        .carousel-container {
            position: relative;
            overflow: hidden;
            width: 100%;
            max-width: 800px; /* Adjust carousel width as needed */
            margin: auto;
        }

        .carousel-images {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .carousel-image {
			border-radius:20px;
            width: 100%;
			
            flex-shrink: 0;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="row">
	<div class="col-md-10"></div>
        <div class="col-md-2 offset-md-8 text-right">
            <select width="4%" class="form-control" aria-label="size 3 select example" id="yeardropdown" name="select_year">
                <?php
                $current = date("Y");
                // Generate options for years from 2016 to 2024
                for ($year = $current; $year >=2016 ; $year--) {
                    // Check if the current year is 2024 and set it as the default selected option
                    $selected = ($year == $current) ? 'selected' : '';
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select>
        </div>
    </div>
</div>
    <?php
	$yearno = isset($_GET['year']) ? $_GET['year'] : $current;
    $per_page = 5; // Number of posts per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

    $start = ($page - 1) * $per_page; // Starting post index for the current page

    $query = "SELECT * FROM posts WHERE YEAR(from_date)=$yearno and status='published' ORDER BY from_date DESC LIMIT $start, $per_page";
    $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
	$count = mysqli_num_rows($run_query);
	if ($count == 0) {?>
		
		<div class="row" style="margin-right: 20%; margin-left: 20%">
        <div class="col-md-12 text-center">
            <h1 class="page-header">Sorry, no result found for your query</h1>
        </div></div>
    <?php } else {
    if (mysqli_num_rows($run_query) > 0) {
        $alternate = 0;
        while ($row = mysqli_fetch_assoc($run_query)) {
            $post_title = $row['title'];
            $post_id = $row['id'];
            $post_author = $row['author'];
            $post_date = $row['postdate'];
            $post_image = $row['image'];
            $post_content = $row['content'];
			$post_link=$row['link'];
			$from_date=date("F j,Y",strtotime($row['from_date']));
			$to_date=date("F j,Y",strtotime($row['to_date']));
            $post_status = $row['status'];

            if ($post_status !== 'published') {
                echo "NO POST PLS";
            } else {
                ?>
                <br><br>
                <?php if($alternate % 2 == 0) { ?>
                    <div class="row" style="margin-right:100px;margin-left:100px">
                        <p><h2><?php if($post_link) {echo "<a href='$post_link' target='_blank'>$post_title</a>";} else {echo $post_title;}?></h2></p>
					    <p><h4>Hosted by <a href="#"><?php echo $post_author; ?></a></h4></p>

                        <p><span class="glyphicon glyphicon-time"></span><?php if($from_date==$to_date){echo " $from_date";}else{echo " $from_date - $to_date";} ?></p>
                        <a href="publicposts.php?post=<?php echo $post_id; ?>"></a>
                        <div style="align-items:center">
                            <div class="col-md-6">
                                <p id="postContent<?php echo $post_id; ?>" style="flex:1;font-size:18;text-align:justify;margin-right:20px;line-height:2;">

                                    <span style="color:#0d1a2a;"><a style="color:blue;font-size:16" href="publicposts.php?post=<?php echo $post_id; ?>">Read More...</a></span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <div class="carousel-container" id="carouselContainer<?php echo $post_id; ?>">
                                    <div class="carousel-images">
                                        <?php
                                        $images = explode(',', $post_image);
                                        foreach ($images as $image) {
                                            ?>
                                            <img id="postImage<?php echo $post_id; ?>" src="allpostpics/<?php echo $image; ?>" class="carousel-image" alt="...">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                <script>
								 var postImage = document.getElementById("postImage<?php echo $post_id; ?>");
	
    var postContent =`<?php echo addslashes($post_content); ?>`; // Escape special characters
    var maxLength = calculateMaxLength();
	
    document.getElementById("postContent<?php echo $post_id; ?>").innerHTML = truncateContent(postContent, maxLength);
    document.getElementById("postContent<?php echo $post_id; ?>").innerHTML += " <span style='color:#0d1a2a;'><a style='color:blue;font-size:16' href='publicposts.php?post=<?php echo $post_id; ?>'>Read More...</a></span>";
                                    var carouselIndex<?php echo $post_id; ?> = 0;
                                    var carouselImages<?php echo $post_id; ?> = document.getElementById('carouselContainer<?php echo $post_id; ?>').getElementsByClassName('carousel-images')[0];
                                    var totalImages<?php echo $post_id; ?> = carouselImages<?php echo $post_id; ?>.children.length;

                                    function nextSlide<?php echo $post_id; ?>() {
                                        carouselIndex<?php echo $post_id; ?> = (carouselIndex<?php echo $post_id; ?> + 1) % totalImages<?php echo $post_id; ?>;
                                        updateCarousel<?php echo $post_id; ?>();
                                    }

                                    function updateCarousel<?php echo $post_id; ?>() {
                                        carouselImages<?php echo $post_id; ?>.style.transform = 'translateX(' + (-carouselIndex<?php echo $post_id; ?> * 100) + '%)';
                                    }

                                    setInterval(nextSlide<?php echo $post_id; ?>, 2000); // Change interval as needed (in milliseconds)


   


    function calculateMaxLength() {
        var imageHeight = postImage.offsetHeight;
		var maxLengthRatio;
		console.log(imageHeight);
		if(window.innerHeight >=768){maxLengthRatio=1;}
		else{maxLengthRatio=1.3;}
          // Adjust this ratio as needed
        var maxLength = Math.floor(imageHeight * maxLengthRatio);
        return maxLength;
    }

    // Truncate content
    function truncateContent(content, maxLength) {
        if (content.length <= maxLength) {
            return content;
        } else {
            return content.substring(0, maxLength) + "...";
        }
    }

    // Show full content
    function showFullContent() {
        document.getElementById("postContent").innerHTML = postContent;
        document.querySelector("button").style.display = "none";
    }

</script>
                            </div>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="row" style="margin-right:100px;margin-left:100px">
                  <p><h2><?php if($post_link) {echo "<a href='$post_link' target='_blank'>$post_title</a>";} else {echo $post_title;}?></h2></p>
					    <p><h4>Hosted by <a href="#"><?php echo $post_author; ?></a></h4></p>
                        <p><span class="glyphicon glyphicon-time"></span>Held on <?php if($from_date==$to_date){echo "$from_date";}else{echo "$from_date, $to_date";} ?></p>
                        <a href="publicposts.php?post=<?php echo $post_id; ?>"></a>
                        <div style="align-items:center">
                            <div class="col-md-6">
                                <div class="carousel-container" id="carouselContainer<?php echo $post_id; ?>">
                                    <div class="carousel-images">
                                        <?php
                                        $images = explode(',', $post_image);
                                        foreach ($images as $image) {
                                            ?>
                                            <img id="postImage<?php echo $post_id; ?>" src="allpostpics/<?php echo $image; ?>" class="carousel-image" alt="...">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                                
								
                            </div>
                            <div class="col-md-6">

                                <p id="postContent<?php echo $post_id; ?>" style="flex-grow:1;font-size:18;text-align:justify;margin-left:20px;line-height:2;">


                                </p>
                            </div>
							<script>
							 var postImage = document.getElementById("postImage<?php echo $post_id; ?>");
	
    var postContent =`<?php echo addslashes(substr($post_content,0,700)); ?>`; // Escape special characters
    var maxLength = calculateMaxLength();
	
    document.getElementById("postContent<?php echo $post_id; ?>").innerHTML = truncateContent(postContent, maxLength);
    document.getElementById("postContent<?php echo $post_id; ?>").innerHTML += " <span style='color:#0d1a2a;'><a style='color:blue;font-size:16' href='publicposts.php?post=<?php echo $post_id; ?>'>Read More...</a></span>";
                                    var carouselIndex<?php echo $post_id; ?> = 0;
                                    var carouselImages<?php echo $post_id; ?> = document.getElementById('carouselContainer<?php echo $post_id; ?>').getElementsByClassName('carousel-images')[0];
                                    var totalImages<?php echo $post_id; ?> = carouselImages<?php echo $post_id; ?>.children.length;

                                    function nextSlide<?php echo $post_id; ?>() {
                                        carouselIndex<?php echo $post_id; ?> = (carouselIndex<?php echo $post_id; ?> + 1) % totalImages<?php echo $post_id; ?>;
                                        updateCarousel<?php echo $post_id; ?>();
                                    }

                                    function updateCarousel<?php echo $post_id; ?>() {
                                        carouselImages<?php echo $post_id; ?>.style.transform = 'translateX(' + (-carouselIndex<?php echo $post_id; ?> * 100) + '%)';
                                    }

                                    setInterval(nextSlide<?php echo $post_id; ?>, 2000); // Change interval as needed (in milliseconds)
                                

    


    function calculateMaxLength() {
        var imageHeight = postImage.offsetHeight;
		var maxLengthRatio;
		console.log(imageHeight);
		if(window.innerHeight >=768){maxLengthRatio=1;}
		else{maxLengthRatio=1.3;}
          // Adjust this ratio as needed
        var maxLength = Math.floor(imageHeight * maxLengthRatio);
        return maxLength;
    }

    // Truncate content
    function truncateContent(content, maxLength) {
        if (content.length <= maxLength) {
            return content;
        } else {
            return content.substring(0, maxLength) + "...";
        }
    }

    // Show full content
    function showFullContent() {
        document.getElementById("postContent").innerHTML = postContent;
        document.querySelector("button").style.display = "none";
    }

</script>
                        </div>
                    </div>
                <?php }
                $alternate++;
		}}
        }
        // Pagination links
        $query = "SELECT COUNT(*) AS total FROM posts WHERE YEAR(from_date)=$yearno and status='published'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_pages = ceil($row["total"] / $per_page);

        echo "<br><br>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='col-auto' align=center>";
        echo "<ul class='pagination'>";

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='?page=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
    }
    ?>
    <br><br>

    
    <br><br>

    <?php include 'includes/footer.php';?>
    <script src="admin/js/tinymce/tinymce.min.js"></script>
    <script src="admin/js/tinymce/script.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.js"></script>
	 <script>
    document.getElementById('yeardropdown').addEventListener('change', function () {
    var selectedDepartment = this.value;
    window.location.href = "index.php?year=" + selectedDepartment;
	 this.selectedIndex = this.options.selectedIndex;});
    </script>
	<script>
// Assuming 'selectedDepartment' contains the value that you want to match with the dropdown options
var selectedDepartment = "<?php echo $yearno; ?>";

// Get the dropdown element
var yeardropdown = document.getElementById('yeardropdown');

// Iterate through the options and set the selected attribute for the matching option
for (var i = 0; i < yeardropdown.options.length; i++) {
    if (yeardropdown.options[i].value === selectedDepartment) {
        yeardropdown.options[i].selected = true;
        break;
    }
}</script>

</body>
</html>
