<?php
return [
    // integer is in unit of time hour
    // 1 cycle = unit_of_time(interval)  x repetition(per)
    // every 24 hrs 1 cyle
    // unit(hr) per(int) cycle
    // cycle count = duration
    // duration if after 30 cycles
    // if duration is lifetime 

    // possible two way of subscription
    // paid every week for 10 weeks
    // paid every week lifetime...
    ["name" => "hourly", "value" => 1],
    ["name" => "daily", "value" => 24],
    ["name" => "weekly", "value" => 168],
    ["name" => "monthly", "value" => 730],
    ["name" => "quarterly", "value" => 2190],
    ["name" => "semiannually", "value" => 4380],
    ["name" => "yearly", "value" => 8760],
];
