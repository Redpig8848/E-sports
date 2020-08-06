<?php

$HTML =  file_get_contents("https://www.500bf.com/index/index/index?type=0");

$match_start_panel = substr($HTML,strpos($HTML,"class=\"match_start_panel\""));

$match_start_panel = substr($match_start_panel,0,strpos($match_start_panel,'广告'));


$match_start_panel_array = explode('id="match_start_panel"',$match_start_panel);


//print_r($match_start_panel_array);
echo $HTML;







































