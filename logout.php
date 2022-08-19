<?php
require 'config/constants.php';
// Destroy all sessions and redirect to homepage...
session_unset();
session_destroy();
header('location: '.ROOT_URL);
die();