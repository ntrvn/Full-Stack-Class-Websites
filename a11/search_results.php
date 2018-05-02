<?php

$page_url = preg_replace('/&page=\d*/', '', $_SERVER['REQUEST_URI'] );

$host = "303.itpwebdev.com";
$user = "trannhan_db_user";
$pass = "Hahaha123!";
$db = "trannhan_dvd_db";

// DB Connection
$mysqli = new mysqli($host, $user, $pass, $db);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');

$sql = "SELECT COUNT(*) AS count
		FROM dvd_titles
        LEFT JOIN genres
			ON genres.genre_id = dvd_titles.genre_id
		LEFT JOIN ratings
			ON ratings.rating_id = dvd_titles.rating_id
		LEFT JOIN labels
			ON labels.label_id = dvd_titles.label_id
		LEFT JOIN formats
			ON formats.format_id = dvd_titles.format_id
		LEFT JOIN sounds
			ON sounds.sound_id = dvd_titles.sound_id
		WHERE 1=1";

if ( isset($_GET['title']) && !empty($_GET['title']) ) {
	$sql = $sql . " AND title LIKE '%" . $_GET['title'] . "%'";
}
if ( isset($_GET['genre']) && !empty($_GET['genre']) ) {
	$sql = $sql . " AND dvd_titles.genre_id = " . $_GET['genre'];
}
if ( isset($_GET['rating']) && !empty($_GET['rating']) ) {
	$sql = $sql . " AND dvd_titles.rating = " . $_GET['rating'];
}
if ( isset($_GET['label']) && !empty($_GET['label']) ) {
	$sql = $sql . " AND dvd_titles.label = " . $_GET['label'];
}
if ( isset($_GET['format']) && !empty($_GET['format']) ) {
	$sql = $sql . " AND dvd_titles.format = " . $_GET['format'];
}
if ( isset($_GET['sound']) && !empty($_GET['sound']) ) {
	$sql = $sql . " AND dvd_titles.sound = " . $_GET['sound'];
}
if ( isset($_GET['award']) && !empty($_GET['award']) && $_GET['award'] == "yes" ) {
	$sql = $sql . " AND award IS NOT NULL";
}
if ( isset($_GET['award']) && !empty($_GET['award']) && $_GET['award'] == "no" ) {
	$sql = $sql . " AND award IS NULL";
}
if ( isset($_GET['release_date_from']) && !empty($_GET['release_date_from']) && empty($_GET['release_date_to'])) {
	$sql = $sql . " AND release_date > '" . $_GET['release_date_from'] . "'";
} else if (isset($_GET['release_date_to']) && !empty($_GET['release_date_to']) && empty($_GET['release_date_from'])) {
	$sql = $sql . " AND release_date < '" . $_GET['release_date_to'] . "'";
} else if (isset($_GET['release_date_to']) && !empty($_GET['release_date_to']) && isset($_GET['release_date_to']) && !empty($_GET['release_date_to'])) {
	$sql = $sql . " AND release_date BETWEEN '" . $_GET['release_date_from'] . "'" . " AND '" . $_GET['release_date_to'] . "'" ;
}


$sql = $sql . ";";

$results = $mysqli->query($sql);
if ( $results == false ) {
	echo $mysqli->error;
	exit();
}

// Gather some information for our pagination
$results_per_page = 10;
$first_page = 1;

$row = $results->fetch_assoc();
$num_results = $row['count'];

// divided and round up
$last_page = ceil($num_results / $results_per_page);

// current page is what the URL says it is

if( isset($_GET['page']) && !empty($_GET['page'])) {
    $current_page = $_GET['page'];
}
else {
    $current_page = $first_page;
}

// Make sure page is within bounds
if ( $current_page < $first_page ) {
    $current_page = $first_page;
}
elseif ( $current_page > $last_page) {
    $current_page = $last_page;
}

$start_index = ($current_page - 1 ) * $results_per_page;

// // Echo out variables
// echo "<hr>" . $sql . "<hr>";
// echo "Current page: " . $current_page . "<hr>";
// echo "Last page: " . $last_page . "<hr>";
// echo "Num of results: " . $num_results . "<hr>";
// echo "This page starts with result number: " . $start_index . "<hr>";

// Replace query so that we see column names
$sql = str_replace('COUNT(*) AS count', 'title, release_date,genres.genre,ratings.rating, dvd_title_id', $sql);

//echo "<hr>" . $sql . "<hr>";

$sql = str_replace(';', '', $sql);

//echo "<hr>" . $sql . "<hr>";

$sql = $sql . " LIMIT " . $start_index . ", " . $results_per_page . ";";

//echo "<hr>" . $sql . "<hr>";

$results = $mysqli->query($sql);
if ($results == false) {
    echo $mysqli->error;
    exit();
}


$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item active"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item">
							<a class="page-link"href="<?php echo $page_url . '&page=1' ?>">First</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url . '&page=' . ($current_page - 1); ?>">Previous</a>
						</li>
						<li class="page-item active">
							<a class="page-link" href="">
								<?php echo $current_page; ?>

							</a>
						</li>
						<li class="page-item">
							<a class="page-link" href=" <?php echo $page_url . '&page=' . ($current_page + 1); ?>">Next</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url . '&page=' . $last_page; ?>">Last</a>
						</li>
					</ul>
				</nav>
			</div> <!-- .col -->
			<div class="col-12">
				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

<!-- 						<tr>
							<td>
								Title name. This should link to the detail page of this title.
							</td>
							<td>Release Date</td>
							<td>Genre</td>
							<td>Rating</td>
						</tr> -->
						<?php while ( $row = $results->fetch_assoc() ) : ?>
							<tr>
								<td><a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>"><?php echo $row['title']; ?></a></td>
								<td><?php echo $row['release_date']; ?></td>
								<td><?php echo $row['genre']; ?></td>
								<td><?php echo $row['rating']; ?></td>
								<td>
									<a href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>&title=<?php echo $row['title']; ?>" class="btn btn-outline-danger" onclick="return confirm('You are about to delete <?php echo $row['title']; ?>.');">
										Delete
									</a>
								</td>
							</tr>
						<?php endwhile; ?>


					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>