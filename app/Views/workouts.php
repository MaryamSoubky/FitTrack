<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Workout Logger</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../Public/css/style_workout.css">
    <style>
        /* Enhanced Styles for Modern Look */
        body {
            font-family: Arial, sans-serif;
        }
        
        .card {
            padding: 1.5rem;
            margin-top: 1.5rem;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
        }

        .card:hover {
            transform: scale(1.03);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        }

        .workout-grid {
            display: grid;
            gap: 2rem;
            grid-template-columns: 1fr;
        }

        /* Circular Progress Bar Styling */
        .circular-progress {
            width: 100px;
            height: 100px;
            position: relative;
            text-align: center;
            margin: auto;
        }

        .circular-progress svg {
            position: absolute;
            top: 0;
            left: 0;
            transform: rotate(-90deg);
        }

        .circular-progress circle {
            fill: none;
            stroke-width: 8;
            stroke-linecap: round;
        }

        .circular-bg {
            stroke: #f0f0f0;
        }

        .circular-fg {
            stroke: #4caf50;
            transition: stroke-dashoffset 0.35s;
        }

        .progress-percent {
            font-size: 1.2rem;
            font-weight: bold;
            color: #4caf50;
            position: relative;
            top: 30%;
        }

        /* Photo Gallery Styling */
        .photo-gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 1.2rem;
            margin-top: 1.5rem;
        }

        .photo-gallery img {
            width: 100%;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .photo-gallery img:hover {
            transform: scale(1.05);
        }

        .photo-caption {
            text-align: center;
            font-size: 0.9rem;
            color: #333;
            margin-top: 0.5rem;
        }

        /* Modal for Enlarged Photo View */
        .modal {
            display: none;
            position: fixed;
            z-index: 10;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 1.5rem;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
            text-align: center;
        }

        .modal img {
            width: 100%;
            border-radius: 8px;
        }

        .close-btn {
            cursor: pointer;
            color: #f0f0f0;
            background-color: #333;
            padding: 0.5rem 1rem;
            margin-top: 1rem;
            border-radius: 8px;
        }

        /* Responsive Design for Larger Screens */
        @media (min-width: 768px) {
            .workout-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>

<body>
<?php include 'Partials/navbar.php';?>


    <!-- Motivational Message Section -->
    <section class="quote-section">
        <p id="motivational-quote">"Push yourself, because no one else is going to do it for you."</p>
    </section>

    <!-- Main Content Area -->
    <main class="container">
        <div class="workout-grid">
            <!-- Workout Log Form -->
            <section class="card">
                <hgroup>
                    <h2>Log Your Workout</h2>
                    <h3>Track your performance</h3>
                </hgroup>
                <?php
// Check if the 'message' parameter is set in the URL query string
if (isset($_GET['message'])) {
    $message = $_GET['message'];
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>

<form action="../Controller/workout_controller.php" method="POST">
    <label for="exercise">Exercise Type:</label>
    <input type="text" id="exercise" name="exercise" placeholder="e.g., Running" required>

    <label for="duration">Duration (minutes):</label>
    <input type="number" id="duration" name="duration" placeholder="e.g., 60" required>

    <label for="intensity">Intensity (1-10):</label>
    <input type="number" id="intensity" name="intensity" min="1" max="10" required>

    <label for="frequency">Frequency (per week):</label>
    <input type="number" id="frequency" name="frequency" min="1" max="7" required>

    <label for="notes">Additional Notes:</label>
    <textarea id="notes" name="notes" rows="4" placeholder="How did the workout feel?"></textarea>

    <button type="submit" class="button-primary">Submit Workout</button>
</form>




                <p id="confirmation-message" style="display:none; color: green;">Workout logged successfully!</p>
            </section>

            <!-- Exercise Photo Gallery Section -->
            <section class="card">
                <h2>Exercise Gallery</h2>
                <div class="photo-gallery">
                    <figure>
                        <img src="../Public/images/workout/cardio-class.jpg" alt="Exercise 1" onclick="openModal('exercise1.jpg')">
                        <figcaption class="photo-caption">Running</figcaption>
                    </figure>
                    <figure>
                    <img src="../Public/images/workout/cycling.webp" alt="Exercise 2" onclick="openModal('../Public/images/workout/exercise2.jpg')">
                    <figcaption class="photo-caption">Cycling</figcaption>
                    </figure>
                    <figure>
                        <img src="../Public/images/workout/yoga-class.jpg" alt="Exercise 3" onclick="openModal('exercise3.jpg')">
                        <figcaption class="photo-caption">Yoga</figcaption>
                    </figure>
                </div>
            </section>

            <!-- Progress Section with Circular Progress -->
            <section class="card">
                <h2>Weekly Goal Progress</h2>
                <div class="circular-progress">
                    <svg>
                        <circle class="circular-bg" cx="50" cy="50" r="40"></circle>
                        <circle class="circular-fg" cx="50" cy="50" r="40"></circle>
                    </svg>
                    <div class="progress-percent" id="progress-percent">0%</div>
                </div>
            </section>
        </div>
    </main>

    <!-- Modal for Enlarged Photo View -->
    <div id="photo-modal" class="modal">
        <div class="modal-content">
            <img id="modal-image" src="" alt="Enlarged Exercise Photo">
            <button class="close-btn" onclick="closeModal()">Close</button>
        </div>
    </div>

    <!-- JavaScript for Interactive Features -->
    <script>
        // JavaScript for motivational quotes rotation
        const quotes = [
            "Push yourself, because no one else is going to do it for you.",
            "Success starts with self-discipline.",
            "The pain you feel today will be the strength you feel tomorrow.",
            "Strive for progress, not perfection."
        ];

        function updateQuote() {
            const randomIndex = Math.floor(Math.random() * quotes.length);
            document.getElementById('motivational-quote').innerText = quotes[randomIndex];
        }
        
        setInterval(updateQuote, 5000); // Rotate quotes every 5 seconds

        // Confirmation message on form submission
        function showConfirmation(event) {
    event.preventDefault();
    document.getElementById("confirmation-message").style.display = "block";
    setTimeout(() => {
        document.getElementById("confirmation-message").style.display = "none";
    }, 3000);
}

        // Circular progress animation
        function setProgress(percent) {
            const circumference = 2 * Math.PI * 40;
            const offset = circumference - (percent / 100) * circumference;
            document.querySelector(".circular-fg").style.strokeDasharray = circumference;
            document.querySelector(".circular-fg").style.strokeDashoffset = offset;
        }

        // Modal Functions for Enlarged Photo View
        function openModal(imageSrc) {
            document.getElementById('modal-image').src = imageSrc;
            document.getElementById('photo-modal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('photo-modal').style.display = 'none';
        }
    </script>
</body>

</html>