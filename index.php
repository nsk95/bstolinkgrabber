<?php

/**
 * BS.to Linkgrabber
 * SpyrotheLegend
 * spyro.xyz
 * v0.1
 */

set_time_limit(20000);

require_once("./simple_html_dom.php");

$seasons    = array();
$episodes   = array();
$baseurl    = "https://www.bs.to/";
$url        = "https://bs.to/serie/The-Big-Bang-Theory/de";
$content    = file_get_html($url);

foreach($content->find('div#seasons ul li') as $ses) {
    if(stripos($ses->outertext, "disabled")) {
        continue;
    }
    else {
        foreach($ses->find('a') as $link) {
            $seasons[] = $baseurl.$link->href;
        }
    }
}
$content->clear();
unset($content);

foreach($seasons as $season) {
    $seasonContent = file_get_html($season);
    foreach($seasonContent->find('.episodes td a') as $sp) {
        $link = $sp->href;
        if(stripos($link, "vivo")) {
            $episodes[] = $baseurl.$link;
        }
    }
    $seasonContent->clear();
    unset($seasonContent);
}

foreach($episodes as $episode) {
    $episodeContent = file_get_html($episode);
    foreach($episodeContent->find('.hoster-player') as $vidlink) {
        echo $vidlink->href."<br/>";
    }
    $episodeContent->clear();
    unset($episodeContent);
}