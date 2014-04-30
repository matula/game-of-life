<?php
session_start();
unset($_SESSION['cells']);
header('Location:js.php');