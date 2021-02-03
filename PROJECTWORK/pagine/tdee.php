<?php
  session_start();
  if (array_key_exists("invia", $_POST)) {
    $errori = "";
    if (!array_key_exists('Sesso', $_POST) && ($_POST["formule"] != "km")) {
      $errori .= "Errore sesso <br>";
    }
    if(!is_numeric($_POST["Peso"]) || (($_POST["Peso"]<1) || ($_POST["Peso"]>635))){
      $errori .= "Errore peso <br>";
    }
    if((($_POST["formule"] != "km") && ($_POST["formule"] != "s")) && (!is_numeric($_POST["Altezza"]) || $_POST["Altezza"] < 50 || $_POST["Altezza"] > 251)){
      $errori .= "Errore altezza <br>";
    }
    if(($_POST["formule"] != "km") && (!is_numeric($_POST["Eta"]) || $_POST["Eta"] < 0 || $_POST["Eta"] > 118)){
      $errori .= "Errore Età <br>";
    }
    if(($_POST["formule"] == "km") && (!is_numeric($_POST["MassaGrassa"]) || $_POST["MassaGrassa"] < 2 || $_POST["MassaGrassa"] > 80)){
      $errori .= "Errore Massa Grassa <br>";
    }
    if (!array_key_exists('Allenamento', $_POST)) {
      $errori .= "Errore Allenamento <br>";
    }

    if (!array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        $errori .= "Errore Cardio <br>";
    }

    if (array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Cardio"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniCardio"]) || $_POST["GiorniCardio"] < 0 || $_POST["GiorniCardio"] > 7){
        $errori .= "Errore Giorni Cardio <br>";
      }
    }

    if (!array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        $errori .= "Errore Pesi <br>";
    }

    if (array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Pesi"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniPesi"]) || $_POST["GiorniPesi"] < 0 || $_POST["GiorniPesi"] > 7){
        $errori .= "Errore Giorni Pesi <br>";
      }
    }
    if($_POST["lavoro"] == "default"){
      $errori .= "Errore lavoro <br>";
    }

    if($errori == ""){
      $_SESSION["TDEE"] = $_POST["TDEE"];
      header('Location: risultato.php');
    }
	}else{
    $errori = "";
  }






$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>

  <head>
    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <script src='../js/BMR.js' charset='utf-8'></script>
    <link rel='stylesheet' href='../css/indexStyle.css'>
  </head>

  <body>
      <div id='errori'>
        $errori
      </div>
      <form method='POST' action='tdee.php'>
        Formula:
        <select id='formula' name='formule' onchange='controlloFormula(this.value);'>
          <option value='default' selected hidden>Seleziona</option>
          <option value='hb'>Harris-Benedict</option>
          <option value='rhb'>Harris-Benedict Revisionata</option>
          <option value='msj'>Mifflin-St Jeor</option>
          <option value='km'>Katch-McArdle</option>
          <option value='s'>Schofield</option>
        </select><br>

        <div class='campi' id='campi'>
          <div class='input'>Sesso:<input type='radio' id='maschio' name='Sesso' value='m' disabled='disabled'> Maschio <input type='radio' id='femmina' name='Sesso' value='f' disabled='disabled'> Femmina<br></div>
          <div class='input'>Peso: <input type='text' name='Peso' id='Peso' disabled='disabled'><br></div>
          <div class='input'>Altezza: <input type='text' name='Altezza' id='Altezza' disabled='disabled'><br></div>
          <div class='input'>Età: <input type='text' name='Eta' id='Età' disabled='disabled'><br></div>
          <div class='input'>Massa Grassa: <input type='text' name='MassaGrassa' id='MassaGrassa' disabled='disabled'><br></div>
          <div class='input'>Allenamento:<input type='radio' id='si' name='Allenamento' value='si' disabled='disabled' onchange='controlloAllenamento()'> Si <input type='radio' id='no' name='Allenamento' value='no' disabled='disabled' onchange='controlloAllenamento()'> No<br></div>
          <div class='input'>Cardio:<input type='radio' id='si' name='Cardio' value='si' disabled='disabled' onchange='controlloCardio()'> Si <input type='radio' id='no' name='Cardio' value='no' disabled='disabled' onchange='controlloCardio()'> No<br></div>
          <div class='input'>N° Giorni: <input type='text' name='GiorniCardio' id='GiorniCardio' disabled='disabled'><br> </div>
          <div class='input'>Pesi:<input type='radio' id='si' name='Pesi' value='si' disabled='disabled' onchange='controlloPesi()'> Si <input type='radio' id='no' name='Pesi' value='no' disabled='disabled' onchange='controlloPesi()'> No<br></div>
          <div class='input'>N° Giorni: <input type='text' name='GiorniPesi' id='GiorniPesi' disabled='disabled'><br> </div>
          Stile di vita: <select id='lavoro' name='lavoro' disabled='disabled'>
            <option value='default' selected hidden>Seleziona</option>
            <option value='1'>Sedentario</option>
            <option value='2'>Leggermente attivo</option>
            <option value='3'>Moderatamente attivo</option>
            <option value='4'>Estremamente attivo</option>
          </select><br>
          <input type='hidden' id='TDEE' name='TDEE'>
          <input type='submit' name='invia' onclick='bmr()' disabled='disabled'>
      </form>
    </div>

  </body>
  </html>
";

print($html);


 ?>
