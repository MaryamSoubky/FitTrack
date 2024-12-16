// Performance Analytics Chart (Chart.js)
const ctx = document.getElementById('performanceChart').getContext('2d');
const performanceChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [{
            label: 'Calories Burned',
            data: [500, 700, 800, 600, 750, 900, 1000],
            backgroundColor: 'rgba(0, 123, 255, 0.2)',
            borderColor: '#007BFF',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
});

// Reminder Logic
const reminderForm = document.getElementById('reminderForm');
const reminderList = document.getElementById('reminderList');

// Handle form submission for reminders
reminderForm.addEventListener('submit', function(event) {
    event.preventDefault();

    const reminderText = document.getElementById('reminderText').value;
    const reminderDate = document.getElementById('reminderDate').value;

    if (reminderText && reminderDate) {
        // Create new reminder list item
        const newReminder = document.createElement('li');
        newReminder.textContent = `${reminderText} - ${new Date(reminderDate).toLocaleString()}`;
        reminderList.appendChild(newReminder);

        // Clear the form
        reminderForm.reset();
    }
});

// Social Sharing Logic
const shareButton = document.querySelector('.btn-share');
const shareFallback = document.getElementById('shareFallback');
const socialLinks = document.getElementById('socialLinks');

shareButton.addEventListener('click', function() {
    const shareData = {
        title: 'My Fitness Progress',
        text: 'Check out my fitness progress for this week!',
        url: window.location.href
    };

    if (navigator.share) {
        navigator.share(shareData)
            .then(() => console.log('Content shared successfully!'))
            .catch((error) => console.log('Error sharing content:', error));
    } else {
        // If the Web Share API is not supported, show fallback
        shareFallback.style.display = 'block';
        socialLinks.style.display = 'block';
    }
});
