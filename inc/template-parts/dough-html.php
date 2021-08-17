<?php
//title is above the percentage
//subtitle is below the percentage
//pass in null for absence of title/subtitle
function getDough($percentage,$color,$unique,$title,$subtitle,$url){
?>
<style>
.donut-segment-<?php echo $unique;?> {
    stroke: <?php echo $color;?>;
    animation: donut<?php echo $unique;?> 3s;
}

@keyframes donut<?php echo $unique;?>{
    0% {
        stroke-dasharray: 0, 100;
    }
    100% {
        stroke-dasharray: <?php echo $percentage;?>, <?php echo 100-$percentage;?>;
    }
}
.donut-text-<?php echo $unique;?> {
    fill: <?php echo $color;?>;
}

.donut-hole-<?php echo $unique;?> {
  <?php if(!$url){
    echo 'fill: ' .  $color . ";";
    echo 'opacity:0.1;';
  }else{
    echo 'fill:#fff';
  }
    ?>
    ;
}
</style>
<div class="svg-item">
  <svg  width="100%" height="100%" viewBox="0 0 40 40" class="donut">
    <circle class="donut-hole donut-hole-<?php echo $unique;?>" cx="20" cy="20" r="15.91549430918954"></circle>
    <circle class="donut-ring" cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5"></circle>
    <circle class="donut-segment donut-segment-<?php echo $unique;?>"
      cx="20" cy="20" r="15.91549430918954" fill="transparent" stroke-width="3.5"
      stroke-dasharray="<?php echo $percentage;?> <?php echo 100-$percentage;?>"
      stroke-dashoffset="25">
    </circle>
    <g id="circle<?php echo $unique;?>" class="donut-text donut-text-<?php echo $unique;?>   <?php if($url != null) echo ' donut-url';?>">
      <?php if($title != null){ ?>
      <text y="30%" transform="translate(0, 2)">
              <tspan x="50%" text-anchor="middle" class="donut-title"><?php echo $title;?></tspan>
        </text>
        <?php } ?>
      <text y="50%" transform="translate(0, 2)">
        <tspan x="50%" text-anchor="middle" class="donut-percent"><?php echo $percentage;?>%</tspan>
      </text>
      <?php if($subtitle !=null){?>
      <text y="65%" transform="translate(0, 2)">
        <tspan x="50%" text-anchor="middle" class="donut-data"><?php echo $subtitle;?></tspan>
      </text>
      <?php }?>
    </g>
  </svg>
</div>
<?php if($url != null){?>
<script>
let temp<?php echo $unique;?> = document.getElementById('circle<?php echo $unique;?>');
temp<?php echo $unique;?>.addEventListener('pointerdown', function(){
  location.href='<?php echo $url;?>';
});
</script>
<?php }

}

function generateDashDough($amount,$seen,$title,$color,$url,$level){

  $percentage = $amount > 0 ? round($seen * 100 /$amount) : 0;
  $subtitle = $seen . "/" . $amount;
  $unique = $title . $level;
  $subtitle = $seen . "/" . $amount;
  getDough($percentage,$color,$unique,$title,$subtitle,$url);

}
