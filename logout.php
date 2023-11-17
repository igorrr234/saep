<?php

session_start();

session_unset();

session_destroy();

header("Location:turmas1.php");
exit();

?>