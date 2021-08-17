<?php

get_header();

wp_reset_postdata();
?>
<div class="container">
  <?php
the_content();

?>
</div>

<?php

get_footer();
