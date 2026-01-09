Site for booking hotel rooms.

## Code Review
----------------

File structure:
Your DS_Store and .env files are visible on github. It’s good for security to keep these file in a .gitignore file.

File structure:
All your files are in the root. Divide into files (app, views, assets) etc. only index.php and dot files should be in root.

index.php 52-182:
Instead of hardcoding each calendar try looping, which cuts down the rows to 1/3.

Index.php:
Divide content in to different files for readability and file sorting. Ex array line 7-30 -> arrays.php and required into index.php.
Calendar line 52-181 -> calendar.php

Html:
Instead of only div, try using section to divide the larger parts of the code. 
Wrap the form on line 184-213 in a <form> element and or div to increase readability.


save_booking.php 20-25:
To increase your security -  use htmlspecialchars and trim when handling html input. Ex $username     = $data["username"]; -> htmlspecialchars(trim($username)). This way no unwanted script etc can be inserted.

Api:
Instead of handling the api and most backend in js though fetch (‘’), try using guzzle and php for easier handling and visibility.

