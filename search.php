<html style="margin:0;border:0">
<?php include 'includes/header.php';?>

<?php include 'includes/navbar.php';?>

<div class="container">
    <div class="row">
	<div class="col-md-10"></div>
        <div class="col-md-2 offset-md-8 text-right">
            <select width="4%" class="form-control" aria-label="size 3 select example" id="yeardropdown" name="select_year">
                <?php
                $current = date("Y");
                // Generate options for years from 2016 to 2024
                for ($year = 2016; $year <= $current; $year++) {
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
    error_reporting(E_ERROR | E_PARSE);
     $per_page = 3; // Number of posts per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

    $start = ($page - 1) * $per_page; // Starting post index for the current page
    $query = "SELECT * FROM posts WHERE YEAR(from_date)=$yearno AND status='published' ORDER BY from_date LIMIT $start,$per_page";
    $search_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($search_query);
    if ($count == 0) {?>
		
		<div class="row" style="margin-right: 20%; margin-left: 20%">
        <div class="col-md-12 text-center">
            <h1 class="page-header">Sorry, no result found for your query</h1>
        </div></div>
    <?php } else { ?>
        <!-- Results Found Container -->
        <div class="row" style="margin-right: 20%; margin-left: 20%">
            <?php
            while ($row = mysqli_fetch_array($search_query)) {
                $post_title = $row['title'];
                $post_id = $row['id'];
                $post_author = $row['author'];
                $post_date = $row['postdate'];
				$post_link=$row['link'];
                $post_image = $row['image'];
                $post_content = $row['content'];
                $from_date=date("F j,Y",strtotime($row['from_date']));
			$to_date=date("F j,Y",strtotime($row['to_date']));
                $post_status = $row['status'];
                ?>
                <!-- Post Area-->
                <div align="center" class="col-md-12">
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
								
							
                            
                       
                    <br><br>
                    <p style="text-align:justify;font-size:18"><?php echo substr($post_content, 0, 500) . '.........'; ?></p>
                    <a href="publicposts.php?post=<?php echo $post_id; ?>"><button type="button" class="btn btn-primary">Read More<span class="glyphicon glyphicon-chevron-right"></span></button></a>
                </div>
                <!-- Post Area -->
	<?php } echo "</div>"; }
	 $query = "SELECT COUNT(*) AS total FROM posts WHERE YEAR(from_date)=$yearno and status='published'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_pages = ceil($row["total"] / $per_page);

        echo "<br><br>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='col-auto' align=center>";
        echo "<ul class='pagination'>";

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='search.php?page=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
	
	
	
	?>
	
  
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
<  <!-- Footer -->
    
  <script src="js/jquery.js"></script>
  <script src="js/bootstrap.min.js"></script>
      <script>
    document.getElementById('yeardropdown').addEventListener('change', function () {
    var selectedDepartment = this.value;
    window.location.href = "search.php?year=" + selectedDepartment;
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
