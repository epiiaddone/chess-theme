<?php
get_header();
 ?>

 <div class="front__banner">
       <div class="front__banner--1">
        £50 @ <span class="front__banner--1__emp">100/1</span>
      </div>
      <div class="front__banner--2">
        Bet Placed at WilliamHILL for Gregory Richards to become a chess International Master by December 31st 2030
      </div>
 </div>

 <div class="front__countdown">
 <span class="front__countdown--number" id="t1"></span><span class="front__countdown--text"> Years</span>
 <span class="front__countdown--number" id="t2"></span><span class="front__countdown--text"> Months</span>
 <span  class="front__countdown--number" id="t3"></span><span class="front__countdown--text"> Days</span>
 <div class="front__countdown--subtext"> Remaining to obtain a FIDE rating of 2450 and 3 IM norms</div>
 </div>

 <div class="front__section">
   <div class="front__section--title">About Me</div>
  <p>I'm a 31 year old chess enthusiast from the UK and starting this year I have decided to take my chess improvement seriously.
     I've been playing very casually since childhood but until now I've never put much effort into studying.
      January 2021 marks the start of my journey towards IM.
  </p>
<p>
The name of this site is due to a wager of £50 with William Hill at odds of 100:1 on me becoming an IM before Dec 31st 2030.
 This is an idea I got from reading the blog roadtograndmaster by Will Taylor,
  where he details how he placed a similar bet back in 2010.
</p>
<p>
Although currently unrated I have played four FIDE rated games (1 win, 3 losses) which works out to a TPR of 1277.
 I will therefore estimate my starting level to be about 1300 meaning that I have just under 10 years to gain 1250 rating points.
</p>
<div class="socials">
  <div class="socials__section socials__section--twitter">
    <a href="https://twitter.com/100to1Chess" target="_blank">
    <img class="" src="wp-content/themes/chess-theme/inc/img/twitter512.png">
  </a>
  </div>
  <div class="socials__section socials__section--youtube">
    <a href="https://www.youtube.com/channel/UC8BlEGugR_8n1_h-QDHwybA" target="_blank">
    <img class="" src="wp-content/themes/chess-theme/inc/img/youtube1200_538.png">
  </a>
  </div>
  <div class="socials__section socials__section--patreon">
    <a href="https://www.patreon.com/100to1chess" target="_blank">
      <img class="" src="wp-content/themes/chess-theme/inc/img/patreon500_320.png">
    </a>
  </div>
</div>
 </div>

<div class="front__chart--wrapper">
  <div class="front__section front__section--gray front__section--chart">
   <div class="front__chart--container">
   <canvas id="myChart"></canvas>
   </div>
  </div>

  <div class="front__section front__section--gray front__section--chart">
   <div class="front__chart--container">
   <canvas id="page-chart1"></canvas>
   </div>
  </div>
</div>
<div class="front__section">
  <div class="front__section--title">My Method</div>
  <p>
  I've heard numerous Grandmasters say that the main difference between themselves and club level players is that they are more
  familiar with a wider variety of positions.
</p>
<p>
This means that although the club player is very knowledgeable about the opening and  related early
middle game plans they will reach a point in the late middle game or endgame where their knowledge
 runs out and they don't know what to do.
</p>
<p>
It is at this point in the game where the weaker player will often ruin their
 own position with a bad plan or fail to prevent the Grandmaster from realising their plan due
  to lack of understanding of what the Grandmaster is trying to achieve.
</p>
<p>
Therefore I will concentrate my time on increasing my knowledge of middle game structures and their related plans.
</p>
<p>
This website will contain all of my chess knowledge sorted into lessons and corresponding
 questions linked to an SRS (Spaced Repetition System). This is because I believe that revision is the most
  important part of learning anything.
</p>
</div>

<div class="front__section front__section--gray">
  <div class="front__section--title">Year 1 Goals</div>
  <p>
<span class="front__goal">Create a training program:</span> Mainly focused on chess knowledge but also finding a good way to improve my tactical ability.
</p>
<p>
<span class="front__goal">Reach 1600 strength:</span> This may have to be an estimate of strength if OTB play doesn't return in 2021.
</p>
<p>
<span class="front__goal">Develop a very simple white repertoire:</span> This will probably be 1.c4 and I will aim to avoid learning theory as much as possible.
</p>
<p>
<span class="front__goal">Stop being crushed as black:</span> Too often as black I allow my opponent to get a very easy game where they win with a simple kingside attack. I would like to avoid as much theory as possible here too.
</p>
<p>
<span class="front__goal">Determine my playing style:</span> Do I prefer positional or tactical, open or closed, symmetrical or imbalanced, space advantage or counter attack.
</p>
<p>
<span class="front__goal">Get into better shape physically:</span> Grandmasters often talk about physical fitness as important for maintaining concentration during long games. Currently I have a very inactive lifestyle and I'm the heaviest I've ever been, weighing in at 135kg.
</p>
<p>
<span class="front__goal">Kick my caffeine habit:</span> I drink two large energy drinks per day, which sees my energy levels fluctuate massively throughout the day. Ideally this will be reduced to none by the end  of the year.
</p>
<p>
<span class="front__goal">Finish building this site:</span> This will include the SRS functionality and a fully organised way to continuously add lessons and questions.
</p>
</div>

<div class="front__section">
    <div class="front__section--title">Flashcard Examples</div>
    <p>
      Here are 4 middlegame ideas that I want to remember from GM Daniel King's analysis of
      <a class="front_section--link" target="_blank" href="https://www.youtube.com/watch?v=uCkqNiCskHs">Magnus Carlsen vs Le Quang Liem</a> from his PowerPlayChess youtube channel.
    </p>
    <?php
    the_content();
    ?>
</div>

 <?php
//get_mail_signup_html();
get_cookie_consent_html();
 get_footer();
