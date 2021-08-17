<?php
checkLogin();
hideFromUsers();
get_header();

getTacticForReview(get_current_user_id());

get_footer();
