// --- Date handling ---
function updateDay(inputDate, outputNumber) {
    const input = document.getElementById(inputDate);
    const output = document.getElementById(outputNumber);

    input.addEventListener("input", () => {
        const value = input.value; // "YYYY-MM-DD"
        if (value) {
            const day = parseInt(value.split("-")[2], 10);
            output.textContent = day;
        } else {
            output.textContent = "--";
        }
        highlightRange();
        calculatePrice();
    });
}

document.getElementById("yahtzee").addEventListener("change", calculatePrice);
document.getElementById("bicycle").addEventListener("change", calculatePrice);

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

    clearAllDateHighlights();

    const activeCalendar = document.querySelector('.dateWall.calendarBorder');
    if (!activeCalendar) return;

    activeCalendar.querySelectorAll('.date').forEach(dateDiv => {
        const day = parseInt(dateDiv.textContent, 10);
        if (isNaN(day)) return;

        if (!isNaN(fromDay) && !isNaN(toDay) && day >= fromDay && day <= toDay) {
            dateDiv.style.border = '3px solid goldenrod';
        } else if (!isNaN(fromDay) && day === fromDay) {
            dateDiv.style.border = '3px solid goldenrod';
        } else if (!isNaN(toDay) && day === toDay) {
            dateDiv.style.border = '3px solid goldenrod';
        }
    });
}

// --- Calendar room selection ---
const calendar_select = document.getElementById("roomSelect");
const economyCal = document.getElementById("economyCalendar");
const standardCal = document.getElementById("standardCalendar");
const luxuryCal = document.getElementById("luxuryCalendar");

economyCal.classList.add("calendarBorder");
calendar_select.value = "1";

calendar_select.addEventListener("change", function () {
    economyCal.classList.remove("calendarBorder");
    standardCal.classList.remove("calendarBorder");
    luxuryCal.classList.remove("calendarBorder");

    if (this.value === "1") economyCal.classList.add("calendarBorder");
    else if (this.value === "2") standardCal.classList.add("calendarBorder");
    else if (this.value === "3") luxuryCal.classList.add("calendarBorder");

    highlightRange();
    calculatePrice();
});

// --- Price calculation ---
function calculatePrice() {
    const roomValue = document.getElementById("roomSelect").value;
    let roomPrice = 0;
    if (roomValue === "1") roomPrice = 2;
    else if (roomValue === "2") roomPrice = 3;
    else if (roomValue === "3") roomPrice = 4;

    const fromDay = parseInt(document.getElementById("fromInt").textContent, 10);
    const toDay = parseInt(document.getElementById("toInt").textContent, 10);

    let nights = (!isNaN(fromDay) && !isNaN(toDay) && toDay >= fromDay) ? toDay - fromDay : 0;

    const yahtzee = document.getElementById("yahtzee").checked;
    const bicycle = document.getElementById("bicycle").checked;

    let featuresPrice = 0;
    if (yahtzee && bicycle) featuresPrice = 4;
    else if (yahtzee) featuresPrice = 2;
    else if (bicycle) featuresPrice = 3;

    const total = nights > 0 ? roomPrice * nights + featuresPrice : 0;
    document.getElementById("price").textContent = total > 0 ? total : "--";
}

// --- Booking submission ---
const submitButton = document.querySelector(".submitBooking");
submitButton.addEventListener("click", withdrawCredits);

function withdrawCredits() {
    const user = document.getElementById("usernameInput").value.trim();
    const apiKey = document.getElementById("transferCodeInput").value.trim();
    const priceText = document.getElementById("price").textContent;

    if (!user || !apiKey) {
        alert("Username and transfer code are required");
        return;
    }
    if (priceText === "--") {
        alert("Price not calculated");
        return;
    }

    const amount = Number(priceText);

    fetch("https://www.yrgopelag.se/centralbank/withdraw", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user, api_key: apiKey, amount })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }

        document.getElementById("transferCodeInput").value = data.transferCode;
        submitBooking();
    })
    .catch(err => {
        console.error(err);
        alert("Withdraw failed");
    });
}

function submitBooking() {
    const transferCode = document.getElementById("transferCodeInput").value.trim();
    const totalCost = Number(document.getElementById("price").textContent);

    if (!transferCode) {
        alert("Missing transfer code");
        return;
    }

    fetch("https://www.yrgopelag.se/centralbank/transferCode", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ transferCode, totalCost })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "success") {
            depositToHotelOwner();
        } else {
            alert("Booking validation failed");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Transfer failed");
    });
}

function depositToHotelOwner() {
    const hotelOwner = "hotelOwner";
    const transferCode = document.getElementById("transferCodeInput").value.trim();

    if (!transferCode) {
        alert("Missing transfer code");
        return;
    }

    fetch("https://www.yrgopelag.se/centralbank/deposit", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ user: hotelOwner, transferCode })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }

        if (data.status === "success") {
            console.log("Deposit successful:", data);
            alert("Hotel owner paid successfully!");
            recordReceipt(); // ✅ record stay after successful deposit
            
        }
    })
    .catch(err => {
        console.error(err);
        alert("Deposit failed");
    });
}

// --- Record stay for analytics/points ---
function recordReceipt() {
    const hotelOwner = "hotelOwner";
    const ownerApiKey = "ownerApiKey";
    const guestName = document.getElementById("usernameInput").value.trim();

    if (!guestName || guestName === hotelOwner) {
        alert("Invalid guest name");
        return;
    }

    const fromDate = document.getElementById("fromDate").value;
    const toDate = document.getElementById("toDate").value;
    if (!fromDate || !toDate) {
        alert("Select arrival and departure dates");
        return;
    }

    const featuresUsed = [];
    if (document.getElementById("yahtzee").checked) featuresUsed.push({ activity: "games", tier: "economy" });
    if (document.getElementById("bicycle").checked) featuresUsed.push({ activity: "wheels", tier: "basic" });

    const starRating = document.getElementById("stars").textContent.length;

    const payload = {
        user: hotelOwner,
        api_key: ownerApiKey,
        guest_name: guestName,
        arrival_date: fromDate,
        departure_date: toDate,
        features_used: featuresUsed,
        star_rating: starRating
    };

    fetch("https://www.yrgopelag.se/centralbank/receipt", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(payload)
    })
    .then(res => res.json())
    .then(data => {
    if (data.error) {
        alert(data.error);
        return;
    }

    if (data.status === "success") {
        console.log("Receipt recorded:", data);
        alert("Stay recorded successfully! Receipt ID: " + data.receipt_id);

        // ✅ NOW save booking locally
        saveBookingToDatabase();
    }
})

    .catch(err => {
        console.error(err);
        alert("Recording receipt failed");
    });
}

function saveBookingToDatabase() {
    const username = document.getElementById("usernameInput").value.trim();
    const transferCode = document.getElementById("transferCodeInput").value.trim();
    const roomValue = document.getElementById("roomSelect").value;

    // Map room
    let room = "Economy";
    if (roomValue === "2") room = "Standard";
    if (roomValue === "3") room = "Luxury";

    // Map features
    const yahtzee = document.getElementById("yahtzee").checked;
    const bicycle = document.getElementById("bicycle").checked;

    let features = "none";
    if (yahtzee && bicycle) features = "yahtzee + bicycle";
    else if (yahtzee) features = "yahtzee";
    else if (bicycle) features = "bicycle";

    const fromDate = document.getElementById("fromDate").value;
    const toDate = document.getElementById("toDate").value;

    fetch("save_booking.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
            username,
            transferCode,
            room,
            features,
            from_date: fromDate,
            to_date: toDate
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.error) {
            alert("DB error: " + data.error);
        } else {
            console.log("Booking saved to DB");
        }
    })
    .catch(err => {
        console.error(err);
        alert("Failed to save booking");
    });
}
