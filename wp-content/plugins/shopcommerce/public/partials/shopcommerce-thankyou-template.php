<?php
session_start();
// if (!isset($_SESSION['cedstore']) || empty($_SESSION['cedstore'])) {
//     wp_redirect('shop');
// }
get_header();
?>
	
<body>
	
        <h1 class="site-header__title" data-lead-id="site-header-title">THANK YOU!</h1>
        <h3 class="site-header__subtitle">YOUR ORDER IS PLACED</h3>
        

	<div class="main-content">
        <i class="fa fa-check main-content__checkmark" id="checkmark"></i>
        <br>
    </div>
    <div class="btn-cotinue">
    <a href="shop"><button id="continue">CONTINUE SHOPPING</button><a>
    </div>

    
<?php
get_footer();
?>