<?php
require './config.php';

$_SESSION['token'] = '';
exit(header("Location: " . $base));