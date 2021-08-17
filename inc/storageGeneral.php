<?php

function putGeneralStorageData($storage_type){
  $tactics_count = array();
  $vis_count = array();
  $remember_count = array();
  $lesson_count_open = array();
  $lesson_count_middle = array();
  $lesson_count_end = array();

  for($i=11; $i<=16; $i++){
    $tactics_count[$i] = getNumberInSet('tactic',$i);
    $vis_count[$i] = getNumberInSet('visualisations',$i);
    $remember_count[$i] = getNumberInSet('remember',$i);
    $lesson_count_open[$i] = getNumberLessonInSet('open',$i);
    $lesson_count_middle[$i] = getNumberLessonInSet('middle',$i);
    $lesson_count_end[$i] = getNumberLessonInSet('end',$i);
  }
  ?>
  <script>
  function storageAvailable(type) {
    var storage;
    try {
        storage = window[type];
        var x = '__storage_test__';
        storage.setItem(x, x);
        storage.removeItem(x);
        return true;
    }
    catch(e) {
        return e instanceof DOMException && (
            // everything except Firefox
            e.code === 22 ||
            // Firefox
            e.code === 1014 ||
            // test name field too, because code might not be present
            // everything except Firefox
            e.name === 'QuotaExceededError' ||
            // Firefox
            e.name === 'NS_ERROR_DOM_QUOTA_REACHED') &&
            // acknowledge QuotaExceededError only if there's something already stored
            (storage && storage.length !== 0);
    }
}

localStorage.clear();
var isStorageAvailable = storageAvailable('<?php echo $storage_type?>');
<?php
for($i=11; $i<=16; $i++){?>
  localStorage.setItem('tactics_count_level_<?php echo $i;?>' , <?php echo $tactics_count[$i];?>);
  localStorage.setItem('visualisations_count_level_<?php echo $i;?>' , <?php echo $vis_count[$i];?>);
  localStorage.setItem('remember_count_level_<?php echo $i;?>' , <?php echo $remember_count[$i];?>);
  localStorage.setItem('lesson_open_count_level_<?php echo $i;?>' , <?php echo $lesson_count_open[$i];?>);
  localStorage.setItem('lesson_middle_count_level_<?php echo $i;?>' , <?php echo $lesson_count_middle[$i];?>);
  localStorage.setItem('lesson_end_count_level_<?php echo $i;?>' , <?php echo $lesson_count_end[$i];?>);
  <?php
}
?>
</script>

<?php
}
