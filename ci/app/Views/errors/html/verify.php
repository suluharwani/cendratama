<?php
$local_session = \Config\Services::session();
if (isset($_SESSION['logged'])) {
    echo view('errors/html/404Adm.php');
} else {
    echo view('home/layout/head.php');
    echo view('home/layout/header.php');
    echo view('errors/html/sendVerify.php');
    echo view('home/layout/footer.php');
}