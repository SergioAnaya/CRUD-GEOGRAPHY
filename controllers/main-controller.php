<?php

require_once './db/db.php';

if (isset($_GET['action']) AND $_GET['action'] === 'view_provincias') {
    require_once './controllers/provincias-controller.php';
} elseif (isset($_GET['action']) AND $_GET['action'] === 'view_localidades') {
   require_once './controllers/localidades-controller.php';
} else require_once './controllers/comunidades-controller.php';