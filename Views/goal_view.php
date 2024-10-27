<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Goal Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <link rel="stylesheet" href="../Public/css/style_goals.css">
    <style>
        /* General Styling */
        body {
            background: linear-gradient(135deg, #f3f7f9, #e0e8ec);
            color: #333;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .goal-setting-card {
            background: #fff;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            max-width: 450px;
            width: 100%;
            text-align: center;
        }

        h2, h3 {
            color: #4a90e2;
        }

        form label {
            font-weight: bold;
            margin-top: 1rem;
            display: inline-block;
            text-align: left;
        }

        select, input[type="number"], input[type="date"] {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
        }

        .button-primary {
            background-color: #4a90e2;
            color: #fff;
            font-weight: bold;
            margin-top: 1.5rem;
            width: 100%;
            padding: 0.8rem;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .button-primary:hover {
            background-color: #357abf;
        }

        /* Circular Progress Bar */
        .progress-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            height: 120px;
            width: 120px;
        }

        .progress-circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            clip: rect(0px, 120px, 120px, 60px);
            transform: rotate(-90deg);
        }

        .progress-bar {
            border-radius: 50%;
            clip: rect(0px, 60px, 120px, 0px);
            background-color: #4a90e2;
            position: absolute;
            width: 100%;
            height: 100%;
            animation: progress 2s ease-out forwards; /* Keep it to show complete progress */
        }

        @keyframes progress {
            0% { transform: rotate(0); }
            100% { transform: rotate(216deg); /* Adjust based on actual progress */ }
        }

        .progress-text {
            position: absolute;
            font-weight: bold;
            font-size: 1.2rem;
            color: #333;
        }

        /* Tooltip Styling */
        .tooltip {
            display: inline-block;
            position: relative;
            cursor: pointer;
        }

        .tooltip .tooltip-text {
            visibility: hidden;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 5px;
            padding: 5px 10px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltip-text {
            visibility: visible;
            opacity: 1;
        }

        /* Motivational Quote Styling */
        .motivational-quote {
            margin-top: 20px;
            font-style: italic;
            color: #555;
        }

    </style>
</head>
<body>
    <?php include 'Partials/navbar.php';?>
    <main class="container">
        <section class="goal-setting-card">
            <hgroup>
                <h2>Set Your Fitness Goal</h2>
                <h3>Stay motivated and track your progress</h3>
            </hgroup>
            <form action="../goalHandler.php" method="POST">
                <label for="goalType">Goal Type:</label>
                <select id="goalType" name="goalType" required>
                    <option value="weightLoss">Weight Loss</option>
                    <option value="strengthGain">Strength Gain</option>
                    <option value="endurance">Endurance</option>
                </select>

                <label for="targetValue" class="tooltip">
                    Target Value:
                    <span class="tooltip-text">Example: 5kg for Weight Loss</span>
                </label>
                <input type="number" id="targetValue" name="targetValue" placeholder="e.g., 10" required>

                <label for="deadline" class="tooltip">
                    Deadline:
                    <span class="tooltip-text">Select a realistic deadline</span>
                </label>
                <input type="date" id="deadline" name="deadline" required>

                <button type="submit" class="button-primary">Set Goal</button>
            </form>

            <div class="progress-container">
                <div class="progress-circle">
                    <div class="progress-bar"></div>
                </div>
                <div class="progress-text">60%</div> <!-- Adjust dynamically based on progress -->
            </div>

            <p class="motivational-quote">"Every workout is progress!"</p>
            <p id="confirmation-message" style="display:none; color: green;">Goal successfully set!</p>
        </section>  
    </main>
    <?php include 'Partials/footer.php';?>
    <script src="../public/js/goal.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            const confirmationMessage = document.getElementById("confirmation-message");

            form.addEventListener("submit", function(event) {
                event.preventDefault();
                setTimeout(() => {
                    confirmationMessage.style.display = "block";
                    form.reset();
                    setTimeout(() => confirmationMessage.style.display = "none", 3000);
                }, 300);
            });
        });
    </script>
</body>
</html>
