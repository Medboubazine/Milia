<?php
use Milia\Framework\Configuration\Config;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome here</title>
</head>
<body>
    <h1>Welcome here to new Framework : <?=Config::get('app.name')?></h1>
    <h1>Database name : <?=$name?></h1>
</body>
</html>