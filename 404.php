<?php
get_header();

?>

<div id="four04" class="four04">
  <h1 class="four04--text"> this is page 404 PAGE NOT FOUND
  </h1>
  <h3 class="four04--text" >Redirecting...</h3>
</div>

<script>
setTimeout(function(){
window.location.href='<?php echo get_site_url() . "/dashboard";?>';
}, 3000);
</script>

<?php
get_footer();
