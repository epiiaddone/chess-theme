<?php

function buildPathToDash(){
  $paths = array();
  $paths['dashboard'] = "/dashboard";
  return $paths;
}

function buildPathToLevel($level){
  $paths = buildPathToDash();
  $pathName =  get_level_nice($level);
  $paths[$pathName] = "/level/?level=" . $level;
  return $paths;
}

function buildPathToTacticsDD($level){
  $paths = buildPathToLevel($level);
  $paths["Tactics Overview"] = "/tacticsdd/?level=" . $level;
  return $paths;
}

function buildPathToType($level,$type){
  $paths = buildPathToLevel($level);
  $pathName = get_type_display_name($type);
  $paths[$pathName] = '/type/?type=' . $type . '/?level=' . $level;
  return $paths;
}

function buildPathToGroup($group, $type, $level){
  $paths = buildPathToType($level,$type);
  $pathName = getGroupTitle($group);
  $paths[$pathName] = "/group/?level=" . $level . "/?type=" .$type . "/?group=" . $group;
  return $paths;
}

function getNavPathHtml($paths,$banner_args){
  ?>
  <div class="nav-path">
    <!--<div class="nav-path__title">Navigation</div>-->
    <div class="nav-path__linkBox">
    <?php
    foreach($paths as $linkName => $linkUrl){
      getNavPath($linkName, $linkUrl);
    }
    get_banner_html($banner_args);
?>
    </div>
  </div>
<?php
}

function getNavPath($linkName, $linkUrl){
  ?>
  <div class="nav-path__link">
    <a href="<?php echo $linkUrl;?>"><?php echo $linkName;?></a>
  </div>
  <span class="nav-path__linkBox--divider">></span>
  <?php
}

function get_banner_html($args){
  $debug = false;
  $title = !!$args['title'] ? $args['title'] : '';
  ?>
  <div class="nav-path--title"><?php echo $title;?></div>
<?php
}


//////////////////////////////////////
/////////////DANGER: HARDCODED DATA Here

// function getNavPathLinkUrl($path){
//   $pathUrl = '';
//   switch($path){
//     case "dashboard" : $pathUrl = '/dashboard'; break;
//   }
//   return $pathUrl;
// }
//
// function getNavPathLinkName($path){
//   $pathName = '';
//   switch($path){
//     case "dashboard" : $pathName = 'Dashboard'; break;
//   }
//   return $pathName;
// }
