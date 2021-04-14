<?php
  include('../FunzioniPHP/Funzioni.php');
  session_start();
  if (array_key_exists("invia", $_POST)) {
    $errori = array();
    if (!array_key_exists('Sesso', $_POST) && ($_POST["formule"] != "km")) {
      array_push($errori, "Sesso");
    }
    if(!array_key_exists('Peso', $_POST) || (!is_numeric($_POST["Peso"]) || (($_POST["Peso"]<1) || ($_POST["Peso"]>635)))){
      array_push($errori, "Peso");
    }
    if(!array_key_exists('Altezza', $_POST) || ((($_POST["formule"] != "km") && ($_POST["formule"] != "s")) && (!is_numeric($_POST["Altezza"]) || $_POST["Altezza"] < 50 || $_POST["Altezza"] > 251))){
      array_push($errori, "Altezza");
    }
    if(!array_key_exists('Eta', $_POST) || (($_POST["formule"] != "km") && (!is_numeric($_POST["Eta"]) || $_POST["Eta"] < 0 || $_POST["Eta"] > 118))){
      array_push($errori, "Eta");
    }
    if(($_POST["formule"] == "km") && (!is_numeric($_POST["MassaGrassa"]) || $_POST["MassaGrassa"] < 2 || $_POST["MassaGrassa"] > 80)){
      array_push($errori, "MassaGrassa");
    }
    if (!array_key_exists('Allenamento', $_POST)) {
    array_push($errori, "Allenamento");
    }

    if (!array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        array_push($errori, "Cardio");
    }

    if (array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Cardio"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniCardio"]) || $_POST["GiorniCardio"] < 0 || $_POST["GiorniCardio"] > 7){
        array_push($errori, "GiorniCardio");
      }
    }

    if (!array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        array_push($errori, "Pesi");
    }

    if (array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Pesi"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniPesi"]) || $_POST["GiorniPesi"] < 0 || $_POST["GiorniPesi"] > 7){
        array_push($errori, "GiorniPesi");
      }
    }
    if(!array_key_exists('Lavoro', $_POST) || $_POST["lavoro"] == "default"){
      array_push($errori, "Lavoro");
    }

    if(empty($errori)){
      $_SESSION["TDEE"] = round($_POST["TDEE"], 0);
      if(isset($_SESSION['username'])){
        $sql = "UPDATE utente SET TDEE = '{$_SESSION['TDEE']}' WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'";
        eseguiquery($sql);
      }
      header('Location: risultato.php');
    }
	}else{
    if(isset($_SESSION['username'])){
      $errori = "Benvenuto {$_SESSION['username']}, inserisci i tuoi dati per scoprire il tuo TDEE";
    }else{
      $errori = "Benvenuto utente, inserisci i tuoi dati per scoprire il tuo TDEE";
    }

  }

print_r($errori);




$html = "<!DOCTYPE html>
  <html lang='en' dir='ltr'>

  <head>




    <meta charset='utf-8'>
    <title>ProjectWork</title>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>
    <script src='../js/BMR.js' charset='utf-8'></script>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bulma@0.9.2/css/bulma.min.css'>
    <link rel='stylesheet' href='../css/indexStyle.css'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
  </head>

  <body>

  <nav class='level'>
    <p class='level-item has-text-centered'>
      <a class='link is-info'>Home</a>
    </p>
    <p class='level-item has-text-centered'>
      <a class='link is-info'>Menu</a>
    </p>
    <p class='level-item has-text-centered'>

    </p>
    <p class='level-item has-text-centered'>
      <a class='link is-info'>Reservations</a>
    </p>
    <p class='level-item has-text-centered'>
      <a class='link is-info'>Contact</a>
    </p>
  </nav>
      <div id='errori' class='has-text-weight-bold'>

      </div>
      <form method='POST' action='tdee.php'>
        <div class='field'>
          <label class='label'>Formula</label>
            <div class='control'>
              <div class='select'>
                <select id='formula' name='formule' onchange='controlloFormula(this.value);'>
                  <option value='default' selected hidden>Seleziona</option>
                  <option value='hb'>Harris-Benedict</option>
                  <option value='rhb'>Harris-Benedict Revisionata</option>
                  <option value='msj'>Mifflin-St Jeor</option>
                  <option value='km'>Katch-McArdle</option>
                  <option value='s'>Schofield</option>
                </select>
              </div>
            </div>
          </div>


        <div class='campi' id='campi'>
          <div class='field'>
            <label class='label'>Sesso</label>
            <div class='control'>
              <label class='radio'>
                <input type='radio' id='maschio' name='Sesso' value='m' disabled='disabled'>
                  Maschio
              </label>

              <label class='radio'>
                <input type='radio' id='femmina' name='Sesso' value='f' disabled='disabled'>
                  Femmina
              </label>
            </div>
          </div>

          <div class='field'><label class='label'>Peso</label><input type='text' class='input' name='Peso' id='Peso' placeholder='Inserisci il tuo peso' disabled='disabled'><br></div>
          <div class='field'><label class='label'>Altezza</label><input type='text' class='input' name='Altezza' id='Altezza' placeholder='Inserisci la tua altezza' disabled='disabled'><br></div>
          <div class='field'><label class='label'>Età</label><input type='text' class='input' name='Eta' id='Età' placeholder='Inserisci la tua età' disabled='disabled'><br></div>
          <div class='field'><label class='label'>Massa Grassa</label><input type='text' class='input' name='MassaGrassa' id='MassaGrassa' placeholder='Inserisci la tua percentuale di massa grassa' disabled='disabled'><br></div>
          <div class='field'><label class='label'>Allenamento</label><input type='radio' id='si' name='Allenamento' value='si' disabled='disabled' onchange='controlloAllenamento()'> Si <input type='radio' id='no' name='Allenamento' value='no' disabled='disabled' onchange='controlloAllenamento()'> No<br></div>
          <div class='field' id='nascosta'><label class='label'>Cardio</label>Cardio:<input type='radio' id='si' name='Cardio' value='si' disabled='disabled' onchange='controlloCardio()'> Si <input type='radio' id='no' name='Cardio' value='no' disabled='disabled' onchange='controlloCardio()'> No<br></div>
          <div class='field' id='nascosta'><label class='label'>Giorni Cardio</label><input type='text' class='input' name='GiorniCardio' id='GiorniCardio' placeholder='Inserisci quanti giorni fai cardio' disabled='disabled'><br> </div>
          <div class='field' id='nascosta'><label class='label'>Pesi</label><input type='radio' id='si' name='Pesi' value='si' disabled='disabled' onchange='controlloPesi()'> Si <input type='radio' id='no' name='Pesi' value='no' disabled='disabled' onchange='controlloPesi()'> No<br></div>
          <div class='field' ><label class='label'>Giorni Pesi</label><input type='text' class='input' name='GiorniPesi' id='GiorniPesi' placeholder='Inserisci quanti giorni fai pesi' disabled='disabled'><br> </div>


          <div class='field'>
            <label class='label'>Stile di vita</label>
              <div class='control'>
                <div class='select'>
                  <select id='lavoro' name='lavoro' disabled='disabled'>
                    <option value='default' selected hidden>Seleziona</option>
                    <option value='1'>Sedentario</option>
                    <option value='2'>Leggermente attivo</option>
                    <option value='3'>Moderatamente attivo</option>
                    <option value='4'>Estremamente attivo</option>
                  </select>
                </div>
              </div>
            </div>

          <input type='hidden' id='TDEE' name='TDEE'>

          <div class='control'>
            <button class='button is-primary' onclick='bmr()' name='invia'>Invia</button>
          </div>
      </form>
    </div>

  </body>
  </html>
";

print($html);


 ?>
