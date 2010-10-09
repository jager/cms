<?php 
    $aParams = Zend_Controller_Front::getInstance()->getRequest()->getParams();
    if ( ( ( $aParams['controller'] == 'index' ) and ( $aParams['action'] == 'index' ) ) or
         ( ( $aParams['controller'] == 'index' ) and ( $aParams['action'] == 'view' ) and ( $aParams['page'] == 'strona_glowna.html' ) ) ) {
?>
<!-- HOMEPAGE SLIDESHOW (start) -->
<script type="text/javascript">
        jQuery(document).ready(function() {
            jQuery('#slideshow').cycle({
                fx:     'scrollLeft',
                timeout: 6000,
                pager:  '#slideshow-nav-inner',
                pagerAnchorBuilder: paginate,
                speed:  '2000',
                easing: 'easeInOutQuint'
            });

        });

</script>

<div id="slideshow-wrapper">
        <div id="slideshow">
                <div><a href="/" ><img src="/default/css/images/baner1.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner2.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner3.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner4.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner5.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner6.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner7.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner8.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner9.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner10.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner11.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner12.jpg" alt="" /></a></div>
                <div><a href="/" ><img src="/default/css/images/baner13.jpg" alt="" /></a></div>
        </div><!-- #slideshow (end) -->
        <div id="slideshow-nav" class="ie6">
                <div id="slideshow-nav-inner"></div>
        </div><!-- #slideshow-nav(end) -->
</div><!-- #slideshow-wrapper (end) -->
<?php } ?>
<!-- HOMEPAGE SLIDESHOW (end) -->