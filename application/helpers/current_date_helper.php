<?php

defined('BASEPATH') OR exit('No direct script access allowed');

function current_date() {
    return date('Y-m-d H:i:s');
}

function timeago($date) {
    if ($date == "") {
        return;
    } else {
        $timestamp = strtotime($date);

        $strTime = array("sec", "min", "h", "day", "month", "year");
        $length = array("60", "60", "24", "30", "12", "10");

        $currentTime = time();
        if ($currentTime >= $timestamp) {
            $diff = time() - $timestamp;
            for ($i = 0; $diff >= $length[$i] && $i < count($length) - 1; $i++) {
                $diff = $diff / $length[$i];
            }

            $diff = round($diff);
            return $diff . " " . $strTime[$i] . "(s) ago ";
        }
    }
}

?>