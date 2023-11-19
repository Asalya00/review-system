<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "counsellingapp";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $userName = $_POST["userName"];
    $reviewText = $_POST["reviewText"];

    // Insert data into the database
    $sql = "INSERT INTO reviews (userName, reviewText) VALUES ('$userName', '$reviewText')";

    if ($conn->query($sql) === TRUE) {
        echo "Review submitted successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the database connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Star Rating Form</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
</head>
<body>
<div class="container">
    <div class="post">
        <div class="text" id="thankYouMessage">Thanks for rating Us!</div>
        <div class="edit" id="editButton" style="display: none;">EDIT</div>
    </div>
    <div class="star-widget">
        <input type="radio" name="rate" id="rate-5">
        <label for="rate-5" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-4">
        <label for="rate-4" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-3">
        <label for="rate-3" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-2">
        <label for="rate-2" class="fas fa-star"></label>
        <input type="radio" name="rate" id="rate-1">
        <label for="rate-1" class="fas fa-star"></label>

        <form id="reviewForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <header></header>
            <!-- Add input field for user name -->
            <div class="input">
                <label for="userName">Your Name:</label>
                <div class="textarea">
                <textarea id="userName" name="userName" cols="20" placeholder="name" required></textarea></div>
            </div>
            <div class="textarea">
                <textarea id="reviewText" name="reviewText" cols="30" placeholder="Describe your experience" required></textarea>
            </div>
            <div class="btn">
            <button type="submit">Submit</button>
            </div>
        </form>
    </div>

    <!-- Display user name and review -->
    <a href="../user/allDoctors.php">go back</a>
    <div id="userReview" style="display: none;">
        <h2>User Review:</h2>
        <p id="userNameDisplay"></p>
        <p id="userReviewText"></p>
    </div>

    <!-- Display reviews from the database -->
    <div id="reviewsFromDB">
        <?php
        // Database connection parameters
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "counsellingapp";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Fetch reviews from the database
        $sql = "SELECT userName, reviewText FROM reviews";
        $result = $conn->query($sql);

        // Display reviews on the webpage
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div>";
                echo "<h2>User: " . $row["userName"] . "</h2>";
                echo "<p>reviewText: " . $row["reviewText"] . "</p>";
                echo "</div>";
            }
        } else {
            echo "No reviews yet.";
        }

        // Close the database connection
        $conn->close();
        ?>
    </div>
</div>


<script>
    function submitReview() {
        // Get user name and review text
        var userName = document.getElementById("userName").value;
        var reviewText = document.getElementById("reviewText").value;

        // Display user name and review on the page
        document.getElementById("userNameDisplay").innerText = "User Name: " + userName;
        document.getElementById("userReviewText").innerText = "Review: " + reviewText;
        document.getElementById("userReview").style.display = "block";
        document.getElementById("editButton").style.display = "inline";  // Show the "EDIT" button
        document.getElementById("thankYouMessage").style.display = "none"; // Hide the "Thanks for rating Us!" message
    }
</script>
</body>
</html>
