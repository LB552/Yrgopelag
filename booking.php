<?php
require __DIR__ . '/header.html';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!--DRY?-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Booking</title>
</head>

<body>
    <h3>January 2026</h3>
    <div class="dateWall">
        <?php
        $day = 1;
        for ($i = 0; $i < 5; $i++) { ?>
            <div class="hori">
                <?php for ($j = 0; $j < 7; $j++) {

                    $class = 'date';
                    $content = '';

                    // First 3 squares on top row
                    if ($i === 0 && $j < 3) {
                        $class = 'dullDate';
                    }

                    // Last square on bottom row
                    if ($i === 4 && $j === 6) {
                        $class = 'dullDate';
                    }

                    // Put day number only on valid dates
                    if ($class === 'date' && $day <= 31) {
                        $content = $day;
                        $day++;
                    }
                ?>
                    <div class="<?= $class ?>"><?= $content ?></div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <p>Select room/class:</p>
    <div class="hori">
        <div class="roomClass">Budget</div>
        <div class="roomClass">Standard</div>
        <div class="roomClass">Luxury</div>
    </div>

    <label>From:</label>
    <input type="date" id="fromDate" min="2026-01-01" max="2026-01-31">
    <label>To:</label>
    <input type="date" id="toDate" min="2026-01-01" max="2026-01-31">
    <p>From day: <span id="fromInt">--</span></p>
    <p>To day: <span id="toInt">--</span></p>

    <input class="usernameInput" placeholder="Username"></input>
    <input class="tranferCodeInput" placeholder="transferCode"></input>
    <button class="submitBooking">Submit</button>

    <script src="script.js"></script>
</body>

</html>