<?php include 'includes/adminheader.php'; ?>

<div id="wrapper">
    <?php include 'includes/adminnav.php'; ?>
    <div id="page-wrapper">
        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">
                        PUBLISH EVENTS
                    </h1>
<?php if(isset($_POST['view'])){

}
	?>
                    <?php
                    if (isset($_POST['save']) || isset($_POST['publish'])) {
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
                           
                           $post_content = htmlspecialchars($_POST['content']); // Encode HTML special characters
							$post_content = mysqli_real_escape_string($conn, $post_content);
							$post_link=$_POST['post_link'];
							$from_date=$_POST['from_date'];
							$to_date=$_POST['to_date'];
                            if (isset($_SESSION['firstname'])) {
                                $post_author = $_SESSION['firstname'];
                            }
                            $post_date = date('Y-m-d');
							$event_host=$_POST['event_host'];
                            $post_status =isset($_POST['save'])?"draft":"published";
							if (count(array_filter($_FILES['image']['name'])) === 0) {
        echo "<script>alert('Please upload at least one image.');</script>";
    }
	else if(count(array_filter($_FILES['image']['name'])) > 3)
	{
		echo "<script>alert('Please upload atmost 3 images.');</script>";
	}
	else {
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
										echo "<script>alert('Please upload image atmost 1 MB.');</script>;window.location.href='publishnews.php';</script>";
									}
                                }
								else{
									echo "<script> alert('Image Not found');
                                window.location.href='posts.php';</script>";
								}
                            }

                            // Insert image names into the database
                            $images_string = implode(',', $image_names);

                            $query = "INSERT INTO posts (title, author, postdate, image, content, status,link,from_date,to_date) VALUES ('$post_title' , '$event_host' , '$post_date' , '$images_string' , '$post_content' , '$post_status','$post_link','$from_date','$to_date') ";
                            $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
                            if (mysqli_affected_rows($conn) > 0) {
								if(isset($_POST['publish'])){
                                echo "<script> alert('EVENT posted successfully.');
                                window.location.href='posts.php';</script>";}
								else
								{
									 echo "<script> alert('EVENT added to draft successfully.');
                                window.location.href='posts.php';</script>";
								}
                            }
							
							else {
                                echo "<script> alert('Error while posting..try again');</script>";
	}}
                        }
                    }
                    ?>

                    <form role="form" action="" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label for="post_title">Post Title</label>
                            <input type="text" name="title" placeholder="ENTER TITLE " value="<?php if (isset($_POST['save'])) {echo $post_title;} ?>" class="form-control">
                        </div>
						<div class="form-group">
							<label for="post_link">Post Link</label>
							<input type="url" name="post_link" class="form-control" placeholder="Enter the URL" >
						</div>
						<div class="form-group">
							<label for="post_link">Event Host</label>
							<input type="text" name="event_host" class="form-control" placeholder="Enter the Host" >
						</div>
						<div  id="imagePreview">
                            <!-- Image preview will be shown here -->
                        </div>
                        <div class="form-group">
                            <label for="post_image">Post Image</label> <font color='brown'> &nbsp;&nbsp;(Upload Alteast one image) </font>
                            <input type="file" name="image[]" multiple >
                        </div>
                        <div class="input-group">
						<div class="row">
						<div class="col-md-6">
						<div class="form-group">
							<label for="from_date">From Date</label>
							<input type="date" name="from_date" class="form-control" required>
						</div></div>
						<div class="col-md-6">
						<div class="form-group">
							<label for="to_date">To Date</label>
							<input type="date" name="to_date" class="form-control" required>
						</div></div></div></div>

                        <div class="form-group">
                            <label for="post_content">Post Content</label>
                            <textarea class="form-control" name="content" id="" cols="30" rows="15"><?php if(isset($_POST['save'])){echo $post_content;}?></textarea>
                        </div>
						<div class="form-group">
						<div class="row">
						<div class="col-md-4">
                        <button type="submit" name="save" class="btn btn-primary" value="Publish Post">Save To Draft</button>
                       
                   </div>
						<div class="col-md-8" align=right>
                        <button type="submit" name="publish" class="btn btn-primary" value="Publish Post">Publish Post</button></div>
						</div>
                    </form>

                </div>
            </div>

        </div>
    </div>
    <?php include 'includes/adminfooter.php'; ?>
</div>

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
