<?php
require_once __DIR__.'/vendor/autoload.php';

if(!file_exists(__DIR__.'/dist'))
    mkdir(__DIR__.'/dist');

$j = new JuggleCode();
$j->setMasterfile(__DIR__.'/src/app.php');
$j->setOutfile(__DIR__.'/dist/app.php');
$j->mergeScripts = true;
$j->comments = false;
$j->run();

// Minify
$data = file_get_contents(__DIR__.'/dist/app.php');
// Remove
$data = str_replace(["\r\n", "\n", "<?php", "?>", "    "], '', $data);
file_put_contents(__DIR__.'/dist/app.php', '<?php '.$data.' ?>');
