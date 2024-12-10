<?php

// Include the constants.php file
include '../assets/utils/constants.php';  //$servername, $username, $password, $dbname

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Create the 'outcomes' table if it does not exist, including 'course_code' field
$tableCreationQuery = "
    CREATE TABLE IF NOT EXISTS outcomes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        outcome_text TEXT NOT NULL,
        course_code VARCHAR(100) NOT NULL  -- New column for course code
    );
";

if (!mysqli_query($conn, $tableCreationQuery)) {
    die("Error creating table: " . mysqli_error($conn));
}

// Helper function to send JSON responses
function sendResponse($data = [], $statusCode = 200, $message = '') {
    header("Content-Type: application/json");
    http_response_code($statusCode);
    echo json_encode(['message' => $message, 'data' => $data]);
    exit;
}

// Function to fetch outcomes by course_code
function fetchOutcomesByCourse($course_code) {
    global $conn;
    $query = "SELECT * FROM outcomes WHERE course_code = '$course_code'";
    $result = mysqli_query($conn, $query);

    $outcomes = [];
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $outcomes[] = $row;
        }
    }
    return ['outcomes' => $outcomes];
}

// Handle incoming requests based on HTTP method
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($requestMethod) {
    case 'GET':
        // Fetch the list of outcomes by course_code
        $course_code = isset($_GET['course_code']) ? $_GET['course_code'] : null;

        if ($course_code) {
            $outcomes = fetchOutcomesByCourse($course_code);
            sendResponse($outcomes, 200, 'Outcomes fetched successfully');
        } else {
            sendResponse([], 400, 'Course code is required');
        }
        break;

    case 'POST':
        // Add a new outcome
        $inputData = json_decode(file_get_contents("php://input"), true);

        if (!isset($inputData['outcome_text'], $inputData['course_code']) ||
            empty($inputData['outcome_text']) || empty($inputData['course_code'])) {
            sendResponse([], 400, 'Invalid or missing input fields');
        }

        // Escape special characters in outcome_text and course_code
        $outcome_text = mysqli_real_escape_string($conn, $inputData['outcome_text']);
        $course_code = mysqli_real_escape_string($conn, $inputData['course_code']);

        $query = "INSERT INTO outcomes (outcome_text, course_code) VALUES ('$outcome_text', '$course_code')";
        if (mysqli_query($conn, $query)) {
            $outcomes = fetchOutcomesByCourse($course_code);
            sendResponse($outcomes, 201, 'Outcome added successfully');
        } else {
            sendResponse([], 500, 'Failed to add outcome');
        }
        break;

    case 'PUT':
        // Update an outcome
        $inputData = json_decode(file_get_contents("php://input"), true);

        if (!isset($inputData['id'], $inputData['outcome_text'], $inputData['course_code']) ||
            empty($inputData['outcome_text']) || empty($inputData['course_code'])) {
            sendResponse([], 400, 'Invalid or missing input fields');
        }

        $id = (int)$inputData['id'];
        $outcome_text = mysqli_real_escape_string($conn, $inputData['outcome_text']);
        $course_code = mysqli_real_escape_string($conn, $inputData['course_code']);

        $query = "UPDATE outcomes SET outcome_text = '$outcome_text', course_code = '$course_code' WHERE id = $id";
        if (mysqli_query($conn, $query)) {
            $outcomes = fetchOutcomesByCourse($course_code);
            sendResponse($outcomes, 200, 'Outcome updated successfully');
        } else {
            sendResponse([], 500, 'Failed to update outcome');
        }
        break;

    case 'DELETE':
        // Delete an outcome
        $inputData = json_decode(file_get_contents("php://input"), true);

        if (!isset($inputData['id']) || !is_numeric($inputData['id'])) {
            sendResponse([], 400, 'Invalid or missing input fields');
        }

        $id = (int)$inputData['id'];

        // Fetch course_code before deleting for consistent responses
        $courseQuery = "SELECT course_code FROM outcomes WHERE id = $id";
        $courseResult = mysqli_query($conn, $courseQuery);
        $courseRow = mysqli_fetch_assoc($courseResult);
        $course_code = $courseRow['course_code'] ?? null;

        $query = "DELETE FROM outcomes WHERE id = $id";
        if (mysqli_query($conn, $query) && $course_code) {
            $outcomes = fetchOutcomesByCourse($course_code);
            sendResponse($outcomes, 200, 'Outcome deleted successfully');
        } else {
            sendResponse([], 500, 'Failed to delete outcome');
        }
        break;

    default:
        sendResponse([], 405, 'Method not allowed');
}
?>
