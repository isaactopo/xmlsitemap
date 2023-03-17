<?php

function getChangeFreq($lastModDate) {
    $currentDate = date("Y-m-d");
    $diff = abs(strtotime($currentDate) - strtotime($lastModDate));
    $daysDiff = ceil($diff / (60 * 60 * 24)); // días desde la última modificación

    switch (true) {
    case ($daysDiff == 0):
        return "always";
    case ($daysDiff <= 1):
        return "hourly";
    case ($daysDiff <= 7):
        return "daily";
    case ($daysDiff <= 30):
        return "weekly";
    case ($daysDiff <= 365):
        return "monthly";
    default:
        return "never";
    }
}