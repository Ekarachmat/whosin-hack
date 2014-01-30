<?php

	$nmapResults = array();
    $nmapCommand  = "nmap -sP 192.168.10.*";
    echo "  exec= $nmapCommand\n";
    $output = exec($nmapCommand, $nmapResults);
    print_r($nmapResults);

    $blank = array_pop($nmapResults);
    $starting = array_pop($nmapResults);

    foreach ($nmapResults as $row) {
    	
    }
?>