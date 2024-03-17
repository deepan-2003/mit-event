<?php include 'includes/adminheader.php';
?>
    <div id="wrapper">
<?php ?>
       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        <div class="col-xs-4">
            <a href="publishnews.php" class="btn btn-primary">Add New</a>
            </div>
                            ALL POSTS
                        </h1>
                         
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
<?php if($_SESSION['role'] == 'superadmin')  
{ ?>
<div class="row">
<div class="col-lg-12"><h2>Drafts</h2>
        <div class="table-responsive">

<form action="" method="post">
            <table class="table table-bordered table-striped table-hover">


            <thead>
                    <tr>
                        <th>ID</th>
                       
                        <th>Title</th>
                 <th>URL</th>
                        <th>Image</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>View Post</th>
                        <th>Edit</th>
                        <th>Delete</th>
           
                    </tr>
                </thead>
                <tbody>

                 <?php
				 $yearno = isset($_GET['year']) ? $_GET['year'] : $current;
    error_reporting(E_ERROR | E_PARSE);
     $per_page = 3; // Number of posts per page
    $page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page

    $start = ($page - 1) * $per_page; // Starting post index for the current page

$query = "SELECT * FROM posts where YEAR(from_date)=$yearno and status='draft' ORDER BY id DESC LIMIT $start,$per_page";
	$image='';$images='';$active='';
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_array($run_query)) {
    $post_id = $row['id'];
    $post_title = $row['title'];
	$post_url=$row['link'];
    $post_date = $row['postdate'];
    $post_image = $row['image'];
    $post_content = $row['content'];
    $from_date = $row['from_date'];

    $to_date = $row['to_date'];
  

    echo "<tr>";
    echo "<td>$post_id</td>";

    echo "<td>$post_title</td>";
	echo "<td><a href='$post_url'>$post_url</a></td>"
    
	?>
    <td><div id="carouselExampleControls<?php echo $post_id; ?>" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $images = explode(',', $post_image);
                                $active = true;
                                foreach ($images as $image) {
                                    ?>
                                    <div class="item <?php echo $active ? 'active' : ''; ?>">
                                        <img  width="100" height="100" 	name="image" style="margin-right:10px" src="../allpostpics/<?php echo $image; ?>" class="d-block w-100" alt="...">
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
                        </div></td><?php
	
    echo "<td>$from_date</td>";
    echo "<td>$to_date</td>";
    echo "<td><a href='post.php?post=$post_id' style='color:green'>See Post</a></td>";
    echo "<td><a href='editposts.php?id=$post_id'><span class='glyphicon glyphicon-edit' style='color: #265a88;'></span></a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$post_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";
    

    echo "</tr>";

}
}
else {
  
}
?>


                </tbody>
            </table>
</form>
</div>
</div>
</div>
<?php
 $query = "SELECT COUNT(*) AS total FROM posts WHERE YEAR(from_date)=$yearno and status='draft'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
		$total=$row['total'];
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
        echo "</div>";?>
<div class="row">
<div class="col-lg-12"><h2>Published</h2>
        <div class="table-responsive">

<form action="" method="post">
            <table class="table table-bordered table-striped table-hover">


            <thead>
                    <tr>
                        <th>ID</th>
                       
                        <th>Title</th>
                 <th>URL</th>
                        <th>Image</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>View Post</th>
                        <th>Edit</th>
                        <th>Delete</th>
           
                    </tr>
                </thead>
                <tbody>

                 <?php
				 
				 $current=date("Y");
				 $yearno = isset($_GET['year']) ? $_GET['year'] : $current;
    error_reporting(E_ERROR | E_PARSE);
     $per_page = 3; // Number of posts per page
    $page = isset($_GET['page2']) ? $_GET['page2'] : 1; // Current page

    $start = ($page - 1) * $per_page; // Starting post index for the current page

$query = "SELECT * FROM posts where YEAR(from_date)=$yearno and status='published' ORDER BY id DESC LIMIT $start,$per_page";
	$image='';$images='';$active='';
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_array($run_query)) {
    $post_id = $row['id'];
    $post_title = $row['title'];
	$post_url=$row['link'];
    $post_date = $row['postdate'];
    $post_image = $row['image'];
    $post_content = $row['content'];
    $from_date = $row['from_date'];

    $to_date = $row['to_date'];
  

    echo "<tr>";
    echo "<td>$post_id</td>";

    echo "<td>$post_title</td>";
	echo "<td><a href='$post_url'>$post_url</a></td>"
    
	?>
    <td><div id="carouselExampleControls<?php echo $post_id; ?>" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <?php
                                $images = explode(',', $post_image);
                                $active = true;
                                foreach ($images as $image) {
                                    ?>
                                    <div class="item <?php echo $active ? 'active' : ''; ?>">
                                        <img  width="100" height="100" 	name="image" style="margin-right:10px" src="../allpostpics/<?php echo $image; ?>" class="d-block w-100" alt="...">
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
                        </div></td><?php
	
    echo "<td>$from_date</td>";
    echo "<td>$to_date</td>";
    echo "<td><a href='post.php?post=$post_id' style='color:green'>See Post</a></td>";
    echo "<td><a href='editposts.php?id=$post_id'><span class='glyphicon glyphicon-edit' style='color: #265a88;'></span></a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$post_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";
    

    echo "</tr>";

}
}
else {
    echo "<script>alert('Not any news yet! Start Posting now');
    window.location.href= 'publishnews.php';</script>";
}
?>


                </tbody>
            </table>
</form>
</div>
</div>
</div>
<?php
 $query = "SELECT COUNT(*) AS total FROM posts WHERE YEAR(from_date)=$yearno and status='published'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $total_pages = ceil($row["total"] / $per_page);

        echo "<br><br>";
        echo "<div class='row justify-content-center'>";
        echo "<div class='col-auto' align=center>";
        echo "<ul class='pagination'>";

        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<li class='page-item'><a class='page-link' href='?page2=$i'>$i</a></li>";
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";?>
 <?php
    if (isset($_GET['del'])) {
        $post_del = mysqli_real_escape_string($conn, $_GET['del']);
        $del_query = "DELETE FROM posts WHERE id='$post_del'";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('post deleted successfully');
            window.location.href='posts.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }
        if (isset($_GET['pub'])) {
        $post_pub = mysqli_real_escape_string($conn,$_GET['pub']);
        $pub_query = "UPDATE posts SET status='published' WHERE id='$post_pub'";
        $run_pub_query = mysqli_query($conn, $pub_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('post published successfully');
            window.location.href='posts.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }

?>
<?php 
}
else if($_SESSION['role'] == 'admin') {
    ?>
    <div class="row">
<div class="col-lg-12">
        <div class="table-responsive">

<form action="" method="post">
            <table class="table table-bordered table-striped table-hover">


            <thead>
                    <tr>
                        <th>ID</th>
                        <th>Author</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>View Post</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>Publish</th>
                    </tr>
                </thead>
                <tbody>

                 <?php
$currentuser = $_SESSION['firstname'];
$query = "SELECT * FROM posts WHERE author = '$currentuser' ORDER BY id DESC";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_array($run_query)) {
    $post_id = $row['id'];
    $post_title = $row['title'];
    $post_author = $row['author'];
    $post_date = $row['postdate'];
    $post_image = $row['image'];
    $post_content = $row['content'];
    $post_tags = $row['tag'];
    $post_status = $row['status'];

    echo "<tr>";
    echo "<td>$post_id</td>";
    echo "<td>$post_author</td>";
    echo "<td>$post_title</td>";
    echo "<td>$post_status</td>";
    echo "<td><img  width='100' src='../allpostpics/$post_image' alt='Post Image' ></td>";
    echo "<td>$post_tags</td>";
    echo "<td>$post_date</td>";
    echo "<td><a href='post.php?post=$post_id' style='color:green'>See Post</a></td>";
    echo "<td><a href='editposts.php?id=$post_id'><span class='glyphicon glyphicon-edit' style='color: #265a88;'></span></a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$post_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to publish this post?')\"href='?pub=$post_id'><i class='fa fa-times' style='color: red;'></i>publish</a></td>";

    echo "</tr>";

}
}
else {
    echo "<script>alert('You have not posted any news yet! Start Posting now');
    window.location.href= 'publishnews.php';</script>";
}
?>


                </tbody>
            </table>
</form>
</div>
</div>
</div>

 <?php
    if (isset($_GET['del'])) {
        $post_del = mysqli_real_escape_string($conn, $_GET['del']);
        $del_query = "DELETE FROM posts WHERE id='$post_del'";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('post deleted successfully');
            window.location.href='posts.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }
        if (isset($_GET['pub'])) {
        $post_pub = mysqli_real_escape_string($conn,$_GET['pub']);
        $pub_query = "UPDATE posts SET status='published' WHERE id='$post_pub'";
        $run_pub_query = mysqli_query($conn, $pub_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('post published successfully');
            window.location.href='posts.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }

?>
<?php 
}
else {
    ?>
<div class="row">
<div class="col-lg-12">
        <div class="table-responsive">

<form action="" method="post">
            <table class="table table-bordered table-striped table-hover">
 <thead>
                    <tr>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Image</th>
                        <th>Tags</th>
                        <th>Date</th>
                        <th>View Post</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>

                 <?php
                 $currentuser = $_SESSION['firstname'];

$query = "SELECT * FROM posts WHERE author = '$currentuser' ORDER BY id DESC";
$run_query = mysqli_query($conn, $query) or die(mysqli_error($conn));
if (mysqli_num_rows($run_query) > 0) {
while ($row = mysqli_fetch_array($run_query)) {
    $post_id = $row['id'];
    $post_title = $row['title'];
    $post_author = $row['author'];
    $post_date = $row['postdate'];
    $post_image = $row['image'];
    $post_content = $row['content'];
    $post_tags = $row['tag'];
    $post_status = $row['status'];

    echo "<tr>";
    echo "<td>$post_title</td>";
    echo "<td>$post_status</td>";
    echo "<td><img  width='100' src='../allpostpics/$post_image' alt='Post Image' ></td>";
    echo "<td>$post_tags</td>";
    echo "<td>$post_date</td>";
    echo "<td><a href='post.php?post=$post_id' style='color:green'>See Post</a></td>";
    echo "<td><a href='editposts.php?id=$post_id'><span class='glyphicon glyphicon-edit' style='color: #265a88;'></span></a></td>";
    echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete this post?')\" href='?del=$post_id'><i class='fa fa-times' style='color: red;'></i>delete</a></td>";

    echo "</tr>";

}
}
else {
    echo "<script>alert('You have not posted any news yet! Start Posting now');
    window.location.href= 'publishnews.php';</script>";
}
?>
 </tbody>
            </table>
</form>
</div>
</div>
</div>
<?php
    if (isset($_GET['del'])) {
        $post_del =  $_GET['del'];
		
        $del_query = "DELETE FROM posts WHERE id=$post_del";
        $run_del_query = mysqli_query($conn, $del_query) or die (mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
            echo "<script>alert('post deleted successfully');
            window.location.href='posts.php';</script>";
        }
        else {
         echo "<script>alert('error occured.try again!');</script>";   
        }
        }?>
<?php    
}
?>
        </div>
    </div>
</div>
</div>
</div>
 <script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>
 <script>
    document.getElementById('yeardropdown').addEventListener('change', function () {
    var selectedDepartment = this.value;
    window.location.href = "posts.php?year=" + selectedDepartment;
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

</html


