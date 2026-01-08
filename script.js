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

function clearAllDateHighlights() {
    document.querySelectorAll('.date').forEach(dateDiv => {
        dateDiv.style.border = 'none';
    });
}


function highlightRange() {
    const fromDay = parseInt(document.getElementById('fromInt').textContent, 10);
    const toDay = parseInt(document.getElementById('toInt').textContent, 10);

    // Clear highlights everywhere first
    clearAllDateHighlights();

    const activeCalendar = document.querySelector('.dateWall.calendarBorder');
    if (!activeCalendar) return;

    const dates = activeCalendar.querySelectorAll('.date');

    dates.forEach(dateDiv => {
        const day = parseInt(dateDiv.textContent, 10);
        if (isNaN(day)) return;

        if (!isNaN(fromDay) && !isNaN(toDay)) {
            if (day >= fromDay && day <= toDay) {
                dateDiv.style.border = '3px solid goldenrod';
            }
        } else if (!isNaN(fromDay) && day === fromDay) {
            dateDiv.style.border = '3px solid goldenrod';
        } else if (!isNaN(toDay) && day === toDay) {
            dateDiv.style.border = '3px solid goldenrod';
        }
    });
}



const calendar_select = document.getElementById("roomSelect");
const economyCal = document.getElementById("economyCalendar");
const standardCal = document.getElementById("standardCalendar");
const luxuryCal = document.getElementById("luxuryCalendar");

// Default state
economyCal.classList.add("calendarBorder");
calendar_select.value = "1";

calendar_select.addEventListener("change", function () {
    economyCal.classList.remove("calendarBorder");
    standardCal.classList.remove("calendarBorder");
    luxuryCal.classList.remove("calendarBorder");

    if (this.value === "1") {
        economyCal.classList.add("calendarBorder");
    } else if (this.value === "2") {
        standardCal.classList.add("calendarBorder");
    } else if (this.value === "3") {
        luxuryCal.classList.add("calendarBorder");
    }

    highlightRange(); // ← reapply to active calendar
});
