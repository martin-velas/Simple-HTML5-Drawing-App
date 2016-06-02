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
          Cieľom výskumu je zistiť, ako ľudia vnímajú dynamiku jednotlivých objektov 
          v rôznych kontextoch a situáciách. Pre tento účel bol vytvorený jednoduchý 
          grafický nástroj, pomocou ktorého môžete vyznačiť štetcom jednotlivé objekty 
          a farebne rozlíšiť dynamiku objektu - t.j. ja aký čas sa objekt už pravdepodobne 
          nebude nachádzať v scéne.
      </p>
      <h2>Ukážka nástroja:</h2>
      <div>
          <img style="width: 100%;" src="tool-demo.png"/>
      </div>
      <h2>Niekoľko príkladov:</h2>
      <p>
          Experiment, na ktorom sa podieľate má taktiež zistiť, ako totožne či rôzne ľudia
          vnímajú dynamiku objektov. Z toho plynie, že neexistujú "správne" a "nesprávne"
          odpovede. Pri každom obrázku analyzovanej scény vyjadrite prosím svoj subjektívny názor.
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
              <td><img src="example1.png"/></td>
              <td class="desc">
                  <p>
                        V scéne sa nachádzajú <span>pohyblivé objekty</span>, ktoré pravdepodobne v priebehu 
                        niekoľkých sekúnd nebudú viac na svojom mieste a sú preto označené žltou farbou 
                        (zmiznú do <span>minúty</span>). <span>Zaparkované autá</span> pravdepodobne odídu do <span>1&nbsp;dňa</span>
                        (fialová farba), <span>prenosné dopravné značenie do mesiaca</span> (modrá), ale je pravdepodobné, 
                        že vertikálne značenie, schránku, smetný kôš a pod. nájdeme na svojom mieste aj <span>o rok</span>
                        (zelená farba).
                  </p>
              </td>
          </tr>
          <tr>
              <td colspan="2"><h3>Príklad 2 - rôzne pochopenie objektov v pešej zóne:</h3></td>
          </tr>
          <tr>
              <td><img src="example2.png"/></td>
              <td>
                  <p>
                      Tento príklad demonštruje, ako <span>rôzne</span> môže človek pochopiť totožnú scénu a úlohu objektov v nej.
                  </p>
                  <p>
                      Autor č.1 (vyznačil horný obrázok) považoval za <span>pohyblivé objekty</span> chodcu a cyklistov v pozadí,
                      a preto vyznačil, že <span>do minúty zmiznú</span> (žltá farba). Bielu dodávku pokladal za <span>zásobovanie</span>,
                      ktoré pravdepodobne <span>do hodiny odíde</span> (ružová) a rastlinné dekorácie môžu <span>po odkvitnutí</span> (za cca mesiac) 
                      odstrániť (modrá farba). <span>Ostatné objekty</span> považoval autor za <span>stále</span> (zelená).
                  </p>
                  <p>
                      Autor č.1 (horný spodný obrázok) taktiež odhadoval, že pohyblivé objekty do minúty zmiznú. 
                      Bielu dodávku ale pokladal za <span>údržbu</span> koľajníc a predpokladal, že sa na mieste zdrží <span>niekoľko hodín</span>.
                      Na rozdiel od prvého autora predpokladal, že <span>rastlinné dekorácie</span> budú na mieste <span>zachované</span> a považoval 
                      ich za statické ako aj zvyšné objekty.
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
                <td><a href="?lang=en"><img src="en_flag.png"></a></td>
                <td><a href="?lang=sk"><img src="sk_flag.png"></a></td>
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
