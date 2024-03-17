<?php include 'includes/header.php';?>
<?php include 'includes/navbar.php';?><html><body>
<div class="container">

    <div class="row" style="flex-grow:0">
 
            <?php
            if (isset($_GET['post'])) {
                $post = $_GET['post'];
                if (!is_numeric($post)) {
                    header("location:index.php");
                }
            } else {
                header('location: index.php');
            }
            $query = "SELECT * FROM posts WHERE id=$post";
            $run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
            if (mysqli_num_rows($run_query) > 0 ) {
                while ($row = mysqli_fetch_array($run_query)) {
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
            ?>
                    <!-- Blog Post Content Column -->
                    <div class="col-md-12" align=center>
                        <!--First Post -->
                        <hr>
                        <p><h2><a href="<?php echo $post_link; ?>" target="_blank"><?php echo $post_title; ?></a></h2></p>

                        <p><span class="glyphicon glyphicon-time"></span>Held on <?php if($from_date==$to_date){echo "$from_date";}else{echo "$from_date, $to_date";} ?></p>
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
                                </script>
                        <p style="flex-grow:1;font-size:18;text-align:justify;margin-left:20px;line-height:2;"><?php echo $post_content; ?></p>
                        <hr>
                    </div>
            <?php 
                }
            } else {
                header("location: index.php");
            }
            ?>
        
       
    </div>

</div>
<!-- /.row -->
<br><br>
    <div class="row justify-content-center">
        <div class="col-auto" align=center>
            <form method="POST" action="index.php">
                <button name="submit" value="2024" type="submit" class="btn btn-primary">Back</button>
            </form>
        </div>
    </div>
	<br><br>

<!-- Footer -->
<?php include 'includes/footer.php';?>
<!-- /.container -->

<!-- jQuery -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
