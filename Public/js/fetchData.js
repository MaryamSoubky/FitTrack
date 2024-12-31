// fetchData.js

// Function to fetch all data from the backend
async function fetchData() {
    try {
        const response = await fetch('../Controller/ReportsController.php?action=fetchAll');
        const data = await response.json();

        // Display the workouts
        displayWorkouts(data.workouts);

        // Display the goals
        displayGoals(data.goals);
    } catch (error) {
        console.error("Error fetching data:", error);
        document.getElementById("workouts-section").innerHTML = "<p style='color:red;'>Failed to load workouts.</p>";
        document.getElementById("goals-section").innerHTML = "<p style='color:red;'>Failed to load goals.</p>";
    }
}

// Function to display workouts
function displayWorkouts(workouts) {
    const section = document.getElementById("workouts-section");

    if (workouts.length === 0) {
        section.innerHTML = "<p>No workouts found.</p>";
        return;
    }

    let html = `
        <table>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Exercise Type</th>
                    <th>Duration (minutes)</th>
                    <th>Intensity</th>
                    <th>Frequency</th>
                    <th>Log Date</th>
                </tr>
            </thead>
            <tbody>
    `;

    workouts.forEach(workout => {
        html += `
            <tr>
                <td>${workout.user_name}</td>
                <td>${workout.exercise_type}</td>
                <td>${workout.duration}</td>
                <td>${workout.intensity}</td>
                <td>${workout.frequency}</td>
                <td>${workout.log_date}</td>
            </tr>
        `;
    });

    html += "</tbody></table>";
    section.innerHTML = html;
}

// Function to display goals
function displayGoals(goals) {
    const section = document.getElementById("goals-section");

    if (goals.length === 0) {
        section.innerHTML = "<p>No goals found.</p>";
        return;
    }

    let html = `
        <table>
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Goal Type</th>
                    <th>Target Value</th>
                    <th>Current Value</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
    `;

    goals.forEach(goal => {
        html += `
            <tr>
                <td>${goal.user_name}</td>
                <td>${goal.goal_type}</td>
                <td>${goal.target_value}</td>
                <td>${goal.current_value}</td>
                <td>${goal.start_date}</td>
                <td>${goal.end_date}</td>
                <td>${goal.status}</td>
            </tr>
        `;
    });

    html += "</tbody></table>";
    section.innerHTML = html;
}

// Fetch and display data on page load
document.addEventListener("DOMContentLoaded", fetchData);
