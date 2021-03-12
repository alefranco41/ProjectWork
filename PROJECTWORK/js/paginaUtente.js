function main() {
  var jsonFile;
  fetch("../json/chiamataAPI.json").then(res => res.json())
  .then(data => jsonFile = data)
  .then(() => parser(jsonFile));

}

function parser(jsonFile) {

  var obj = [];
  var titoli = [];
  var arrayCalorie = [];

  for (var i=0; i<jsonFile.length; i++) {
    obj.push(JSON.parse(jsonFile[i]));
  }

  for (var i=0; i<obj.length; i++) {
    if(obj[i]["count"] == 0){
        break;
    }else if(obj[i]["count"] >= 100){
      var max = 100;
    }else{
      var max = obj[i]["count"];
    }
    console.log(obj[i]);
    var ricettaRandom = Math.floor(Math.random() * max);
    console.log(ricettaRandom);


    var titolo = obj[i]["hits"][ricettaRandom]["recipe"]["label"];
    titoli.push(titolo);
    var calorie = obj[i]["hits"][ricettaRandom]["recipe"]["calories"] / obj[i]["hits"][ricettaRandom]["recipe"]["yield"];
    arrayCalorie.push(calorie);
  }

  compilaTabella(titoli, arrayCalorie);
}

function compilaTabella(t,c){
  var arrayCaselle = document.getElementsByClassName("pasto");
  if(arrayCaselle.length == t.length){
    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].innerHTML = "Ricetta: " + t[i] + "<br>" + "Calorie: " + Math.round(c[i]) + "<br>";
    }
  }else{
    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].innerHTML = "la ricerca non ha prodotto risultati";
    }
  }

  var tabellaPasti = document.getElementById('tabellaPasti');
  var righe = tabellaPasti.rows;

  for (var i=1; i<righe.length; i++) {
    var caselle = righe[i].cells;
    if(i == righe.length-1){
      for(var j=1; j<caselle.length; j++){

      }
    }else{
      for(var j=1; j<caselle.length; j++){

      }
    }

  }

}
