function main() {
  var json;
  fetch("../json/chiamataPOST.json")
  .then(res => res.json())
  .then(data => json = data)
  .then(() => post(json));
}

function post(json){
  var p = JSON.parse(JSON.stringify(json));
  var jsonFile;
  fetch("../json/chiamataAllenamento.json").then(res => res.json())
  .then(data => jsonFile = data)
  .then(() => parser(jsonFile, p));
}


function parser(jsonFile, p) {
  var obj = [];
  for (var i=0; i<jsonFile.length; i++) {
    obj.push(JSON.parse(jsonFile[i]));
  }


  compilaTabella(jsonFile, p);
}

function compilaTabella(jsonFile, p){
  p = converti(p);
  var sheet = getStyleSheet("http://branceschini.hopto.org/css/dieta.css");
  var arrayCaselle = document.querySelectorAll("tbody td");

    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].className = "hacaricato";
    }
    for (var i=1; i<=8; i++) {
      if(p["giorno"].includes(i)){
        var x = document.querySelectorAll(".hacaricato:nth-child(" + i + ")");
        for(var j=0; j<x.length; j++){
          x[j].innerHTML = "<span class = 'testo'>bomba</span>";
        }
      }
    }
}

function getStyleSheet(unique_title) {
  for(var i=0; i<document.styleSheets.length; i++) {
    var sheet = document.styleSheets[i];
    if(sheet.href == unique_title) {
      return sheet;
    }
  }
}

function converti(p){
  for(var i=0; i<p["giorno"].length; i++){
    p["giorno"][i] = parseInt(p["giorno"][i]);
  }
  return p;
}
