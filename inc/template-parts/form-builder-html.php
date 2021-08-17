<?php





function makeCheckbox($values, $name, $selected_value){
  foreach( $values as $value):
?>

  <span><?php echo $value ?></span>
  <input type="checkbox" name="<?php echo $name ?>" value="<?php echo $value; ?>" <?php if($value==$selected_value) echo "checked=checked"?>  /><br />

<?php endforeach;

}

function makeRadio($values, $name, $selected_value){
  foreach( $values as $value):
?>

  <span><?php echo $value ?></span>
  <input type="radio" name="<?php echo $name ?>" value="<?php echo $value; ?>" <?php if($value==$selected_value) echo "checked=checked"?> /><br />

<?php endforeach;

}

function makeTextbox($name, $value){?>
  <span><?php echo $value ?></span>
  <input type="textbox" name="<?php echo $name ?>" value="<?php echo $value; ?>" /><br />
  <?php
}
