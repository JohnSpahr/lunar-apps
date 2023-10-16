<?php

$loc = "US";

if( isset( $_GET['loc'] ) ) {
    $loc = $_GET["loc"];
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 2.0//EN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html>
<head>
	<!-- basic page stuff -->
    <title>Choose Edition - Lunar News</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- scripts -->
    <script src="https://kit.fontawesome.com/1d61c49a59.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="spmspn/spmspn.js"></script>

    <!-- favicon and theme stuff -->
    <link rel="apple-touch-icon" href="http://lunarproject.org/images/logo.png" sizes="180x180" />
    <link rel="icon" href="http://lunarproject.org/images/logo.png" sizes="32x32" type="image/png" />
    <link rel="icon" href="http://lunarproject.org/images/logo.png" sizes="16x16" type="image/png" />
    <link rel="icon" href="http://lunarproject.org/images/logo.ico" type="image/ico" />
    <meta name="theme-color" content="#bef17c" />

     <!-- meta stuff -->
     <meta http-equiv="content-type" content="text/html; charset=utf-8" />
     <meta property="og:title" content="Lunar News: BlackBerry News App" />
     <meta property="og:type" content="website" />
     <meta property="og:url" content="http://lunarproject.org/" />
     <meta property="og:image" content="http://lunarproject.org/images/logo.png" />
     <meta property="og:description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="author" content="3 Random Nerds" />
     <meta charset="UTF-8" />
</head>
<body>
    <center><h1><b>Lunar News:</b> <i>The BBOS News App</i></h1></center>
    <hr>
    <center>
    <p><h2>CHOOSE YOUR EDITION:</h2></p>
    <p><a href='index.php?section=nation&loc=US'>United States</a></p>
    <p><a href='index.php?section=nation&loc=JP'>Japan</a></p>
    <p><a href='index.php?section=nation&loc=UK'>United Kingdom</a></p>
    <p><a href='index.php?section=nation&loc=CA'>Canada</a></p>
    <p><a href='index.php?section=nation&loc=DE'>Deutschland</a></p>
    <p><a href='index.php?section=nation&loc=IT'>Italia</a></p>
    <p><a href='index.php?section=nation&loc=FR'>France</a></p>
    <p><a href='index.php?section=nation&loc=AU'>Australia</a></p>
    <p><a href='index.php?section=nation&loc=TW'>Taiwan</a></p>
    <p><a href='index.php?section=nation&loc=NL'>Nederland</a></p>
    <p><a href='index.php?section=nation&loc=BR'>Brasil</a></p>
    <p><a href='index.php?section=nation&loc=TR'>Turkey</a></p>
    <p><a href='index.php?section=nation&loc=BE'>Belgium</a></p>
    <p><a href='index.php?section=nation&loc=GR'>Greece</a></p>
    <p><a href='index.php?section=nation&loc=IN'>India</a></p>
    <p><a href='index.php?section=nation&loc=MX'>Mexico</a></p>
    <p><a href='index.php?section=nation&loc=DK'>Denmark</a></p>
    <p><a href='index.php?section=nation&loc=AR'>Argentina</a></p>
    <p><a href='index.php?section=nation&loc=CH'>Switzerland</a></p>
    <p><a href='index.php?section=nation&loc=CL'>Chile</a></p>
    <p><a href='index.php?section=nation&loc=AT'>Austria</a></p>
    <p><a href='index.php?section=nation&loc=KR'>Korea</a></p>
    <p><a href='index.php?section=nation&loc=IE'>Ireland</a></p>
    <p><a href='index.php?section=nation&loc=CO'>Colombia</a></p>
    <p><a href='index.php?section=nation&loc=PL'>Poland</a></p>
    <p><a href='index.php?section=nation&loc=PT'>Portugal</a></p>
    <p><a href='index.php?section=nation&loc=PK'>Pakistan</a></p>
    </center>
    <small><a href="index.php?loc=<?php echo $loc ?>">< Back to Lunar News <?php echo $loc ?> front page</a></small>
</body>
</html>