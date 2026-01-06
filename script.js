const roomClasses = document.querySelectorAll('.roomClass');

roomClasses.forEach(room => {
    room.addEventListener('click', () => {
        const isAlreadySelected = room.classList.contains('clicked');

        // Remove selection from all
        roomClasses.forEach(r => r.classList.remove('clicked'));

        // If it wasn't selected before, select it
        if (!isAlreadySelected) {
            room.classList.add('clicked');
        }
        // else: clicking the same one leaves none selected
    });
});

function updateDay(inputDate, outputNumber) {
    const input = document.getElementById(inputDate);
    const output = document.getElementById(outputNumber);

    input.addEventListener("input", () => {
        const value = input.value; // "YYYY-MM-DD"
        if (value) {
            const day = parseInt(value.split("-")[2], 10);
            output.textContent = day;
        } else {
            output.textContent = "--"; // no date selected
        }
        highlightRange(); // call after updating
    });
}


// Attach event listeners to both inputs
updateDay("fromDate", "fromInt");
updateDay("toDate", "toInt");

function highlightRange() {
    const fromDayText = document.getElementById('fromInt').textContent;
    const toDayText = document.getElementById('toInt').textContent;

    const fromDay = parseInt(fromDayText, 10);
    const toDay = parseInt(toDayText, 10);

    const dates = document.querySelectorAll('.date');

    dates.forEach(dateDiv => {
        const day = parseInt(dateDiv.textContent, 10);

        // Reset color first
        dateDiv.style.border = 'none';

        if (isNaN(day)) return; // skip invalid divs

        if (!isNaN(fromDay) && !isNaN(toDay)) {
            // Both dates selected → highlight range
            if (day >= fromDay && day <= toDay) {
                dateDiv.style.border = '3px solid goldenrod';
            }
        } else if (!isNaN(fromDay)) {
            // Only fromDay selected → highlight that day
            if (day === fromDay) dateDiv.style.border = '3px solid goldenrod';
        } else if (!isNaN(toDay)) {
            // Only toDay selected → highlight that day
            if (day === toDay) dateDiv.style.border = '3px solid goldenrod';
        }
    });
}
