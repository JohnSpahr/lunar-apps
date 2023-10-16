<?php
error_reporting(E_ERROR | E_PARSE);
header("X-Robots-Tag: noindex, nofollow", true);
require_once('vendor/autoload.php');

$article_url = "";
$article_html = "";
$error_text = "";
$loc = "US";

if( isset( $_GET['loc'] ) ) {
    $loc = strtoupper($_GET["loc"]);
}

if( isset( $_GET['a'] ) ) {
    $article_url = $_GET["a"];
} else {
    echo "What do you think you're doing... >:(";
    exit();
}

if (substr( $article_url, 0, 23 ) != "https://news.google.com") {
    echo("That's not news :(");
    die();
}

/* just a hacky fix lol, maybe make this better later */
$google_redirect_page = file_get_contents($article_url);
$parts = explode('<a href="', $google_redirect_page);
$actual_article_url = explode('"',$parts[1])[0];
$article_url = $actual_article_url;

use andreskrey\Readability\Readability;
use andreskrey\Readability\Configuration;
use andreskrey\Readability\ParseException;

$configuration = new Configuration();
$configuration
    ->setArticleByLine(false);

$readability = new Readability($configuration);

if(!$article_html = file_get_contents($article_url)) {
    $error_text .=  "Failed to get the article :( <br>";
}

try {
    $readability->parse($article_html);
    $readable_article = strip_tags($readability->getContent(), '<ol><ul><li><br><p><small><font><b><strong><i><em><blockquote><h1><h2><h3><h4><h5><h6>');
    $readable_article = str_replace( 'strong>', 'b>', $readable_article ); //change <strong> to <b>
    $readable_article = str_replace( 'em>', 'i>', $readable_article ); //change <em> to <i>
    
    $readable_article = clean_str($readable_article);
    
} catch (ParseException $e) {
    $error_text .= 'Sorry - working on it! ' . $e->getMessage() . '<br>';
}

//replace chars that old machines probably can't handle
function clean_str($str) {
    $str = str_replace( "‘", "'", $str );    
    $str = str_replace( "’", "'", $str );  
    $str = str_replace( "“", '"', $str ); 
    $str = str_replace( "”", '"', $str );
    $str = str_replace( "–", '-', $str );

    return $str;
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 2.0//EN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
 
 <html>
 <head>
     <!-- get article title -->
    <title><?php echo $readability->getTitle();?> - Lunar News</title>
     
	<!-- basic page stuff -->
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
    <small><a href="index.php?loc=<?php echo $loc ?>">< Back to Lunar News <?php echo $loc ?> front page</a></small>
    <h1><?php echo clean_str($readability->getTitle());?></h1>
    <p><small><a href="<?php echo $article_url ?>" target="_blank">Original source</a> (on modern site) <?php
        $img_num = 0;
        $imgline_html = "| Article images:";
        foreach ($readability->getImages() as $image_url):
            //we can only do png and jpg
            if (strpos($image_url, ".jpg") || strpos($image_url, ".jpeg") || strpos($image_url, ".png") === true) {
                $img_num++;
                $imgline_html .= " <a href='image.php?loc=" . $loc . "&i=" . $image_url . "'>[$img_num]</a> ";
            }
        endforeach;
        if($img_num>0) {
            echo  $imgline_html ;
        }
    ?></small></p>
    <?php if($error_text) { echo "<p><font color='red'>" . $error_text . "</font></p>"; } ?>
    <p><font size="4"><?php echo $readable_article;?></font></p>
    <small><a href="index.php?loc=<?php echo $loc ?>">< Back to Lunar News <?php echo $loc ?> front page</a></small>
 </body>
 </html>