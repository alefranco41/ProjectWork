function main() {
  var jsonFile;
  fetch("../json/chiamataAllenamento.json").then(res => res.json())
  .then(data => jsonFile = data)
  .then(() => parser(jsonFile));

  

}



function parser(jsonFile) {

  var obj = [];
  for (var i=0; i<jsonFile.length; i++) {
    obj.push(JSON.parse(jsonFile[i]));
  }

  for (var i=0; i<obj.length; i++) {
    console.log(obj[i]);
  }

}
