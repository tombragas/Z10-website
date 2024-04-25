<?php

$intro = getContent($mysqli, 'intro');
$news  = getContent($mysqli, 'news');
?>
<h1 class="title welcometitle">Willkommen!</h1>
<article class="welcometext" id="welcometext">
  <style>
    .welcometext picture {
      padding: 5px;
      padding-right: 0;
    }
  </style>
  <!-- Texte->intro und Texte->news einbinden -->
  <div class="intro"><?php echo $intro ?></div>
  <?php echo $news ?>
  <script defer>
    window.addEventListener('DOMContentLoaded', (e) => {
      let w = document.getElementById("welcometext");
      w.style.height = w.offsetHeight;
      document.querySelector('#welcometext img').style.height = w.offsetHeight - 35 + "px";
    });
  </script>
</article>

<!-- Termine -->
<h2 id="dates">Termine <a href="/termineics">
  <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" style="transform: translateY(7px);" viewBox="0 0 24 24"><path fill="currentColor" d="M17 22v-3h-3v-2h3v-3h2v3h3v2h-3v3h-2ZM5 20q-.825 0-1.413-.588T3 18V6q0-.825.588-1.413T5 4h1V2h2v2h6V2h2v2h1q.825 0 1.413.588T19 6v6.1q-.5-.075-1-.075t-1 .075V10H5v8h7q0 .5.075 1t.275 1H5ZM5 8h12V6H5v2Zm0 0V6v2Z"/></svg>
</a></h2>
<?php
require_once __DIR__ . "/Components/Event.php";


$festivalBeginning = <<<HTML
<style>
  
.festival-week {
    padding: 1px 0;
    margin-block-end: 2rem;
    padding-block-start: 1rem;
    position: relative;
    color: black;
}

.festival-week .datename,
.festival-week a,
.festival-week .datename svg {
    color: black;
}

.festival-week .dates {
    backdrop-filter: none;
    background-color: transparent;
    color: black;
}

.festival-week .datename::before {
    content: "";
    background-image: url(/imgs/ss23/watercolor-stroke-long.webp);
    background-repeat: no-repeat;
    background-size: contain;
    width: 200px;
    height: 40px;
    z-index: -1;
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -10%;
    opacity: .7;
}

.festival-week .datename {
    position: relative;
    display: inline-block;
    font-family: 'Anton', sans-serif, fantasy;
    text-align: center;
}

.festival-week .datestamp {
    text-align: center;
    font-size: 1rem;
}

.festival-week .dateheader {
    max-width: 300px;
    margin: auto;
    display: grid;
}

.festival-week-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    object-position: top;
    object-fit: scale-down;
    height: 100%;
    background-image: url(/imgs/ss23/paper_background_small_800_2.webp);
    background-size: 100% auto;
    z-index: -1;
}

.festival-week::before,
.festival-week::after {
    content: "";
    height: 2px;
    position: absolute;
    left: 0;
    right: 0;
    clip-path: polygon(0% 0%, 5% 100%, 10% 0%, 15% 100%, 20% 0%, 25% 100%, 30% 0%, 35% 100%, 40% 0%, 45% 100%, 50% 0%, 55% 100%, 60% 0%, 65% 100%, 70% 0%, 75% 100%, 80% 0%, 85% 100%, 90% 0%, 95% 100%, 100% 0%);
    background-color: #e1e0dc;
}

.festival-week::before {
    top: -2px;
    transform: rotateZ(180deg);
}

.festival-week::after {
    bottom: -2px;
}

@media screen and (min-width: 800px) {
    .festival-week-background {
        background-image: url(/imgs/ss23/paper_background_2.webp);
    }
}

.festival-week-header img {
    height: 5rem;
    width: auto;
    position: absolute;
    transform: translate(50%, -1rem) rotate(45deg);
}

.festival-week-header img:first-child {
    transform: translate(-150%, -1rem) scaleX(-1) rotate(45deg);
}

/* @media screen and (max-width: 505px) { */
.festival-week-header img {
    display: none;
}

.festival-week .dateimage {
    display: none;
}

/* } */

@media screen and (min-width: 600px) {
    .festival-week .dates {
        grid-template-columns: 1fr;
    }

    .festival-week .dateimage {
        grid-column: 2;
    }
}

.festival-week .datetext {
    max-width: 500px;
    margin: auto;
}

.festival-week-header {
    font-family: 'Anton', 'Impact', sans-serif;
    font-size: 2rem;
}

.festival-week-title {
    z-index: 1;
    font-size: 3.5rem;
    font-family: 'Anton', 'Impact', sans-serif;
    letter-spacing: .1rem;
    display: inline-block;
    padding: 0 3rem;
    color: black;
    text-shadow: none;
    margin-bottom: 0;
    line-height: 1;
}

.festival-week-title::before {
    content: none;
}

@font-face {
    font-family: 'Anton';
    font-style: normal;
    font-weight: 400;
    font-display: swap;
    src: url(/styles/anton.woff2) format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}

</style>
<section class="festival-week" id="dates">
<div class="festival-week-header">
  <!-- <img src="/imgs/ss23/tropical_leaf_3.svg" width=="108" height="117" role="presentation"> -->
  <small>40 . Jubiläum</small>
<h2 class="festival-week-title" onpointerenter="burstConfetti(event.clientX, event.clientY)">Festwoche</h2>
  <small>3.-8. Juli 23</small>
<!-- <span>40 Jahre Jubiläum</span> -->
  <!-- <img src="/imgs/ss23/tropical_leaf_3.svg" width="108" height="117" role="presentation"> -->
</div>
  <picture>
    <source srcset="/imgs/ss23/paper_background_2.webp" media="(min-width: 800px)">
    <img src="/imgs/ss23/paper_background_small_800_2.webp" alt="" width="800" height="1520"
     role="presentation" loading="lazy" decoding="async"
     class="festival-week-background">
  </picture>
HTML;

$termine = getTermine($mysqli);
$isFestivalWeek = false;
foreach ($termine as $termin) {
  // if (stripos($termin['name'], 'festwoche') !== FALSE && !$isFestivalWeek) {
  //   $isFestivalWeek = True;
  //   echo $festivalBeginning;
  // }
  // if (stripos($termin['name'], 'festwoche') === FALSE && $isFestivalWeek) {
  //   $isFestivalWeek = False;
  //   echo "</section>";
  // }
  $termin['name'] = str_replace('Festwoche ', '', $termin['name']);
  echo (new Event(...array_values($termin)))->render(!$first, True);
}

#echo '&nbsp;</div>';
?>

<a href="/archiv/<?= date('Y') ?>" style="border: solid thin grey; padding: 1rem 2rem; display: inline-block; border-radius: 1rem;">ältere Termine</a>