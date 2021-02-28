function prova() {
  var parsedJSON = JSON.parse(document.getElementById('jsonarray').value);
  for (var i=0; i<parsedJSON.length; i++) {
    var obj = JSON.parse(parsedJSON[i]);
  }
}
