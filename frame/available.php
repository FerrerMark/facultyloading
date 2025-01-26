<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Availability</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
        }
        form {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
        }
        .day-section {
            margin-bottom: 20px;
        }
        .time-slot {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Instructor Availability Form</h1>
    <form id="availabilityForm">
        <div id="daysContainer"></div>
        <button type="submit">Submit Availability</button>
    </form>

    <script>
        const days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        const daysContainer = document.getElementById('daysContainer');

        days.forEach(day => {
            const daySection = document.createElement('div');
            daySection.className = 'day-section';
            daySection.innerHTML = `
                <h3>${day}</h3>
                <div id="${day.toLowerCase()}-slots"></div>
                <button type="button" onclick="addTimeSlot('${day.toLowerCase()}')">Add Time Slot</button>
            `;
            daysContainer.appendChild(daySection);
        });

        function addTimeSlot(day) {
            const slotsContainer = document.getElementById(`${day}-slots`);
            const newSlot = document.createElement('div');
            newSlot.className = 'time-slot';
            newSlot.innerHTML = `
                <input type="time" name="${day}_start[]" required>
                <input type="time" name="${day}_end[]" required>
                <button type="button" onclick="removeTimeSlot(this)">Remove</button>
            `;
            slotsContainer.appendChild(newSlot);
        }

        function removeTimeSlot(button) {
            button.parentElement.remove();
        }

        document.getElementById('availabilityForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const availability = {};

            days.forEach(day => {
                const lowercaseDay = day.toLowerCase();
                const startTimes = formData.getAll(`${lowercaseDay}_start[]`);
                const endTimes = formData.getAll(`${lowercaseDay}_end[]`);
                availability[day] = startTimes.map((start, index) => ({
                    start: start,
                    end: endTimes[index]
                }));
            });

            console.log('Availability Data:', JSON.stringify(availability, null, 2));
            alert('Availability submitted successfully!');
        });
    </script>
</body>
</html>

