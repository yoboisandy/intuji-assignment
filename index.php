<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/config.php';

require_once __DIR__ . '/services/googleClient.php';

require_once __DIR__ . '/views/header.php';

require_once __DIR__ . '/views/home.php';

require_once __DIR__ . '/views/footer.php';
