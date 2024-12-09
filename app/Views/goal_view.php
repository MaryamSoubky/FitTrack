<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Goal Setting & Tracking</title>
  <style>
    /* CSS Styling */
    
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f9;
      padding: 20px;
      margin: 0;
    }

    h1, h2 {
      color: #333;
    }

    .goal-form, .current-goals {
      margin-top: 20px;
    }

    label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }

    input[type="number"], input[type="date"], select {
      width: 100%;
      padding: 8px;
      margin-top: 5px;
      border: 1px solid #ddd;
      border-radius: 4px;
    }

    button[type="submit"] {
      padding: 10px 15px;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 15px;
    }

    button[type="submit"]:hover {
      background-color: #45a049;
    }

    .progress-bar {
      width: 100%;
      background-color: #ddd;
      border-radius: 4px;
      overflow: hidden;
      margin-top: 10px;
    }

    .progress {
      height: 20px;
      background-color: #4CAF50;
      width: 0%;
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

      <label for="targetValue">Target Value:</label>
      <input type="number" id="targetValue" name="targetValue" placeholder="e.g., 5 kg" required>

      <label for="startDate">Start Date:</label>
      <input type="date" id="startDate" name="startDate" required>

      <label for="endDate">End Date:</label>
      <input type="date" id="endDate" name="endDate" required>

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
