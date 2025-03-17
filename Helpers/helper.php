<?php
function abbreviateNumber($number) {
    $number = (int) $number;
    if ($number > 999) {
        $abrev = substr((string)$number, 0, 2);
        $formatted = implode(',', str_split($abrev));
        if ($number > 999999999) {
            return $formatted . ' B';
        } elseif ($number > 999999) {
            return $formatted . ' M';
        } elseif ($number > 999) {
            return $formatted . ' K';
        }
    }
    return $number;
}
?>
