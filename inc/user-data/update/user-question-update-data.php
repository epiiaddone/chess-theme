<?php

add_action('rest_api_init', 'updateUserQuestion');

function updateUserQuestion(){
  register_rest_route('user/v1/', 'updateUserQuestion',array(
    'methods' =>'POST',
    'callback' => 'saveUserQuestion'
  ));
}

//assumes that userQuestion does exits
function saveUserQuestion($data){

$debug = true;

    $user_uuid = $data['user_uuid'];
    $question_id = $data['question_id'];
    $button_hit = $data['button_hit'];
    $user_id = get_ID_Ajax($user_uuid);

if($debug){
  echo "user_id:[" . $user_id . "] ";
    echo "question_id:[" . $question_id . "] ";
    echo "button_hit:[" . $button_hit . "] ";
  }

    if(!is_user_valid($user_id)) return;
    if(!is_post_valid($question_id, 'questions')) return;

    $userQuestionQuery = new WP_Query(array(
      'post_type'=> 'userQuestions',
      'author'=>$user_id,
      'post_status'=>'publish',
      'meta_query'=>array(
        array(
          'key'=>'question_id',
          'value'=>$question_id,
          'compare'=>'=',
          'type' => 'numeric',
        )
      )
    ));
wp_reset_postdata();
if($debug) print_r($userQuestionQuery);

      $userQuestionId = 0;
      $stage = 1;
     while($userQuestionQuery->have_posts()){
       $userQuestionQuery->the_post();
       $userQuestionId = get_the_id();
       $stage=get_field('stage');
       $active = get_field('active');

if($debug){
     echo "userQuestionId:[" . $userQuestionId . "] ";
     echo "stage:[" . $stage . "] ";
}

     if($button_hit=='hard'){
       $stage = $stage > 1 ? --$stage : 1;
       update_post_meta($userQuestionId, 'last_result', -1);
     }
     elseif($button_hit=='okay'){
       update_post_meta($userQuestionId, 'last_result', 0);
     }
     else{
       update_post_meta($userQuestionId, 'last_result' , 1);
       $stage = $stage <10  ? ++$stage : 10;
     }
        update_post_meta($userQuestionId, 'stage', $stage);

      //  echo "newStage:[" . $stage . "]";

        $timeUntilNextReview = '';

        switch($stage){
          case 1: $timeUntilNextReview = '+1 day'; break;
          case 2: $timeUntilNextReview = '+2 day'; break;
          case 3: $timeUntilNextReview = '+3 day'; break;
          case 4: $timeUntilNextReview = '+7 day'; break;
          case 5: $timeUntilNextReview = '+14 day'; break;
          case 6: $timeUntilNextReview = '+30 day'; break;
          case 7: $timeUntilNextReview = '+60 day'; break;
          case 8: $timeUntilNextReview = '+120 day'; break;
          case 9: $timeUntilNextReview = '+240 day'; break;
          case 10: $timeUntilNextReview = '+360 day'; break;
        }

        updateReviewDates($userQuestionId, $timeUntilNextReview);
        updateLastReviewUnix($userQuestionId);

      //echo "timeUntilNextReview:[" . $timeUntilNextReview . "]";


        wp_update_post(array(
          'ID'=>$userQuestionId,
          'post_title'=> 'user_id:' . $user_id . ' question_id:' . $question_id . ' stage:' . $stage . ' active:' . $active,
          )
        );
        incrementUserData('update',$user_id);

}
  }
