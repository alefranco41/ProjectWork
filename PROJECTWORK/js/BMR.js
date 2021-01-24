var metabolismoBasale = 0;
var spanArray = document.getElementsByTagName('span');
var inputArray = document.getElementsByTagName('input');
var allenamento = document.getElementsByName('Allenamento');
var cardio = document.getElementsByName('Cardio');
var pesi = document.getElementsByName('Pesi');
var sesso = "";
var f = "";
var arrayMoltiplicatori = [1.2,1.235,1.27,1.305,1.34,1.375,1.41,1.445,1.48,1.515,1.55,1.585,1.62,1.655,1.69,1.725,1.76,1.795,1.83,1.9];

function bmr() {
//ciao sasso 
  var radios = document.getElementsByName('Sesso');
  for (var i=0; i<radios.length; i++) {
    if (radios[i].checked) {
      sesso = radios[i].value;
    }
  }
  var peso = document.getElementById('Peso').value;
  var altezza = document.getElementById('Altezza').value;
  var eta = document.getElementById('Età').value;
  var massaGrassa = document.getElementById('MassaGrassa').value;
  if(f == "hb"){
    metabolismoBasale = hb(sesso, peso, altezza, eta);
  }else if(f == "rhb"){
    metabolismoBasale = rhb(sesso, peso, altezza, eta);
  }else if(f == "msj"){
    metabolismoBasale = msj(sesso, peso, altezza, eta);
  }else if(f == "km"){
    metabolismoBasale = km(peso, massaGrassa);
  }else if(f == "s"){
    metabolismoBasale = s(sesso, peso, eta);
  }


 calcoloTDEE(metabolismoBasale);

}


function controlloFormula(formula) {
  f = formula;
  valoriDefault();
  if(formula == "km"){
    nascondi([0,2,3]);
    rimuoviDisabled([2,5,6,7,15]);
    aggiungiDisabled([0,1,3,4,8,9,10,11,12,13]);
  }else if(formula == "s"){
    nascondi([2,4]);
    rimuoviDisabled([0,1,2,4,6,7,15]);
    aggiungiDisabled([3,5,8,9,10,11,12,13]);
  }else if(formula == "hb" || formula == "rhb" || formula == "msj"){
    nascondi([4]);
    rimuoviDisabled([0,1,2,3,4,6,7,15]);
    aggiungiDisabled([5,8,9,10,11,12,13]);
  }
}

function controlloAllenamento() {
  if(allenamento[0].checked){
    visualizza([6,8]);
    rimuoviDisabled([8,9,11,12]);
  }else{
    nascondi([6,7,8,9]);
    aggiungiDisabled([8,9,11,12]);
    cardio[1].checked = "true";
    pesi[1].checked = "true";
  }
}

function controlloCardio() {
  if(cardio[0].checked){
    visualizza([7]);
    rimuoviDisabled([10]);
  }else{
    nascondi([7]);
    aggiungiDisabled([10]);
  }
}

function controlloPesi() {
  if(pesi[0].checked){
    visualizza([9]);
    rimuoviDisabled([13]);
  }else{
    nascondi([9]);
    aggiungiDisabled([13]);
  }
}

function valoriDefault() {
  for(var i=0; i<spanArray.length; i++){
    if(i<6) {
      visualizza([i]);
    }
  }
}

function hb(sesso, peso, altezza, eta) {
  if(sesso == "m"){
    return (66.5+(13.75*peso)+(5.003*altezza)-(6.755*eta));
  }else if(sesso == "f"){
    return (655+(9.563*peso)+(1.850*altezza)-(4.676*eta));
  }
}

function rhb(sesso, peso, altezza, eta) {
  if(sesso == "m"){
    return (88.362+(13.397*peso)+(4.799*altezza)-(5.677*eta));
  }else if(sesso == "f"){
    return (447.593+(9.247*peso)+(3.098*altezza)-(4.7*eta));
  }
}

function msj(sesso, peso, altezza, eta) {
  if(sesso == "m"){
    return (5+(10*peso)+(6.25*altezza)-(5*eta));
  }else if(sesso == "f"){
    return (-161+(10*peso)+(6.25*altezza)-(5*eta));
  }
}

function km(peso, massaGrassa) {
 return (370+(21.6*(peso*(1-(massaGrassa/100)))));
}

function s(sesso, peso, eta) {
  if(sesso == "m"){
    if(eta<3){
      return ((59.512 * peso) -30.4);
    }else if(eta>=3 && eta<10){
      return ((22.706 * peso) +504.3);
    }else if(eta>=10 && eta<18){
      return ((17.686 * peso) +658.2);
    }else if(eta>=18 && eta<30){
      return ((15.057 * peso) +692.2);
    }else if(eta>=30 && eta<60){
      return ((11.472 * peso) +873.1);
    }else if(eta>=60){
      return ((11.711 * peso) +587.7);
    }
  }else if(sesso == "f"){
    if(eta<3){
      return ((58.317 * peso) -31.1);
    }else if(eta>=3 && eta<10){
      return ((20.315 * peso) +485.9);
    }else if(eta>=10 && eta<18){
      return ((13.384 * peso) +692.6);
    }else if(eta>=18 && eta<30){
      return ((14.818 * peso) +486.6);
    }else if(eta>=30 && eta<60){
      return ((8.126 * peso) +845.6);
    }else if(eta>=60){
      return ((9.082 * peso) +658.5);
    }
  }
}

function visualizza(a){
  for (var i=0; i<a.length; i++) {
    spanArray[a[i]].style.display = "inline";
  }
}

function nascondi(b){
  for (var i=0; i<b.length; i++) {
    spanArray[b[i]].style.display = "none";
  }
}

function rimuoviDisabled(c){
  for (var i=0; i<c.length; i++) {
    inputArray[c[i]].removeAttribute('disabled');
  }
  document.getElementById('lavoro').removeAttribute('disabled');
}

function aggiungiDisabled(d){
  for (var i=0; i<d.length; i++) {
    inputArray[d[i]].setAttribute('disabled', 'disabled');
  }
}

function calcoloTDEE(metabolismoBasale) {
  var livelloSportivo = null;
  var somma = calcoloGiorniCardio() + calcoloGiorniPesi();
  var attivita = document.getElementById('lavoro').value;

  if(somma < 2){
    livelloSportivo = 1;
  }else if(somma < 4){
    livelloSportivo = 2;
  }
  else if(somma < 6){
    livelloSportivo = 3;
  }
  else if(somma <= 7){
    livelloSportivo = 4;
  }
  else if(somma > 7){
    livelloSportivo = 5;
  }

  var indexMoltiplicatore = ((livelloSportivo * attivita)-1);
  var moltiplicatore = arrayMoltiplicatori[indexMoltiplicatore];
  var TDEE = metabolismoBasale * moltiplicatore;

  document.getElementById('prova').value = TDEE;
}

function calcoloGiorniCardio() {
  GiorniCardio = document.getElementById('GiorniCardio').value;
  if(isNaN(parseInt(GiorniCardio))){
    GiorniCardio = 0;
  }else{
    GiorniCardio = parseInt(GiorniCardio);
  }
  return  GiorniCardio;
}

function calcoloGiorniPesi() {
  GiorniPesi = document.getElementById('GiorniPesi').value;
  if(isNaN(parseInt(GiorniPesi))){
    GiorniPesi = 0;
  }else{
    GiorniPesi = parseInt(GiorniPesi);
  }
  return GiorniPesi;
}
