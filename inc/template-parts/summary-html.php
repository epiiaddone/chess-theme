<?php

//$data of form
//array(array(lesson_id,result,amount,lesson_title,level))
//assume that the $data is in assending order of level
function get_summary_html($data){

  get_summary_result_html($data,'red',-1,"Hard");

  get_summary_result_html($data,'blue',0,"Medium");

  get_summary_result_html($data, 'green',1,"Easy");

}

function get_summary_result_html($data,$color,$result,$title){
  ?>
  <div class="summary--section">
    <div class="summary--section__title"><?php echo $title;?></div>
    <?php
  foreach($data as $lesson){
    if($lesson[1]==$result){
      $lesson_id = $lesson[0];
      ?>
      <div class="summary--item" onclick="location.href='<?php echo site_url("/lesson/?num=$lesson_id")?>'">
        <div class="summary--item__title" style="color:<?php echo $color;?>"><?php echo $lesson[3];?></div>
        <div class="summary--item__count"><?php if($lesson[2]>1) echo"x " .  $lesson[2];?></div>
      </div>
      <?php
    }
  }
  ?>
</div>
<?php
}
