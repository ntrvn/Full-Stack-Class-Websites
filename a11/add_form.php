<?php
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

// Genres
$sql = "SELECT * FROM genres";
$results_genres = $mysqli->query($sql);
if ($results_genres == false) {
    echo $mysqli->error;
    exit();
}

// Rating
$sql = "SELECT * FROM ratings";
$results_ratings = $mysqli->query($sql);
if ($results_ratings == false) {
    echo $mysqli->error;
    exit();
}

// Label
$sql = "SELECT * FROM labels";
$results_labels = $mysqli->query($sql);
if ($results_labels == false) {
    echo $mysqli->error;
    exit();
}

// Format
$sql = "SELECT * FROM formats";
$results_formats = $mysqli->query($sql);
if ($results_formats == false) {
    echo $mysqli->error;
    exit();
}

// Sound
$sql = "SELECT * FROM sounds";
$results_sounds = $mysqli->query($sql);
if ($results_sounds == false) {
    echo $mysqli->error;
    exit();
}

// Close DB Connection
$mysqli->close();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Form | Song Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        .form-check-label {
            padding-top: calc(.5rem - 1px * 2);
            padding-bottom: calc(.5rem - 1px * 2);
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Add</li>
    </ol>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4 mb-4">Add a DVD</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->
    <div class="container">

        <form action="add_confirmation.php" method="POST">

            <div class="form-group row">
                <label for="name-id" class="col-sm-3 col-form-label text-sm-right">
                    DVD Name: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="dvd-title-id" name="title">
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="genre-id" class="col-sm-3 col-form-label text-sm-right">
                    Genre: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="genre" id="genre-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php while( $row = $results_genres->fetch_assoc() ): ?>

                            <option value="<?php echo $row['genre_id']; ?>">
                                <?php echo $row['genre']; ?>
                            </option>

                        <?php endwhile; ?>

                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="rating-id" class="col-sm-3 col-form-label text-sm-right">
                    Rating: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="rating" id="rating-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php while( $row = $results_ratings->fetch_assoc() ): ?>

                            <option value="<?php echo $row['rating_id']; ?>">
                                <?php echo $row['rating']; ?>
                            </option>

                        <?php endwhile; ?>
                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="label-id" class="col-sm-3 col-form-label text-sm-right">
                    Label: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="label" id="label-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php while( $row = $results_labels->fetch_assoc() ): ?>

                            <option value="<?php echo $row['label_id']; ?>">
                                <?php echo $row['label']; ?>
                            </option>

                        <?php endwhile; ?>
                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="format-id" class="col-sm-3 col-form-label text-sm-right">
                    Format: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="format" id="format-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php while( $row = $results_formats->fetch_assoc() ): ?>

                            <option value="<?php echo $row['format_id']; ?>">
                                <?php echo $row['format']; ?>
                            </option>

                        <?php endwhile; ?>
                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="sound-id" class="col-sm-3 col-form-label text-sm-right">
                    Sound: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <select name="sound" id="sound-id" class="form-control">
                        <option value="" selected disabled>-- Select One --</option>

                        <?php while( $row = $results_sounds->fetch_assoc() ): ?>

                            <option value="<?php echo $row['sound_id']; ?>">
                                <?php echo $row['sound']; ?>
                            </option>

                        <?php endwhile; ?>
                    </select>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="award-id" class="col-sm-3 col-form-label text-sm-right">
                    Award: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="text" name="award" min="0" id="award-id" class="form-control">
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <label for="date-id" class="col-sm-3 col-form-label text-sm-right">
                    Release Date: <span class="text-danger">*</span>
                </label>
                <div class="col-sm-9">
                    <input type="date" name="date" id="date-id" class="form-control">
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <div class="ml-auto col-sm-9">
                    <span class="text-danger font-italic">* Required</span>
                </div>
            </div> <!-- .form-group -->

            <div class="form-group row">
                <div class="col-sm-3"></div>
                <div class="col-sm-9 mt-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-light">Reset</button>
                </div>
            </div> <!-- .form-group -->
        </form>
    </div> <!-- .container -->
</body>
</html>