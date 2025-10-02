<?php
session_start();
session_unset();
session_destroy();
header('Location: ../front/strona_internetowa.html');
exit;
?>
