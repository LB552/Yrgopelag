<!DOCTYPE html>
<html lang="en">

<head>
    <!--DRY?-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Booking</title>
</head>
<header>
    <a class="logo">Revered</a>
    <div class="stars">*star count*</div>
</header>

<body>
    <div class="hori">
        <div id="economyCalendar" class="dateWall">
            <h3>Economy</h3>
            <?php
            $day = 1;
            for ($i = 0; $i < 6; $i++) { ?>
                <div class="hori">
                    <?php for ($j = 0; $j < 7; $j++) {

                        $class = 'date';
                        $content = '';

                        // Days (mon-sun)
                        if ($i === 0) {
                            $class = 'dayDate';
                        }

                        // First 3 squares on top row
                        if ($i === 1 && $j < 3) {
                            $class = 'dullDate';
                        }

                        // Last square on bottom row
                        if ($i === 5 && $j === 6) {
                            $class = 'dullDate';
                        }

                        // Put day number only on valid dates
                        if ($class === 'date' && $day <= 31) {
                            $content = $day;
                            $day++;
                        }

                        // Put days (mon-sun)
                        $weekday = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        if ($class === 'dayDate' && $i === 0) {
                            $content = $weekday[$j];
                        }
                    ?>
                        <div class="<?= $class ?>"><?= $content ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div id="standardCalendar" class="dateWall">
            <h3>Standard</h3>
            <?php
            $day = 1;
            for ($i = 0; $i < 6; $i++) { ?>
                <div class="hori">
                    <?php for ($j = 0; $j < 7; $j++) {

                        $class = 'date';
                        $content = '';

                        // Days (mon-sun)
                        if ($i === 0) {
                            $class = 'dayDate';
                        }

                        // First 3 squares on top row
                        if ($i === 1 && $j < 3) {
                            $class = 'dullDate';
                        }

                        // Last square on bottom row
                        if ($i === 5 && $j === 6) {
                            $class = 'dullDate';
                        }

                        // Put day number only on valid dates
                        if ($class === 'date' && $day <= 31) {
                            $content = $day;
                            $day++;
                        }

                        // Put days (mon-sun)
                        $weekday = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        if ($class === 'dayDate' && $i === 0) {
                            $content = $weekday[$j];
                        }
                    ?>
                        <div class="<?= $class ?>"><?= $content ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
        <div id="luxuryCalendar" class="dateWall">
            <h3>Luxury</h3>
            <?php
            $day = 1;
            for ($i = 0; $i < 6; $i++) { ?>
                <div class="hori">
                    <?php for ($j = 0; $j < 7; $j++) {

                        $class = 'date';
                        $content = '';

                        // Days (mon-sun)
                        if ($i === 0) {
                            $class = 'dayDate';
                        }

                        // First 3 squares on top row
                        if ($i === 1 && $j < 3) {
                            $class = 'dullDate';
                        }

                        // Last square on bottom row
                        if ($i === 5 && $j === 6) {
                            $class = 'dullDate';
                        }

                        // Put day number only on valid dates
                        if ($class === 'date' && $day <= 31) {
                            $content = $day;
                            $day++;
                        }

                        // Put days (mon-sun)
                        $weekday = ['mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun'];
                        if ($class === 'dayDate' && $i === 0) {
                            $content = $weekday[$j];
                        }
                    ?>
                        <div class="<?= $class ?>"><?= $content ?></div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>

    <label for="roomSelect">Select room/class:</label>
    <select name="room" id="roomSelect">
        <option value="1">economy</option>
        <option value="2">standard</option>
        <option value="3">luxury</option>
    </select>

    <label>From:</label>
    <input type="date" id="fromDate" min="2026-01-01" max="2026-01-31">
    <label>To:</label>
    <input type="date" id="toDate" min="2026-01-01" max="2026-01-31">
    <p>From day: <span id="fromInt">--</span></p>
    <p>To day: <span id="toInt">--</span></p>

    <p>Features:</p>
    <div class="hori">
        <input type="checkbox" id="yahtzee">
        <label for="yahtzee">Yahtzee (2 credits)</label>
    </div>
    <div class="hori">
        <input type="checkbox" id="bicycle">
        <label for="bicycle">Bicycle (3 credits)</label>
    </div>
    <p>Special offer: Buy both Yahtzee and bicycle for 4 credits (save 1 credit)</p>

    <p>Your price: <span id="price">--</span> credits</p>

    <input class="usernameInput" placeholder="Username"></input>
    <input class="tranferCodeInput" placeholder="transferCode"></input>
    <button class="submitBooking">Submit</button>

    <script src="script.js"></script>
</body>

</html>