function searchTrains() {
    const trainNumber = document.getElementById('trainNumber').value;
    const date = document.getElementById('date').value;
    const route = document.getElementById('route').value;

    // Dummy data for demonstration purposes
    const trainData = [
        { trainNumber: '1001', departure: '06:30 AM', arrival: '09:30 AM', route: 'Colombo - Galle', status: 'On Time' },
        { trainNumber: '1002', departure: '07:00 AM', arrival: '10:00 AM', route: 'Colombo - Kandy', status: 'Delayed' },
        { trainNumber: '1003', departure: '08:00 AM', arrival: '11:00 AM', route: 'Colombo - Jaffna', status: 'On Time' }
    ];

    const results = trainData.filter(train => {
        return (train.trainNumber.includes(trainNumber) || trainNumber === '') &&
               (train.route.toLowerCase().includes(route.toLowerCase()) || route === '') &&
               (date === '' || true); // Assume date matches for simplicity
    });

    displayResults(results);
}

function displayResults(results) {
    const resultsContainer = document.getElementById('resultsContainer');
    resultsContainer.innerHTML = '';

    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No trains found matching your search criteria.</p>';
        return;
    }

    const table = document.createElement('table');
    table.classList.add('schedule-table');

    const thead = document.createElement('thead');
    thead.innerHTML = `
        <tr>
            <th>Train Number</th>
            <th>Departure</th>
            <th>Arrival</th>
            <th>Route</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
    `;
    table.appendChild(thead);

    const tbody = document.createElement('tbody');
    results.forEach(train => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${train.trainNumber}</td>
            <td>${train.departure}</td>
            <td>${train.arrival}</td>
            <td>${train.route}</td>
            <td>${train.status}</td>
            <td><button class="book-button" onclick="redirectToBooking('${train.trainNumber}')">Book Now</button></td>
        `;
        tbody.appendChild(row);
    });

    table.appendChild(tbody);
    resultsContainer.appendChild(table);
}

//pdf download
function downloadPDF() {
    // Get the HTML content of the results container
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    // Add the title
    doc.text("Train Schedule", 10, 10);

    // Add the table content (you need to customize this based on your actual table structure)
    const resultsContainer = document.getElementById("resultsContainer");
    const scheduleHTML = resultsContainer.innerHTML;

    // Convert HTML to plain text (this is basic; for more complex HTML, use a library like `html2canvas`)
    const scheduleText = scheduleHTML.replace(/<[^>]*>/g, ' ');

    // Add the text to the PDF document
    doc.text(scheduleText, 10, 20);

    // Save the PDF with a specific filename
    doc.save("train_schedule.pdf");
}

//to download the pdf  as nice table
function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.text("Train Schedule", 10, 10);

    doc.autoTable({ html: '#resultsContainer table' });

    doc.save("train_schedule.pdf");
}


//redirect the book now button to booking page
function redirectToBooking(trainNumber) {
    // Redirect to booking page with the train number as a URL parameter
    window.location.href = `booking.html?trainNumber=${trainNumber}`;
}
