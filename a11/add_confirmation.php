<?php

if ( !isset($_POST['title']) || empty($_POST['title'])
    || !isset($_POST['genre']) || empty($_POST['genre'])
    || !isset($_POST['rating']) || empty($_POST['rating'])
    || !isset($_POST['label']) || empty($_POST['label'])
    || !isset($_POST['format']) || empty($_POST['format'])
    || !isset($_POST['sound']) || empty($_POST['sound'])
    || !isset($_POST['award']) || empty($_POST['award'])
    || !isset($_POST['date']) || empty($_POST['date'])) {

    // Missing required fields.
    $error = "Please fill out all required fields.";

} else {
    // All required fields provided.

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

    if ( isset($_POST['genre']) && !empty($_POST['genre']) ) {
        // User selected album value.
        $genre_id = $_POST['genre'];
    } else {
        // User did not select album value.
        $genre_id = "null";
    }

    if ( isset($_POST['rating']) && !empty($_POST['rating']) ) {
        // User selected bytes value.
        $rating_id = $_POST['rating'];
    } else {
        // User did not select bytes value.
        $rating_id = "null";
    }

    if ( isset($_POST['label']) && !empty($_POST['label']) ) {
        // User selected bytes value.
        $label_id = $_POST['label'];
    } else {
        // User did not select bytes value.
        $label_id = "null";
    }

    if ( isset($_POST['format']) && !empty($_POST['format']) ) {
        // User selected bytes value.
        $format_id = $_POST['format'];
    } else {
        // User did not select bytes value.
        $format_id = "null";
    }

    if ( isset($_POST['sound']) && !empty($_POST['sound']) ) {
        // User selected bytes value.
        $sound_id = $_POST['sound'];
    } else {
        // User did not select bytes value.
        $sound_id = "null";
    }

    if ( isset($_POST['award']) && !empty($_POST['award']) ) {
        // User typed in composer field.
        $award = "'" . $_POST['award'] . "'";
    } else {
        // User did not type in composer field.
        $award = "null";
    }

    if ( isset($_POST['date']) && !empty($_POST['date']) ) {
        // User typed in composer field.
        $award = "'" . $_POST['date'] . "'";
    } else {
        // User did not type in composer field.
        $award = "date";
    }
    echo test;
    $sql = "INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
                    VALUES ('"
                    . $_POST['title']
                    . "', "
                    . $_POST['date']
                    .", "
                    . $_POST['award']
                    .", "
                    . $_POST['label']
                    .", "
                    . $_POST['sound']
                    .", "
                    . $_POST['genre']
                    .", "
                    . $_POST['rating']
                    .", "
                    . $_POST['format']
                    .");";

    $results = $mysqli->query($sql);
    if ( !$results ) {
        echo $mysqli->error;
        exit();
    }

    $mysqli->close();

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add Confirmation | DVD Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
        <li class="breadcrumb-item active">Confirmation</li>
    </ol>
    <div class="container">
        <div class="row">
            <h1 class="col-12 mt-4">Add a DVD</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->
    <div class="container">
        <div class="row mt-4">
            <div class="col-12">

    <?php if ( isset($error) && !empty($error) ) : ?>

        <div class="text-danger">
            <?php echo $error; ?>
        </div>

    <?php else : ?>

        <div class="text-success">
            <span class="font-italic"><?php echo $_POST['title']; ?></span> was successfully added.
        </div>

    <?php endif; ?>

            </div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12">
                <a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
            </div> <!-- .col -->
        </div> <!-- .row -->
    </div> <!-- .container -->
</body>
</html>