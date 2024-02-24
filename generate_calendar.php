<?php
// Example: Fetch events from a file
$events = [];
$file = fopen('events.txt', 'r');
while (($line = fgets($file)) !== false) {
    $data = explode('|', $line);
    $date = $data[0];
    $events[$date][] = $data[1];
}
fclose($file);

// Get the current month and year
$month = date('m');
$year = date('Y');

// Get the number of days in the current month
$days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Get the first day of the month
$first_day = date('N', strtotime("$year-$month-01"));

// Calculate the number of blank cells before the first day
$num_blank_cells = $first_day - 1;

// Generate the calendar cells
$current_day = 1;
echo "<tr>";
for ($i = 1; $i <= 7; $i++) {
    if ($i < $first_day) {
        echo "<td></td>";
    } else {
        while ($current_day <= $days_in_month) {
            // Check if the current day has any events
            $date = "$year-$month-" . str_pad($current_day, 2, '0', STR_PAD_LEFT);
            $event_class = isset($events[$date]) ? 'event' : '';
            echo "<td class='$event_class'>$current_day";
            if (isset($events[$date])) {
                foreach ($events[$date] as $event) {
                    echo "<br><span>$event</span>";
                }
            }
            echo "</td>";
            $current_day++;
            break;
        }
    }
}
echo "</tr>";
?>
