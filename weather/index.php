<?php
//created by John Spahr for lunarproject.org
$json = '';
if(isset( $_GET['q'])) { // if there's a search query, show the results for it
    $query = urlencode($_GET["q"]);
    //api key (DO NOT SHARE)
    $api_call = "http://api.weatherapi.com/v1/forecast.json?key=a91ba5fc449842dc9dd220747231510&days=3&q=" . $query;
    
    //use curl to get weatherapi JSON
    $ch = curl_init($api_call);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if( ($results_json = curl_exec($ch) ) === false)
    {
        //error
        echo "<p><b>ERROR: </b>Could not load weather.</p>";
    }
    else
    {
        //decode JSON
        if (ob_get_level() == 0)
        {
            ob_start();
        } 
        $json = json_decode($results_json, false);
        ob_end_flush();
    }
    
    // Close handle
    curl_close($ch);
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
    <title>Lunar Weather</title>
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
     <meta property="og:title" content="Lunar Search: BlackBerry Weather App" />
     <meta property="og:type" content="website" />
     <meta property="og:url" content="http://lunarproject.org/" />
     <meta property="og:image" content="http://lunarproject.org/images/logo.png" />
     <meta property="og:description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="description" content="Lunar: The BlackBerry Preservation Effort" />
     <meta name="author" content="3 Random Nerds" />
     <meta charset="UTF-8" />
</head>
<body>
    <form action="/" method="get">
    <a href="/"><b>Lunar Weather</b></a> | Enter location: <input type="text" size="30" name="q" value="<?php echo urldecode($query) ?>">
    <input type="submit" value="Search">
    </form>
    <hr>
    <?php 
        if ($json !== '') {
            //current weather
            echo "<center><p><b>" . $json->location->name . ", " . $json->location->region . ", " . $json->location->country . "</b> - Weather</p><h1>" . $json->current->temp_f . "&deg;F (" . $json->current->temp_c . "&deg;C)</h1><img src='http:" . $json->current->condition->icon . "' alt='Current Weather'/><p><b>Current Weather: </b>" . $json->current->condition->text . "</p><p><b>Feels like: </b>" . $json->current->feelslike_f . "&deg;F (" . $json->current->feelslike_c . "&deg;C)</p><p><b>Low: </b>" . $json->forecast->forecastday[0]->day->mintemp_f . "&deg;F (" . $json->forecast->forecastday[0]->day->mintemp_c . "&deg;C)</p><p><b>High: </b>" . $json->forecast->forecastday[0]->day->maxtemp_f . "&deg;F (" . $json->forecast->forecastday[0]->day->maxtemp_c . "&deg;C)</p><p><b>Chance of rain: </b>" . $json->forecast->forecastday[0]->day->daily_chance_of_rain . "%</p><p><b>Chance of snow: </b>" . $json->forecast->forecastday[0]->day->daily_chance_of_snow . "%</p><p><b>Humidity: </b>". $json->current->humidity . "%</p><p><b>Wind: </b>" . $json->current->wind_mph . " mph " . $json->current->wind_dir . " (" . $json->current->wind_kph . " kph)</p><hr>";
            
            //1 day's weather
            echo "<center><h1>" . $json->forecast->forecastday[1]->date . "</h1><img src='http:" . $json->forecast->forecastday[1]->day->condition->icon . "' alt='Weather'/><p><b>Weather: </b>" . $json->forecast->forecastday[1]->day->condition->text . "</p><p><b>Low: </b>" . $json->forecast->forecastday[1]->day->mintemp_f . "&deg;F (" . $json->forecast->forecastday[1]->day->mintemp_c . "&deg;C)</p><p><b>High: </b>" . $json->forecast->forecastday[1]->day->maxtemp_f . "&deg;F (" . $json->forecast->forecastday[1]->day->maxtemp_c . "&deg;C)</p><p><b>Average temp: </b>" . $json->forecast->forecastday[1]->day->avgtemp_f . "&deg;F (" . $json->forecast->forecastday[1]->day->avgtemp_c . "&degC)</p><p><b>Chance of rain: </b>" . $json->forecast->forecastday[1]->day->daily_chance_of_rain . "%</p><p><b>Chance of snow: </b>" . $json->forecast->forecastday[1]->day->daily_chance_of_snow . "%</p><hr>";
            
            //1 day's weather
            echo "<center><h1>" . $json->forecast->forecastday[2]->date . "</h1><img src='http:" . $json->forecast->forecastday[2]->day->condition->icon . "' alt='Weather'/><p><b>Weather: </b>" . $json->forecast->forecastday[2]->day->condition->text . "</p><p><b>Low: </b>" . $json->forecast->forecastday[2]->day->mintemp_f . "&deg;F (" . $json->forecast->forecastday[2]->day->mintemp_c . "&deg;C)</p><p><b>High: </b>" . $json->forecast->forecastday[2]->day->maxtemp_f . "&deg;F (" . $json->forecast->forecastday[2]->day->maxtemp_c . "&deg;C)</p><p><b>Average temp: </b>" . $json->forecast->forecastday[2]->day->avgtemp_f . "&deg;F (" . $json->forecast->forecastday[2]->day->avgtemp_c . "&degC)</p><p><b>Chance of rain: </b>" . $json->forecast->forecastday[2]->day->daily_chance_of_rain . "%</p><p><b>Chance of snow: </b>" . $json->forecast->forecastday[2]->day->daily_chance_of_snow . "%</p><hr>";
            
            //location info
            echo "<h3>Location info:</h3><p><b>Local time: </b>" . $json->location->localtime . "</p><p><b>Time Zone: </b>" . $json->location->tz_id . "</p><p><b>Latitude and Longitude: </b>" . $json->location->lat . ", " . $json->location->lon . "</p></center><hr>";
        }
    ?>
    <p>The BlackBerry Weather App. Powered by <a href="https://www.weatherapi.com/" target="_blank" title="Free Weather API">WeatherAPI.com</a>. This is a service of <a href="http://lunarproject.org" target="_blank">LunarProject.org</a>.</p>
    <p><b>Not working?</b> Try refreshing the page or visiting <a href="http://google.com/search?q=weather" target="_blank">this link</a>.</p>
</form>

</body>
</html>