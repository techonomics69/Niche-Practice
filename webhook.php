<?php

header('Content-Type: text/plain');
echo @exec("sudo git fetch --all && sudo git reset --hard origin/development", $result1);
echo "\n";
print_r($result1);