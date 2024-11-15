document.addEventListener("DOMContentLoaded", function () {
    const boxes = document.querySelectorAll(".box table");

    boxes.forEach(function (box) {
        const rows = box.querySelectorAll("tr");
        let currentRow = 0;

        setInterval(function () {
            rows[currentRow].style.display = "none"; // Hide the current row

            currentRow = (currentRow + 1) % rows.length; // Move to the next row

            rows[currentRow].style.display = "table-row"; // Show the next row
        }, 2000); // Adjust the interval as needed (2000ms = 2 seconds)
    });
});
