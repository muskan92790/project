<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quizify - A Question Maker Application</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Navbar Section -->
    <header class="navbar" id="my-nav">
        <div class="navbar-logo">
            <h2 id="nav-name">Quizify</h2>
        </div>
        <div class="navbar-select">
            <select name="profile_type" onchange="redirectToProgramPage(this.value)">
                <option value="">Select Program</option>
                <option value="BCA" <?php echo (isset($_GET['program']) && $_GET['program'] == 'BCA') ? 'selected' : ''; ?>>BCA</option>
                <option value="MCA" <?php echo (isset($_GET['program']) && $_GET['program'] == 'MCA') ? 'selected' : ''; ?>>MCA</option>
                <option value="M.Tech" <?php echo (isset($_GET['program']) && $_GET['program'] == 'M.Tech') ? 'selected' : ''; ?>>M.Tech</option>
                <option value="B.Tech" <?php echo (isset($_GET['program']) && $_GET['program'] == 'B.Tech') ? 'selected' : ''; ?>>B.Tech</option>
            </select>
        </div>
    </header>

    <!-- Main Layout (Sidebar + Content Area) -->
    <div class="main-layout">
        <!-- Sidebar Section -->
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <ul>
                    <li><a href="?page=home&program=<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>"><span class="icon">&#x1F3E0;</span> Home</a></li>
                    <li><a href="?page=dashboard&program=<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>"><span class="icon">&#x1F4C8;</span> Dashboard</a></li>
                    <li><a href="?page=add-courses&program=<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>"><span class="icon">&#x1F4DA;</span> Add Courses</a></li>
                    <li><a href="?page=add-outcomes&program=<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>"><span class="icon">&#x1F91D;</span> Add Outcomes</a></li>
                    <li><a href="?page=add-questions&program=<?php echo isset($_GET['program']) ? $_GET['program'] : ''; ?>"><span class="icon">&#x1F4D6;</span> Add Questions</a></li>
</ul>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="content">
            <div class="content-area">
                <?php
                $page = isset($_GET['page']) ? $_GET['page'] : 'home';
                $allowed_pages = ['dashboard', 'add-courses', 'add-outcomes', 'add-questions','home'];
                if (in_array($page, $allowed_pages)) {
                    include("pages/$page.php");
                } else {
                    echo "<h2>Page not found</h2>";
                }
                ?>
            </div>
        </main>
    </div>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Quizify - Question Setting Software</p>
    </footer>

    <script>
        // Function to redirect to a page with selected program
        function redirectToProgramPage(selectedProgram) {
            if (!selectedProgram) return;
            
            const urlParams = new URLSearchParams(window.location.search);
            const currentPage = urlParams.get('page') || 'home';
            const allowedPages = ['dashboard', 'add-courses', 'add-outcomes', 'add-questions', 'home'];

            if (allowedPages.includes(currentPage)) {
                window.location.href = `?page=${currentPage}&program=${selectedProgram}`;
            } else {
                console.log("Invalid page");
            }
        }
    </script>
</body>
</html>
