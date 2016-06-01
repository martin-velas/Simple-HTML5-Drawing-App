<!DOCTYPE html>
<html>
  <head>
    <title>Dynamic objects annotator</title>
    <link rel="stylesheet" type="text/css" href="style.css">
  </head>
  <body>
    <?php
        if(isset($_GET["lang"])) {
            if($_GET["lang"] == "sk") {
    ?>
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
      <h2>Stručný návod:</h2>
      
      <div  align="center">
          <a href="annotator.php?lang=sk"><button>Začať maľovať</button></a>
      </div>
      <p>
          Autori: Martin Veľas <a href="mailto:ivelas@fit.vutbr.cz">ivelas@fit.vutbr.cz</a>, 
              Michal Španěl <a href="mailto:spanel@fit.vutbr.cz">spanel@fit.vutbr.cz</a> a 
              Adam Herout <a href="mailto:herout@fit.vutbr.cz">herout@fit.vutbr.cz</a>.
          Všetký práva vyhradené.
      </p>
    <?php
            } else {
    ?>
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
