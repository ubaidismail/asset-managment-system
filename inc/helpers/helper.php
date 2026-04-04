<?php

// Example: Formatting a date
function formatDate($date) {
    return date('M d, Y', strtotime($date));
}
