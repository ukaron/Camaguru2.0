<!DOCTYPE HTML PUBLIC «-//W3C//DTD HTML 4.01 Transitional//EN» «http://www.w3.org/TR/html4/loose.dtd»>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" type="text/css" href="/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto+Slab&display=swap" rel="stylesheet">
        <title>CAMAGURU</title>
    </head>
    <body>
        <div class="header">
            <ul id="nav"  style="--items: 3;">
                <li><a href="/main/logout">Logout</a></li>
                <li><a href="/gallery">Pictures</a></li>
                <li><a href="/friends">Friends</a></li>
                <li><a href="/profile">Profile</a></li>
                <li><a href="/main">Start page</a></li>
            </ul>
        </div>
        <?php include 'application/views/'.$content_view; ?>
        <div class="footer">
            <footer></footer>
        </div>
        </html>
    </body>
</html>
