<?php include 'includes/connection.php';?>
<?php include 'includes/adminheader.php';?>
<?php

                    ?>
<?php
if (isset($_GET['id'])) {
	$id = mysqli_real_escape_string($conn, $_GET['id']);  
	
}
else {
	header('location:posts.php');
}
$currentuser = $_SESSION['firstname'];
if ($_SESSION['role'] == 'superadmin') {
$query = "SELECT * FROM posts WHERE id='$id'";
}
else {
    $query = "SELECT * FROM posts WHERE id='$id' AND author = '$currentuser'" ;
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

	$post_status = $row['status'];
	$post_link=$row['link'];
	$from_date=$row['from_date'];
	$to_date=$row['to_date'];
if (isset($_POST['update'])) {
                        require "../gump.class.php";
                        $gump = new GUMP();
                        $_POST = $gump->sanitize($_POST);

                        $gump->validation_rules(array(
                            'title'    => 'required|max_len,120|min_len,5',
                            
                            'content'  => 'required|max_len,20000|min_len,150',
                        ));
                        $gump->filter_rules(array(
                            'title' => 'trim|sanitize_string',
                           
                        ));
                        $validated_data = $gump->run($_POST);

                        if ($validated_data === false) {
                            ?>
                            <center><font color="red"><?php echo $gump->get_readable_errors(true); ?></font></center>
                        <?php
                        } else {
                            $post_title = $validated_data['title'];
                           
                            $post_content = $validated_data['content'];
							$post_link=$_POST['post_link'];
							$from_date=$_POST['from_date'];
							$to_date=$_POST['to_date'];
                            if (isset($_SESSION['firstname'])) {
                                $post_author = $_SESSION['firstname'];
                            }
                            $post_date = date('Y-m-d');
                            $post_status =$_POST['status'];
							if (count(array_filter($_FILES['image']['name'])) >3) {
        echo "<script>alert('Please upload maximum 3 images.');window.location.href = 'editposts.php?id=$id';</script>";
    } else {
                            $image_names = array(); // To store the names of uploaded images
                            $folder  = '../allpostpics/';
                            foreach ($_FILES['image']['tmp_name'] as $key => $tmp_name) {
                                $image = $_FILES['image']['name'][$key];
                                $ext = $_FILES['image']['type'][$key];
                                $validExt = array("image/gif", "image/jpeg", "image/pjpeg", "image/png");
                                if (!empty($image)) {
                                    if ($_FILES['image']['size'][$key] > 0 && $_FILES['image']['size'][$key] <= 1048576 && in_array($ext, $validExt)) {
                                        $imgext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
                                        $picture = $post_title . '_' . ($key + 1) . '.' . $imgext;
                                        if (move_uploaded_file($_FILES['image']['tmp_name'][$key], $folder . $picture)) {
                                            $image_names[] = $picture;
                                        }
                                    }
									else{
										echo "<script>alert('Please upload image atmost 1 MB.');</script>;window.location.href='editposts.php?id=$id';</script>";
									}
                                }
								else{
									if(empty($post_image)){
									echo "<script> alert('Image Not found'); window.location.href='editposts.php?id=$id';</script>";}
								}
                            }

                            // Insert image names into the database
                            $images_string = implode(',', $image_names);
							if(empty($images_string)){$images_string=$post_image;}
                            $queryupdate = "UPDATE posts SET title = '$post_title' , link= '$post_link' , content='$post_content' , 	status = '$post_status' , image = '$images_string' , postdate = '$post_date',from_date='$from_date',to_date='$to_date' WHERE id= '$post_id' " ;
        $result = mysqli_query($conn , $queryupdate) or die(mysqli_error($conn));
        if (mysqli_affected_rows($conn) > 0) {
        	echo "<script>alert('POST SUCCESSFULLY UPDATED');
        	window.location.href= 'posts.php';</script>";
        }
        else {
        	echo "<script>alert('Error! ..try again');</script>";
}}
                        }
                    }
?>

<div id="wrapper">

       <?php include 'includes/adminnav.php';?>
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            UPDATE EVENT
                        </h1>
                        <form role="form" action="" method="POST" enctype="multipart/form-data">


	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input type="text" name="title" class="form-control" value="<?php echo $post_title;  ?>">
	</div>

	<div class="form-group">
							<label for="post_link">Post Link</label>
							<input type="url" name="post_link" class="form-control" placeholder="Enter the URL" value=<?php echo $post_link;?>>
						</div>

                        <div class="form-group">
						 <div class="carousel-container" id="carouselContainer<?php echo $post_id; ?>">
                                    <div class="carousel-images">
                                        <?php
                                        $images = explode(',', $post_image);
                                        foreach ($images as $image) {
                                            ?>
                                            <img width="200" id="postImage<?php echo $post_id; ?>" src="../allpostpics/<?php echo $image; ?>" class="carousel-image" alt="...">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>
								<div  id="imagePreview">
                            <!-- Image preview will be shown here -->
                        </div>
                            <label for="post_image">Post Image</label> <font color='brown'> &nbsp;&nbsp;(Upload Alteast one image) </font>
                            <input type="file" name="image[]" multiple >
                        </div>
                        <div class="input-group">
						<div class="form-group">
							<label for="from_date">From Date</label>
							<input type="date" name="from_date" class="form-control" required value=<?php echo $from_date;?>>
						</div>
						<div class="form-group">
							<label for="to_date">To Date</label>
							<input type="date" name="to_date" class="form-control" required value=<?php echo $to_date;?>>
						</div></div>


	<div class="input-group">
		<label for="post_status">Post Status</label>
			<select name="status" class="form-control">
			<?php if($_SESSION['role'] == 'user') { echo "<option value='draft' >draft</option>"; } else { ?> 
        <option value="<?php  echo $post_status; ?>"><?php  echo  $post_status;  ?></option>>
			<?php
if ($post_status == 'published') {
	echo "<option value='draft'>Draft</option>";
} else {
	echo "<option value='published'>Publish</option>";
}
?>
<?php
}
?>


</select>
</div>
	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea  class="form-control" name="content" id="" cols="30" rows="10"><?php  echo $post_content;  ?>
		</textarea>
	</div>

	<button type="submit" name="update" class="btn btn-primary" value="Update Post">Update Post</button>
</form>

</div>
</div>
</div>
</div>
<?php } }?>	
<script src="js/jquery.js"></script>

    
    <script src="js/bootstrap.min.js"></script>
<script>
    function previewImages(input) {
        var files = input.files;
        var preview = document.getElementById("imagePreview");
        preview.innerHTML = "";

        function readAndPreview(file) {
            // Make sure `file.name` matches our extensions criteria
            if (/\.(jpe?g|png|gif)$/i.test(file.name)) {
                var reader = new FileReader();
                reader.onload = function () {
                    var imageContainer = document.createElement("div");
                    imageContainer.classList.add("image-container");

                    var image = new Image();
                    image.height = 100;
                    image.title = file.name;
                    image.src = this.result;

                    var deleteButton = document.createElement("button");
                    deleteButton.textContent = "×"; // Cross mark
                    deleteButton.classList.add("delete-button");
                    deleteButton.addEventListener("click", function () {
                        preview.removeChild(imageContainer);
                        // Remove the deleted file from the file input
                        updateFileInput(input, file);
                    });

                    imageContainer.appendChild(deleteButton);
                    imageContainer.appendChild(image);

                    preview.appendChild(imageContainer);
                };
                reader.readAsDataURL(file);
            }
        }

        if (files) {
            [].forEach.call(files, readAndPreview);
        }
    }

    // Update the file input to remove the deleted file
    function updateFileInput(input, fileToRemove) {
        var dataTransfer = new DataTransfer();
        Array.from(input.files).forEach(function (file) {
            if (file !== fileToRemove) {
                dataTransfer.items.add(file);
            }
        });
        input.files = dataTransfer.files;
    }

    // Add event listener to file input
    var fileInput = document.querySelector("input[type='file']");
    fileInput.addEventListener("change", function () {
        previewImages(this);
    });
</script>
<style>
    #imagePreview {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto; /* Add horizontal scrollbar if necessary */
        white-space: nowrap; /* Prevent line breaks */
    }
    .image-container {
        margin-right: 10px; /* Add spacing between images */
        position: relative; /* Make the container relative for positioning the delete button */
    }
    .delete-button {
        position: absolute;
        top: 5px;
        right: 5px;
        background: none;
		background-color: red;
        border: none;
        color: white; /* Change color to black */
        font-size: 15px;
        cursor: pointer;
    }
</style>
</body>

</html>

