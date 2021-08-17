<?php
checkLogin();
get_header();
?>

<div class="profile">
  <div class="profile--title">Reset Progress</div>
  <div class="profile--text">This will mark lessons as incomplete and remove all quesitons from your reviews.
     All SRS data will also be deleted.
   </div>
   <div class="reset">
     <div class="reset--title">reviews to reset:</div>
     <div class="reset--select__container">
     <div class="reset--select">
       <select id="resetSelectLevel">
         <option disabled selected value> - - select - -</option>
         <option value="below1200">Below 1200</option>
         <option value="1200-1400">1200 - 1400</option>
         <option value="1400-1600">1400 - 1600</option>
         <option value="1600-1800">1600 - 1800</option>
         <option value="1800-2000">1800 - 2000</option>
         <option value="2000-2200">2000 - 2200</option>
         <option value="2200-2400">2200 - 2400</option>
         <option value="all">ALL</option>
       </select>
     </div>
     <div class="reset--select">
       <select id="resetSelectType">
         <option disabled selected value> - - select - -</option>
         <option value="opening">Opening</option>
         <option value="middlegame">Middlegame</option>
         <option value="endgame">Endgame</option>
         <option value="all">ALL</option>
       </select>
     </div>
   </div>
     <div id="resetReviewsButton" class="reset--button">Reset</div>
   </div>
</div>
<div class="lesson--hidden" id="user_uuid"><?php echo get_UUID();?></div>

<?php
get_footer();
