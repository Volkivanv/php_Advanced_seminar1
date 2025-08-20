<?php 
echo "Переданные аргументы:\n";

for ($i = 1; $i < $argc; $i++) {
    echo "$i: {$argv[$i]}\n";
}

//docker run --rm -v ${pwd}:/cli php:8.2-cli php /cli/argc_argv.php "Mr. Anderson" 33 