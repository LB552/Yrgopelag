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
        <?php for ($i=0; $i<5; $i++) {
            ?> <div class="date"></div>
            <div class="hori">
            <?php for ($j=0; $j<6; $j++) {
                ?> <div class="date"></div> <?php
            }
            ?> </div> <?php
        }?>
    </div>
    <input class="usernameInput" placeholder="Username"></input>
    <input class="tranferCodeInput" placeholder="transferCode"></input>
</body>
</html>