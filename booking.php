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
    <div class="dateWall">
        <?php for ($i = 0; $i < 5; $i++) {
        ?>
            <div class="hori">
                <?php for ($j = 0; $j < 7; $j++) {
                ?> <div class="date"></div> <?php
                                        }
                                            ?> </div> <?php
                                                    } ?>
    </div>
    <p>Select room/class:</p>
    <div class="hori">
        <div class="roomClass">Budget</div>
        <div class="roomClass">Standard</div>
        <div class="roomClass">Luxury</div>
    </div>
    <input class="usernameInput" placeholder="Username"></input>
    <input class="tranferCodeInput" placeholder="transferCode"></input>
</body>

</html>