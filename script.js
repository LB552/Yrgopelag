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
  });
}

// Attach event listeners to both inputs
updateDay("fromDate", "fromInt");
updateDay("toDate", "toInt");
