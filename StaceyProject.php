<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tac+One&display=swap" rel="stylesheet">
    <title>Your Exercise Tracker</title>
    <style>
        body {
            font-family: ;
            margin: 0;
            padding: 0;
            background-image: url('workout.jpg'); 
            background-size: cover;
            background-position: center;
            color: #333;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: lightpink; /* Pink background */
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="submit"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #f05544;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #e0443b;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        li {
            margin-bottom: 5px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .tac-one-regular {
        font-family: "Tac One", sans-serif;
        font-weight: 400;
        font-style: normal;
}



        @media (max-width: 600px) {
            .container {
                padding: 10px;
            }

            input[type="text"],
            input[type="number"],
            input[type="submit"] {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Exercise Tracker</h2>

    <?php
    // Function to save exercise data to a text file
    function saveExercise($exercise, $duration) {
        $file = fopen("exercises.txt", "a") or die("Unable to open file!");
        $exerciseData = $exercise . ": " . $duration . " minutes\n";
        fwrite($file, $exerciseData);
        fclose($file);
    }

    // Function to display recent exercises from the text file
    function displayExercises() {
        $exercisesFile = "exercises.txt";
        if (file_exists($exercisesFile)) {
            $recentExercises = file($exercisesFile);
            echo "<ul>";
            foreach ($recentExercises as $exerciseData) {
                echo "<li>" . $exerciseData . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No exercises logged yet.</p>";
        }
    }

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Validate and sanitize input
        $exercise = htmlspecialchars($_POST["exercise"]);
        $duration = htmlspecialchars($_POST["duration"]);

        // Check if exercise and duration are not empty
        if (!empty($exercise) && !empty($duration)) {
            // Check if duration is a valid number
            if (is_numeric($duration) && $duration > 0) {
                // Save exercise data
                saveExercise($exercise, $duration);
                echo "<p>Exercise logged successfully!</p>";
            } else {
                echo "<p>Duration must be a positive number.</p>";
            }
        } else {
            echo "<p>Please fill in all fields.</p>";
        }
    }
    ?>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <label for="exercise">Exercise:</label>
        <input type="text" id="exercise" name="exercise" required>
        <label for="duration">Duration (minutes):</label>
        <input type="number" id="duration" name="duration" min="1" required>
        <input type="submit" value="Log Exercise">
    </form>

    <hr>

    <h3>Recent Exercises:</h3>

    <?php
    // Display recent exercises
    displayExercises();
    ?>

</div>

</body>
</html>
