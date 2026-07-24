<?php

if (!isset($_SESSION['user_id'])) {
    die("Нямате достъп.");
}


if ($_SESSION['role'] !== 'admin') {
    die("Нямате администраторски права.");
}