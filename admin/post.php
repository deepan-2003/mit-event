<?php include 'includes/connection.php';?>
<?php include 'includes/adminheader.php';?>
<?php
if (isset($_GET['post'])) {
	$post = mysqli_real_escape_string($conn, $_GET['post']);  
}
else {
    header('location:posts.php');
}
$currentuser = $_SESSION['firstname'];
if ($_SESSION['role'] == 'superadmin') {
$query = "SELECT * FROM posts WHERE id='$post'";
}
else {
    $query = "SELECT * FROM posts WHERE id='$post' AND author = '$currentuser'" ;
}
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0 ) {
while ($row = mysqli_fetch_array($run_query)) {
	$post_title = $row['title'];
	$post_id = $row['id'];
	$post_author = $row['author'];
	$post_date = $row['postdate'];
	$post_image = $row['image'];
	$post_content = $row['content'];
	$post_tags = $row['tag'];
	$post_status = $row['status'];

	?>
   
    <div id="wrapper">
       <?php include 'includes/adminnav.php';?>
    <div id="page-wrapper">


    <div class="container-fluid">
    <div class="container">

        <div class="row">

            
            <div class="col-lg-8">

                
                <hr>
	       		<p><h2><a href="#"><?php echo $post_title; ?></a></h2></p>
                <p><h3>by <a href="#"><?php echo $post_author; ?></a></h3></p>
                <p><span class="glyphicon glyphicon-time"></span>Posted on <?php echo $post_date; ?></p>
                 <div id="carouselExampleControls<?php echo $post_id; ?>" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $images = explode(',', $post_image);
                                $active = true;
                                foreach ($images as $image) {
                                    ?>
                                    <div class="item <?php echo $active ? 'active' : ''; ?>">
                                        <img id="postImage<?php echo $post_id; ?>" style="border-radius:20px" width="700px" height="350px" name="image" style="margin-right:10px" src="../allpostpics/<?php echo $image; ?>" class="d-block w-100" alt="...">
                                    </div>
                                    <?php
                                    $active = false;
                                }
                                ?>
				
                            </div>
							
                            <a class="carousel-control-prev" href="#carouselExampleControls<?php echo $post_id; ?>" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleControls<?php echo $post_id; ?>" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                <p><?php echo $post_content; ?></p>

                <hr>
                <?php } }
                else { echo"<script>alert('error');</script>"; } ?>
	        	
  </div>

           

        </div>
        </div>
        </div>
        </div>
        </div>

   

    
    <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>
</body>
</html>