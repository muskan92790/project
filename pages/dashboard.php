<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Question Management</title>
    <link rel="stylesheet" href="assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <!-- Dashboard Header -->
        <header>
            <h2>Dashboard - Question Management</h2>
        </header>

        <!-- Main Layout -->
        <div class="main-layout">
            <!-- Left Section: Inputs -->
            <div class="left-section">
                <!-- Course and Year Selection -->
                <div class="filter-section">
                    <div>
                        <label id="select" for="course">Select Course:</label>
                        <select id="course" name="course">
                            <!-- Dynamic course options will be added here -->
                        </select>
                    </div>

                    <div>
                        <label id="select" for="year">Select Year:</label>
                        <select id="year" name="year">
                            <!-- Dynamic year options will be added here -->
                        </select>
                    </div>
                </div>

                <!-- Question Filters -->
                <form id="filterForm">
                    <label id="select" for="marks">Marks:</label>
                    <select id="marks" name="marks">
                        <!-- dynamically generated options -->
                    </select>

                    <label id="select" for="level">Level:</label>
                    <select id="level" name="level">
                        <option value="">Select Level</option>
                        <option value="L1">L1</option>
                        <option value="L2">L2</option>
                        <option value="L3">L3</option>
                        <option value="L4">L4</option>
                        <option value="L5">L5</option>
                    </select>

                    <label id="select" for="outcome">Outcome:</label>
                    <select id="outcome" name="outcome">
                        <!-- dynamically generated options -->
                    </select>

                    <button type="button" id="filterBtn">Filter Questions</button>
                </form>
            </div>

            <!-- Right Section: Report -->
            <div class="right-section">
                <!-- Filtered Questions -->
                <div class="question-list">
                    <h3 id="qs">Available Questions</h3>
                    <ul id="filteredQuestions">
                        <!-- Filtered questions will appear here -->
                    </ul>
                </div>

                <!-- Added Questions -->
                <div class="question-list" id="report">
                    <!-- Report content will appear here -->
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/dashboard.js"></script>
</body>
</html>
