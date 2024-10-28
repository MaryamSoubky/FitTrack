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
  
  <!-- Include Navbar -->
  <?php include 'Partials/navbar.php';?>

  <h1></h1>

  <!-- Goal Creation Form -->
  <section class="goal-form">
    <h2>Set a New Goal</h2>
    <form id="goalForm">
      <label for="goalType">Goal Type:</label>
      <select id="goalType" name="goalType" required>
        <option value="weight_loss">Weight Loss</option>
        <option value="strength_gain">Strength Gain</option>
        <option value="endurance">Endurance</option>
      </select>

      <label for="targetValue">Target Value:</label>
      <input type="number" id="targetValue" name="targetValue" placeholder="e.g., 5 kg" required>

      <label for="startDate">Start Date:</label>
      <input type="date" id="startDate" name="startDate" required>

      <label for="endDate">End Date:</label>
      <input type="date" id="endDate" name="endDate" required>

      <button type="submit">Set Goal</button>
    </form>
  </section>

  <!-- Current Goals and Progress Tracker -->
  <section class="current-goals">
    <h2>Current Goals</h2>
    <div class="goal-list" id="goalList">
      <!-- JavaScript will inject goal cards here -->
    </div>
  </section>

  <script>
    // JavaScript to handle form submission and dynamically update goal list

    const goalForm = document.getElementById('goalForm');
    const goalList = document.getElementById('goalList');

    // Sample data for demonstration
    const goals = [
      { type: 'Weight Loss', target: '5 kg', progress: '2 kg', progressPercentage: 40 },
    ];

    function renderGoals() {
      goalList.innerHTML = '';
      goals.forEach(goal => {
        const goalCard = document.createElement('div');
        goalCard.className = 'goal-card';
        goalCard.innerHTML = `
          <h3>${goal.type}</h3>
          <p>Target: ${goal.target}</p>
          <p>Progress: ${goal.progress}</p>
          <div class="progress-bar">
            <div class="progress" style="width: ${goal.progressPercentage}%"></div>
          </div>
        `;
        goalList.appendChild(goalCard);
      });
    }

    goalForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const type = document.getElementById('goalType').value;
      const target = document.getElementById('targetValue').value;
      const newGoal = {
        type: type.charAt(0).toUpperCase() + type.slice(1).replace('_', ' '),
        target: target + (type === 'weight_loss' ? ' kg' : ''),
        progress: '0 kg',
        progressPercentage: 0,
      };
      goals.push(newGoal);
      renderGoals();
      goalForm.reset();
    });

    renderGoals(); // Initial render with sample data
  </script>
</body>
</html>
