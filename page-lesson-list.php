<?php
checkLogin();
hideFromUsers();
get_header();

?>
<div class="container">
  <?php
get_lesson_list_page();
?>
</div>
<?php
get_footer();
