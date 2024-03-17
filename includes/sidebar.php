<?php include 'includes/header.php';?>
<div class="well">
    <h4>Search</h4>
    <form id="searchForm" method="POST" action="search.php">
        <div class="input-group">
            <select width="100px" class="form-control" aria-label="size 3 select example" id="select_year" name="select_year">
                <?php
                // Generate options for years from 2016 to 2024
                for ($year = 2016; $year <= 2024; $year++) {
                    // Check if the current year is 2024 and set it as the default selected option
                    $selected = ($year == 2024) ? 'selected' : '';
                    echo "<option value=\"$year\" $selected>$year</option>";
                }
                ?>
            </select>
            <span class="input-group-btn">
                <button id="searchButton" name="submit" class="btn btn-default" type="submit">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>
</div>


