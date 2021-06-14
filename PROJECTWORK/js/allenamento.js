function main() {
  fetch("../json/chiamataPOST.json")
  .then(res => res.json())
  .then(data => json = data)
  .then(() => post(json));
}

function post(json){
  var p = JSON.parse(JSON.stringify(json));
  fetch("../json/chiamataAllenamento.json")
  .then(res => res.json())
  .then(data => jsonFile = data)
  .then(() => parser(jsonFile, p));
}


function parser(jsonFile, p) {
  var obj = [];
  for (var i=0; i<jsonFile.length; i++) {
    obj.push(JSON.parse(jsonFile[i]));
  }


  compilaTabella(obj, p);
}

function compilaTabella(obj, p){

  var sheet = getStyleSheet("http://branceschini.hopto.org/css/dieta.css");
  var arrayCaselle = document.querySelectorAll("tbody td");
  var arr = [];

    for(var i=0; i<arrayCaselle.length; i++){
      arrayCaselle[i].className = "hacaricato";
    }
    for (var j=1; j<=8; j++) {
      var x = document.querySelectorAll(".hacaricato:nth-child(" + j + ")");
      var y  = document.querySelectorAll("th:nth-child(" + j +  ")");

      if(p["giorno"].includes(y[0].innerHTML)){
        arr.push(x);
      }
    }
    calcoloSupremo(arr, p , obj);
}

function getStyleSheet(unique_title) {
  for(var i=0; i<document.styleSheets.length; i++) {
    var sheet = document.styleSheets[i];
    if(sheet.href == unique_title) {
      return sheet;
    }
  }
}




function calcoloSupremo(arr, p , obj) {


var randomPetto = random(Object.keys(obj[0]["exercises"]));
var randomDorso = random(Object.keys(obj[1]["exercises"]));
var randomGambe = random(Object.keys(obj[2]["exercises"]));
var randomSpalle = random(Object.keys(obj[3]["exercises"]));
var randomTricipiti = random(Object.keys(obj[4]["exercises"]));
var randomBicipiti = random(Object.keys(obj[5]["exercises"]));
var randomAddome = random(Object.keys(obj[6]["exercises"]));



console.log(obj);

  if(p["tipo"] == "mono"){
    if(arr.length == 1){
      var i = 0;
      arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
      arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
      arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
      arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
      arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
      arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
      arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];

    }else if(arr.length == 2){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 3){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 4){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 5){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
        }else if(i == 4){
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }
    }
  }else if(arr.length == 6){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
        }else if(i == 4){
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 5){
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 7){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
        }else if(i == 4){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
        }else if(i == 5){
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 6){
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }
      }
    }

  }else if(p["tipo"] == "multi"){
     if(arr.length == 2){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 4){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }
      }
    }
    else if(arr.length == 5){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 4){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }
    }
  }else if(arr.length == 6){
      for(var i=0; i<arr.length; i++){
        if(i==0){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 1){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 2){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }else if(i == 3){
          arr[i][0].innerHTML = obj[0]["exercises"][randomPetto]["Exercise_Name_Complete"];
          arr[i][3].innerHTML = obj[3]["exercises"][randomSpalle]["Exercise_Name_Complete"];
          arr[i][4].innerHTML = obj[4]["exercises"][randomTricipiti]["Exercise_Name_Complete"];
        }else if(i == 4){
          arr[i][1].innerHTML = obj[1]["exercises"][randomDorso]["Exercise_Name_Complete"];
          arr[i][5].innerHTML = obj[5]["exercises"][randomBicipiti]["Exercise_Name_Complete"];
        }else if(i == 5){
          arr[i][2].innerHTML = obj[2]["exercises"][randomGambe]["Exercise_Name_Complete"];
          arr[i][6].innerHTML = obj[6]["exercises"][randomAddome]["Exercise_Name_Complete"];
        }
      }
    }

  }
}

function random(arr) {
  var randomElement = arr[Math.floor(Math.random() * arr.length)];
  return randomElement;
}
