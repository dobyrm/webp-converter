<?php

include "WebPConverter.php";

$webPConverter = new WebPConverter();

$webPConverter->setImage($_GET['imagePath'], $_GET['imageQuality']);
$webPConverter->runConverting();

// Enter Image webP
$webPConverter->getImage();