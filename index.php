<?php header("Content-Type: text/html; charset=UTF-8"); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic objects annotator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
  </head>
    <?php
        if(isset($_GET["lang"])) {
            if($_GET["lang"] == "sk") {
    ?>
  <body class="tutorial">
      <h1>Nástroj pre identifikáciu a označenie dynamiky objektov</h1>
      <p>
          Tento nástroj bol vytvorený v rámci výskumu skupín <a href="http://www.fit.vutbr.cz/research/groups/graph/">Graph@FIT</a>
          a <a href="http://www.fit.vutbr.cz/research/groups/robo/">Robo@FIT</a>
          na Fakultě Informačních Technológií Vysokého Učení Technického v Brne.
          Cieľom výskumu je zistiť, ako ľudia vnímajú dynamiku objektov
          v rôznych situáciách. Pomocou tohto nástroja môžete vyznačiť štetcom jednotlivé objekty
          a farebne rozlíšiť dynamiku objektu - t.j. za aký čas objekt pravdepodobne
          zmizne zo scény, či ide o objekt, ktorý sa v čase mení, ale v scéne zostáva (typicky stromy,
          kríky, kvety menia svoj vzhľad podľa ročných období, a pohybujú sa podľa poveternostných podmienok),
          alebo ide o rýdzo statický objekt. Časti scény ako zem, cesta, trávnik alebo
          stále budovy sú v rámci tohto experimentu považované za pozadie a nie je teda žiadúce ich označovať.
      </p>
      <h2>Ukážka nástroja:</h2>
      <div>
          <img style="width: 100%;" src="data/tool-demo.png"/>
      </div>
      <h2>Niekoľko príkladov:</h2>
      <p>
          Experiment, na ktorom sa podieľate, má taktiež zistiť, ako totožne či rôzne ľudia
          vnímajú dynamiku objektov. Z toho plynie, že neexistujú "správne" a "nesprávne"
          odpovede. Pri každom obrázku analyzovanej scény vyjadrite, prosím, svoj subjektívny názor.
      </p>
      <p>
          Nasleduje niekoľko príkladov vyznačenia objektov, ich dynamiky a taktiež
          odlišnosti plynúce z iného názoru a pochopenia scény.
      </p>
      <table>
          <tr>
              <td colspan="2"><h3>Príklad 1 - cesta s vozidlami a prenosným značením:</h3></td>
          </tr>
          <tr>
              <td>
                  <img src="data/0011_000270.png"/>
                  <img src="data/0011_000270_ann.png"/>
              </td>
              <td class="desc">
                  <p>
                        V scéne sa nachádzajú <span>pohyblivé objekty</span>, ktoré pravdepodobne v priebehu
                        niekoľkých sekúnd nebudú viac na svojom mieste a sú preto označené žltou farbou
                        (zmiznú do <span>minúty</span>). <span>Zaparkované autá</span> pravdepodobne odídu do <span>1&nbsp;dňa</span>
                        (červená farba), <span>prenosné dopravné značenie do mesiaca</span> (fialová), ale je pravdepodobné,
                        že vertikálne značenie, schránku, smetný kôš a pod. nájdeme na svojom mieste aj po dlhej dobe a sú považované
                        za <span>statické</span> objekty (modrá farba). Zelenou farbou sú vyznačené kríky a stromy, ktoré v scéne
                        zostanú zachované taktiež po dlhú dobu, ale pohybujú sa vo vetre a v priebehu roka <span>menia svoj vzhľad</span>.
                  </p>
              </td>
          </tr>
          <tr>
              <td colspan="2"><h3>Príklad 2 - rôzne pochopenie objektov v pešej zóne:</h3></td>
          </tr>
          <tr>
              <td>
                <img src="data/0013_000110.png"/>
                <img src="data/0013_000110_ann_1.png"/>
                <img src="data/0013_000110_ann_2.png"/>
              </td>
              <td>
                  <p>
                      Tento príklad demonštruje, ako <span>rôzne</span> môže človek pochopiť totožnú scénu a úlohu objektov v nej.
                  </p>
                  <p>
                      Autor č.1 (vyznačil obrázok v strede) považoval za <span>pohyblivé objekty</span> chodcov a cyklistu,
                      a preto vyznačil, že <span>do minúty zmiznú</span> (žltá farba). Bielu dodávku považoval za <span>zásobovanie</span>,
                      ktoré pravdepodobne <span>do hodiny odíde</span> (oranžová) rovnako ako odložený bicykel či osoby sediace na lavičke.
                      Autor ďalej predpokladal, že stojan na bicykle bude obsadený po celý deň a vyznačil ho červenou farbou.
                      Rastlinné dekorácie <span>odkvitnú</span> a preto ich označil za premenlivé (zelená farba).
                      <span>Ostatné objekty</span> považoval autor za <span>stále</span> (modrá).
                  </p>
                  <p>
                      Autor č.2 (spodný obrázok) taktiež odhadoval, že pohyblivé objekty do minúty zmiznú.
                      Bielu dodávku ale považoval za <span>údržbu</span> koľajníc a predpokladal, že sa na mieste zdrží <span>niekoľko hodín</span>.
                      Na rozdiel od prvého autora predpokladal, že <span>bicykle na stojane</span> sa budú rádovo v hodinách meniť a označil
                      ich oranžovou farbou.
                  </p>
              </td>
          </tr>
      </table>

      <div  align="center">
          <a href="annotator.php?lang=sk"><button>Začať maľovať</button></a>
      </div>
      <p class="footer">
          Autori: Martin Veľas <a href="mailto:ivelas@fit.vutbr.cz">ivelas@fit.vutbr.cz</a>,
              Michal Španěl <a href="mailto:spanel@fit.vutbr.cz">spanel@fit.vutbr.cz</a> a
              Adam Herout <a href="mailto:herout@fit.vutbr.cz">herout@fit.vutbr.cz</a>.
          Všetky práva vyhradené.
      </p>
    <?php
            } else {
    ?>
  <body>
      <h1>Annotation tool for marking the object dynamics</h1>
      <div  align="center">
          <p>TODO</p>
          <a href="annotator.php?lang=en"><button>Next</button></a>
      </div>
      <p>
          Created by Martin Veľas <a href="mailto:ivelas@fit.vutbr.cz">ivelas@fit.vutbr.cz</a>,
              Michal Španěl <a href="mailto:spanel@fit.vutbr.cz">spanel@fit.vutbr.cz</a> and
              Adam Herout <a href="mailto:herout@fit.vutbr.cz">herout@fit.vutbr.cz</a>.
          All right reserved.
      </p>
    <?php
            }
        } else {
    ?>
      <div id="lang-switch">
        <table align="center">
            <tr>
                <td colspan="2">Choose the language / Zvoľte jazyk</td>
            </tr>
            <tr>
                <td><a href="?lang=en"><img src="data/en_flag.png"></a></td>
                <td><a href="?lang=sk"><img src="data/sk_flag.png"></a></td>
            </tr>
            <tr>
                <td><a href="?lang=en">English</a></td>
                <td><a href="?lang=sk">Slovensky</a></td>
            </tr>
        </table>
      </div>
    <?php
        }
    ?>
  </body>
</html>
