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
  var arrayFoto = [];

  for (var i=0; i<jsonFile.length; i++) {
    obj.push(JSON.parse(jsonFile[i]));
  }

  for (var i=0; i<obj.length; i++) {
    console.log(obj[i]);
    if(obj[i]["count"] == 0){
        break;
    }else if(obj[i]["count"] >= 100){
      var max = 100;
    }else{
      var max = obj[i]["count"];
    }
    var ricettaRandom = Math.floor(Math.random() * max);



    var titolo = obj[i]["hits"][ricettaRandom]["recipe"]["label"];
    titoli.push(titolo);
    var calorie = obj[i]["hits"][ricettaRandom]["recipe"]["calories"] / obj[i]["hits"][ricettaRandom]["recipe"]["yield"];
    arrayCalorie.push(calorie);
    var foto = obj[i]["hits"][ricettaRandom]["recipe"]["image"];
    arrayFoto.push(foto);
  }

  compilaTabella(titoli, arrayCalorie, arrayFoto);
}

function compilaTabella(t,c,f){
  var arrayCaselle = document.getElementsByClassName("pasto");
  if(arrayCaselle.length == t.length){
    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].innerHTML = "Ricetta: " + t[i] + "<br>" + "Calorie: " + Math.round(c[i]) + "<br>" + "<img src='" + f[i] + "'></img>";
    }
  }else{
    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].innerHTML = "la ricerca non ha prodotto risultati";
    }
  }
}
