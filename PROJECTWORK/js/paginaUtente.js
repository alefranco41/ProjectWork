function main(flag) {
  var jsonFile;
  fetch("../json/chiamataDieta.json").then(res => res.json())
  .then(data => jsonFile = data)
  .then(() => parser(jsonFile, flag));

}

function parser(jsonFile, flag) {

  var obj = [];
  var titoli = [];
  var arrayCalorie = [];
  var arrayFoto = [];
  var arrayUrl = [];


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
    var ricettaRandom = Math.floor(Math.random() * max);

    console.log(obj[i]["hits"][ricettaRandom]);


    var titolo = obj[i]["hits"][ricettaRandom]["recipe"]["label"];
    titoli.push(titolo);
    var calorie = obj[i]["hits"][ricettaRandom]["recipe"]["calories"] / obj[i]["hits"][ricettaRandom]["recipe"]["yield"];
    arrayCalorie.push(calorie);
    var foto = obj[i]["hits"][ricettaRandom]["recipe"]["image"];
    arrayFoto.push(foto);
    var Url = obj[i]["hits"][ricettaRandom]["recipe"]["url"];
    arrayUrl.push(Url);
  }

  compilaTabella(titoli, arrayCalorie, arrayFoto, arrayUrl,flag);
}

function compilaTabella(t,c,f,u, flag){
  var sheet = getStyleSheet("http://branceschini.hopto.org/css/dieta.css");
  var arrayCaselle = document.querySelectorAll("tbody td");

  if(arrayCaselle.length == t.length){
    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].className = "hacaricato";
      arrayCaselle[i].innerHTML = "<span class = 'testo'>" +"<a href='" + u[i]+ "'>" + "Ricetta: " + t[i] + "<br>" + "Calorie: " + Math.round(c[i]) + "<br>" + "<img src='" + f[i] + "'></img></a></span>";
    }
  }else{
    if(flag == 1){
      for(var i=0; i<arrayCaselle.length; i++){
        arrayCaselle[i].innerHTML = "la ricerca non ha prodotto risultati";
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
