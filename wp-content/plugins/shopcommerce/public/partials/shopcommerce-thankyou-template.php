<?php
session_start();
if (!isset($_SESSION['cedstore']) || empty($_SESSION['cedstore'])) {
    wp_redirect('shop');
}
get_footer();
?>