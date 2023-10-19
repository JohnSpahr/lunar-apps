<?php
$show_results = FALSE;
$results_html = "";
$final_result_html = "<hr>";

if(isset( $_GET['q'])) { // if there's a search query, show the results for it
    $query = urlencode($_GET["q"]);
    $show_results = TRUE;
    $search_url = "https://html.duckduckgo.com/html?q=" . $query;
    
    //use curl instead of file_get_contents because it seems to be more reliable
    $ch = curl_init($search_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if( ($results_html = curl_exec($ch) ) === false)
    {
        //error
        $error_text .=  "Failed to get results, sorry :( <br>";
    }
    
    // Close handle
    curl_close($ch);

    $simple_results = $results_html;
    $simple_results = str_replace( 'strong>', 'b>', $simple_results ); //change <strong> to <b>
    $simple_results = str_replace( 'em>', 'i>', $simple_results ); //change <em> to <i>
    $simple_results = clean_str($simple_results);
    
    $result_blocks = explode('<h2 class="result__title">', $simple_results);
    $total_results = count($result_blocks)-1;

    for ($x = 1; $x <= $total_results; $x++) {
        if(strpos($result_blocks[$x], '<a class="badge--ad">')===false) { //only return non ads
            // result link, redirected through our proxy
            $result_link = explode('class="result__a" href="', $result_blocks[$x])[1];
            $result_topline = explode('">', $result_link);
            $result_link = str_replace( '//duckduckgo.com/l/?uddg=', '/read.php?a=', $result_topline[0]);
            // result title
            $result_title = str_replace("</a>","",explode("\n", $result_topline[1]));
            // result display url
            $result_display_url = explode('class="result__url"', $result_blocks[$x])[1];
            $result_display_url = trim(explode("\n", $result_display_url)[1]);
            // result snippet
            $result_snippet = explode('class="result__snippet"', $result_blocks[$x])[1];
            $result_snippet = explode('">', $result_snippet)[1];
            $result_snippet = explode('</a>', $result_snippet)[0];

            $final_result_html .= "<br><a href='" . $result_link . "'><font size='4'><b>" . $result_title[0] . "</b></font><br><font color='#008000' size='2'>" 
                                . $result_display_url . "</font></a><br>" . $result_snippet . "<br><br><hr>";
        }
    }
}

//replace chars that old machines probably can't handle
function clean_str($str) {
    $str = str_replace( "‘", "'", $str );    
    $str = str_replace( "’", "'", $str );  
    $str = str_replace( "“", '"', $str ); 
    $str = str_replace( "”", '"', $str );
    $str = str_replace( "–", '-', $str );
    $str = str_replace( "&#x27;", "'", $str );

    return $str;
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 2.0//EN">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html>
<head>
    <!-- basic page stuff -->
    <title>Lunar Search</title>
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
     <meta property="og:title" content="Lunar Search: BlackBerry Search Engine" />
     <meta property="og:type" content="website" />
     <meta property="og:url" content="http://lunarproject.org/" />
     <meta property="og:image" content="http://lunarproject.org/images/logo.png" />
     <meta property="og:description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="author" content="3 Random Nerds" />
     <meta charset="UTF-8" />
</head>
<body>

<?php if($show_results) { // there's a search query in q, so show search results ?>

    <form action="/" method="get">
    <a href="/"><b>Lunar Search</b></a> | Look for: <input type="text" size="30" name="q" value="<?php echo urldecode($query) ?>">
    <input type="submit" value="Search">
    </form>
    <hr>
    <br>
    <center>Search Results for <b><?php echo strip_tags(urldecode($query)) ?></b></center>
    <br>
    <?php echo $final_result_html ?>
    
<?php } else { // no search query, so show new search ?>
    <br><br><center><h1><b>Lunar Search</b></h1></center>
    <center><h3>The BlackBerry Search Engine</h3></center>
    <br><br>
    <center>
    <form action="/" method="get">
    Look for: <input type="text" size="30" name="q"><br>
    <input type="submit" value="Search">
    </center>
    <br><br><br>
    <small><center>A <a href="http://lunarproject.org" target="_blank">Lunar Project</a> service. Based on FrogFind by <a href="https://github.com/actionretro" target="_blank">Action Retro</a>.</center><br>
    <small><center>Powered by DuckDuckGo</center></small>
</form>
</form>

<?php } ?>

</body>
</html>