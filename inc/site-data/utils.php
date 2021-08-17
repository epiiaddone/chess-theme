<?php

//this requires the custom fiends for all review types
//to have theses specific field names
//this does not update the update lastRevewUnix that userQuestion uses
function updateReviewDates($post_id, $update_amount){
$dateNow = new DateTime();
$dateNowString = $dateNow->format('d/m/Y g:i a');
update_post_meta($post_id, 'last_review_date', $dateNowString);

$dateNow->modify($update_amount);
$dateNext = $dateNow->format('d/m/Y g:i a');
$dateNextUnix = $dateNow->format('U');

update_post_meta($post_id, 'next_review_date', $dateNext);
update_post_meta($post_id, 'next_review_unix', $dateNextUnix);
}

function updateLastReviewUnix($post_id){
  $dateNow = new DateTime();
  $dateNowUnix = $dateNow->format('U');
  update_post_meta($post_id, 'last_review_unix', $dateNowUnix);
}
