// Fetch reports from the backend
async function fetchReports() {
    try {
        const response = await fetch('../Controller/reports_controller.php?action=fetch');
        const reports = await response.json();

        const tableBody = document.getElementById('reportsTableBody');
        tableBody.innerHTML = '';

        if (reports.length === 0) {
            tableBody.innerHTML = '<tr><td colspan="5">No reports found.</td></tr>';
            return;
        }

        reports.forEach(report => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${report.report_id}</td>
                <td>${report.user_name}</td>
                <td>${report.report_type}</td>
                <td>${report.details}</td>
                <td>${report.created_at}</td>
            `;
            tableBody.appendChild(row);
        });
    } catch (error) {
        console.error('Error fetching reports:', error);
    }
}

// Generate reports and refresh the table
async function generateReports() {
    try {
        const response = await fetch('../Controller/reports_controller.php?action=generate');
        const result = await response.json();

        if (result.success) {
            alert(result.message);
            fetchReports(); // Refresh the reports
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error('Error generating reports:', error);
    }
}

// Attach event listeners
document.getElementById('generateReportsBtn').addEventListener('click', generateReports);

// Fetch reports on page load
fetchReports();
