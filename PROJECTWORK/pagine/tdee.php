<?php
  include('../FunzioniPHP/Funzioni.php');
  session_start();
  $msg = "";

  $selected = Array(
      "hb" => " ",
      "rhb" => " ",
      "msj" => " ",
      "km" => " ",
      "s" => " ",
    );

    $selezionato = Array(
        "1" => " ",
        "2" => " ",
        "3" => " ",
        "4" => " "
      );

      $Peso = "";
      $Altezza = "";
      $Eta = "";
      $MassaGrassa = "";
      $GiorniCardio = "";
      $GiorniPesi = "";


  if(array_key_exists("invia", $_POST)){

    if(array_key_exists("formule", $_POST)){
      if($_POST["formule"] == "hb"){
        $selected["hb"] = "selected = 'selected'";
      }else if($_POST["formule"] == "rhb"){
        $selected["rhb"] = "selected = 'selected'";
      }else if($_POST["formule"] == "msj"){
        $selected["msj"] = "selected = 'selected'";
      }else if($_POST["formule"] == "km"){
        $selected["km"] = "selected = 'selected'";
      }else if($_POST["formule"] == "s"){
        $selected["s"] = "selected = 'selected'";
      }
    }
    if(array_key_exists("lavoro", $_POST)){

      if($_POST["lavoro"] == "1"){
        $selezionato["1"] = "selected = 'selected'";
      }else if($_POST["lavoro"] == "2"){
        $selezionato["2"] = "selected = 'selected'";
      }else if($_POST["lavoro"] == "3"){
        $selezionato["3"] = "selected = 'selected'";
      }else if($_POST["lavoro"] == "4"){
        $selezionato["4"] = "selected = 'selected'";
      }
    }

    $_POST['formule'] = "'" . $_POST['formule'] . "'";

    if (!array_key_exists('Sesso', $_POST) && ($_POST["formule"] != "km")) {
    $errori["Sesso"] = "style='color: #f14668';";
    }else{
      $errori["Sesso"] = " ";
    }
    if(!array_key_exists('Peso', $_POST) || (!is_numeric($_POST["Peso"]) || (($_POST["Peso"]<1) || ($_POST["Peso"]>635)))){
      $errori["Peso"] = "is-danger";
      $Peso = "";
    }else{
      $errori["Peso"] = " ";
      if(array_key_exists('Peso', $_POST)){
        $Peso = $_POST["Peso"];
      }
    }
    if(array_key_exists("Altezza", $_POST)){
      if(((($_POST["formule"] != "km") && ($_POST["formule"] != "s")) && (!is_numeric($_POST["Altezza"]) || $_POST["Altezza"] < 50 || $_POST["Altezza"] > 251))){
      $errori["Altezza"] = "is-danger";
      $Altezza = "";
    }else{
      $errori["Altezza"] = " ";
      if(array_key_exists('Altezza', $_POST)){
        $Altezza = $_POST["Altezza"];
      }
    }
    }else{
      $errori["Altezza"] = " ";
      if(array_key_exists('Altezza', $_POST)){
        $Altezza = $_POST["Altezza"];
      }
    }

    if(array_key_exists("Eta", $_POST)){
      if((($_POST["formule"] != "km") && (!is_numeric($_POST["Eta"]) || $_POST["Eta"] < 0 || $_POST["Eta"] > 118))){
        $errori["Eta"] = "is-danger";
        $Eta = "";
      }else{
        $errori["Eta"] = " ";
        if(array_key_exists('Eta', $_POST)){
          $Eta = $_POST["Eta"];
        }
      }
    }else{
      $errori["Eta"] = " ";
      if(array_key_exists('Eta', $_POST)){
        $Eta = $_POST["Eta"];
      }
    }


    if($_POST["MassaGrassa"] == "km"){
      if(!is_numeric($_POST["MassaGrassa"]) || $_POST["MassaGrassa"] < 2 || $_POST["MassaGrassa"] > 80 || !array_key_exists("MassaGrassa", $_POST)){
        $errori["MassaGrassa"] = "is-danger";
        $MassaGrassa = "";
      }else{
        $errori["MassaGrassa"] = " ";
        if(array_key_exists('MassaGrassa', $_POST)){
          $MassaGrassa = $_POST["MassaGrassa"];
        }
      }
    }else{
      $errori["MassaGrassa"] = " ";
      if(array_key_exists('MassaGrassa', $_POST)){
        $MassaGrassa = $_POST["MassaGrassa"];
      }
    }

    if (!array_key_exists('Allenamento', $_POST)) {
    $errori["Allenamento"] = "style='color: #f14668';";
  }else{
    $errori["Allenamento"] = " ";
  }

    if (!array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        $errori["Cardio"] = "style='color: #f14668';";
    }else{
      $errori["Cardio"] = " ";
    }

    if (array_key_exists('Cardio', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Cardio"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniCardio"]) || $_POST["GiorniCardio"] < 0 || $_POST["GiorniCardio"] > 7){
        $errori["GiorniCardio"] = "is-danger";
        $GiorniCardio = "";
      }else{
        $errori["GiorniCardio"] = " ";
        if(array_key_exists('GiorniCardio', $_POST)){
          $GiorniCardio = $_POST["GiorniCardio"];
        }

      }
    }

    if (!array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Allenamento"] == "si"){
        $errori["Pesi"] = "style='color: #f14668';";
    }else{
      $errori["Pesi"] = " ";
    }

    if (array_key_exists('Pesi', $_POST) && array_key_exists('Allenamento', $_POST) && $_POST["Pesi"] == "si" && $_POST["Allenamento"] == "si"){
      if(!is_numeric($_POST["GiorniPesi"]) || $_POST["GiorniPesi"] < 0 || $_POST["GiorniPesi"] > 7){
        $errori["GiorniPesi"] = "is-danger";
        $GiorniPesi = "";
      }else{
        $errori["GiorniPesi"] = " ";
        if(array_key_exists('GiorniPesi', $_POST)){
          $GiorniPesi = $_POST["GiorniPesi"];
        }
      }
    }

    if(!array_key_exists('lavoro', $_POST)){
      $errori["Lavoro"] = "is-danger";
      $Lavoro = "";
    }else{
      $errori["Lavoro"] = " ";
      $Lavoro = $_POST["lavoro"];
    }

    $flag = 0;
    foreach($errori as $key => $value){
      if($errori[$key] != " "){
        $flag = 1;
      }
    }

    if($flag == 0){
      $_SESSION["TDEE"] = round($_POST["TDEE"], 0);
      if(isset($_SESSION['username'])){
        $sql = "UPDATE utente SET TDEE = '{$_SESSION['TDEE']}' WHERE username = '{$_SESSION['username']}' AND password = '{$_SESSION['password']}'";
        eseguiquery($sql);
      }
      header('Location: risultato.php');
    }

	}else{
    $errori = Array(
      "Sesso" => " ",
      "Peso" => " ",
      "Altezza" => " ",
      "Eta" => " ",
      "MassaGrassa" => " ",
      "Allenamento" => " ",
      "Cardio" => " ",
      "GiorniCardio" => " ",
      "Pesi" => " ",
      "GiorniPesi" => " ",
      "lavoro" => " "
    );
  }


 ?>

 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <title>Branceschini N&G</title>

     <link rel="icon" type="image/png" href="https://api.freelogodesign.org/files/8c6d4e06dea54409acd52f811de0d6a1/thumb/logo_200x200.png?v=0" />
     <link rel="preconnect" href="https://fonts.gstatic.com">
     <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet">
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <link rel="stylesheet" href="../docs/css/app.css">
     <link rel="stylesheet" type="text/css" href="../docs/css/main.css">
     <script src='../js/BMR.js' charset='utf-8'></script>
     <link rel='stylesheet' href='../css/indexStyle.css'>
 </head>

 <body onload="controlloFormula(<?php echo $_POST['formule']; ?>)">

     <div id="pageloader" class="pageloader"></div>
     <div id="infraloader" class="infraloader is-active"></div>
     <section class="hero is-fullheight is-default is-bold">

         <nav x-data="initNavbar()" class="navbar is-fresh is-transparent no-shadow" role="navigation"
             aria-label="main navigation">
             <div class="container">
                 <div class="navbar-brand">
                     <a class="navbar-item" href="https://cssninja.io">
                         <img src="https://api.freelogodesign.org/files/8c6d4e06dea54409acd52f811de0d6a1/thumb/logo_200x200.png?v=0">
                     </a>

                     <a @click="openSidebar()" class="navbar-item is-hidden-desktop is-hidden-tablet">
                         <div id="menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: visible;" :class="{
                                 'open': $store.app.isSiderbarOpen,
                                 '': !$store.app.isSiderbarOpen
                             }">
                             <svg width="1000px" height="1000px">
                                 <path class="path1"
                                     d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                                 <path class="path2" d="M 300 500 L 700 500"></path>
                                 <path class="path3"
                                     d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
                             </svg>
                             <button id="menu-icon-trigger" class="menu-icon-trigger"></button>
                         </div>
                     </a>

                     <div class="navbar-burger" @click="openMobileMenu()">
                         <span class="menu-toggle">
                             <span class="icon-box-toggle" :class="{
                                     'active': mobileOpen,
                                     '': !mobileOpen
                                 }">
                                 <span class="rotate">
                                     <i class="icon-line-top"></i>
                                     <i class="icon-line-center"></i>
                                     <i class="icon-line-bottom"></i>
                                 </span>
                             </span>
                     </div>
                 </div>

                 <div id="navbar-menu" class="navbar-menu is-static" :class="{
                         'is-active': mobileOpen,
                         '': !mobileOpen
                     }">

                     <div class="navbar-start">
                         <a @click="openSidebar()" class="navbar-item is-hidden-mobile">
                             <div id="menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: visible;" :class="{
                                     'open': $store.app.isSiderbarOpen,
                                     '': !$store.app.isSiderbarOpen
                                 }">
                                 <svg width="1000px" height="1000px">
                                     <path class="path1"
                                         d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800">
                                     </path>
                                     <path class="path2" d="M 300 500 L 700 500"></path>
                                     <path class="path3"
                                         d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200">
                                     </path>
                                 </svg>
                                 <button id="menu-icon-trigger" class="menu-icon-trigger"></button>
                             </div>
                         </a>
                     </div>

                     <div class="navbar-end">
                         <a href="http://branceschini.hopto.org/pagine/paginaUtente.php" class="navbar-item is-secondary modal-trigger" data-modal="auth-modal">
                             Login
                         </a>
                         <a class="navbar-item" href='http://branceschini.hopto.org/pagine/registrati.php'>
                             <span class="button signup-button rounded secondary-btn raised">
                                 Registrati
                             </span>
                         </a>
                     </div>
                 </div>
             </div>
         </nav>
         <nav x-data="initNavbar()"  x-on:scroll.window="scroll()" id="navbar-clone" class="navbar is-fresh is-transparent" role="navigation" aria-label="main navigation" :class="{
                 'is-active': scrolled,
                 '': !scrolled
             }">
             <div class="container">
                 <div class="navbar-brand">
                     <a class="navbar-item" href="https://cssninja.io">
                         <img src="https://api.freelogodesign.org/files/8c6d4e06dea54409acd52f811de0d6a1/thumb/logo_200x200.png?v=0">
                     </a>

                     <a @click="openSidebar()" class="navbar-item is-hidden-desktop is-hidden-tablet">
                         <div id="menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: visible;" :class="{
                                 'open': $store.app.isSiderbarOpen,
                                 '': !$store.app.isSiderbarOpen
                             }">
                             <svg width="1000px" height="1000px">
                                 <path class="path1" d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                                 <path class="path2" d="M 300 500 L 700 500"></path>
                                 <path class="path3" d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
                             </svg>
                             <button id="menu-icon-trigger" class="menu-icon-trigger"></button>
                         </div>
                     </a>

                     <div class="navbar-burger" @click="openMobileMenu()">
                         <span class="menu-toggle">
                             <span class="icon-box-toggle" :class="{
                                     'active': mobileOpen,
                                     '': !mobileOpen
                                 }">
                                 <span class="rotate">
                                     <i class="icon-line-top"></i>
                                     <i class="icon-line-center"></i>
                                     <i class="icon-line-bottom"></i>
                                 </span>
                             </span>
                         </span>
                     </div>
                 </div>

                 <div id="cloned-navbar-menu" class="navbar-menu is-fixed" :class="{
                         'is-active': mobileOpen,
                         '': !mobileOpen
                     }">

                     <div class="navbar-start">
                         <a @click="openSidebar()" class="navbar-item is-hidden-mobile">
                             <div id="cloned-menu-icon-wrapper" class="menu-icon-wrapper" style="visibility: visible;" :class="{
                                     'open': $store.app.isSiderbarOpen,
                                     '': !$store.app.isSiderbarOpen
                                 }">
                                 <svg width="1000px" height="1000px">
                                     <path class="path1" d="M 300 400 L 700 400 C 900 400 900 750 600 850 A 400 400 0 0 1 200 200 L 800 800"></path>
                                     <path class="path2" d="M 300 500 L 700 500"></path>
                                     <path class="path3" d="M 700 600 L 300 600 C 100 600 100 200 400 150 A 400 380 0 1 1 200 800 L 800 200"></path>
                                 </svg>
                                 <button id="cloned-menu-icon-trigger" class="menu-icon-trigger"></button>
                             </div>
                         </a>
                     </div>

                     <div class="navbar-end">
                         <a href="http://branceschini.hopto.org/pagine/paginaUtente.php" class="navbar-item is-secondary modal-trigger" data-modal="auth-modal">
                             Login
                         </a>
                         <a class="navbar-item" href='http://branceschini.hopto.org/pagine/registrati.php'>
                             <span class="button signup-button rounded secondary-btn raised">
                                 Registrati
                             </span>
                         </a>
                     </div>
                 </div>
             </div>
         </nav>
         <div class="hero-body">
             <div class="container">
               <form method='POST' action='tdee.php'>
                 <div class='field'>
                   <label class='label'>Formula</label>
                     <div class='control'>
                       <div class='select'>
                         <select id='formula' name='formule' onchange='controlloFormula(this.value); classiDefault();'>
                           <option value='hb'  <?php echo $selected["hb"]; ?> >Harris-Benedict</option>
                           <option value='rhb' <?php echo $selected["rhb"]; ?>>Harris-Benedict Revisionata</option>
                           <option value='msj'  <?php echo $selected["msj"]; ?>>Mifflin-St Jeor</option>
                           <option value='km'  <?php echo $selected["km"]; ?>>Katch-McArdle</option>
                           <option value='s'  <?php echo $selected["s"]; ?>>Schofield</option>
                         </select>
                       </div>
                     </div>
                   </div>


                 <div class='campi' id='campi'>
                   <div class='field radioso' <?php echo $errori['Sesso']; ?>>
                     <label class='label'>Sesso</label>
                     <div class='control' >
                       <label class='radio'>
                         <input type='radio' id='maschio' name='Sesso' value='m' disabled='disabled' <?php if (isset($_POST['Sesso']) && $_POST['Sesso'] == 'm') echo ' checked="checked"'; ?>>
                           Maschio
                       </label>

                       <label class='radio'>
                         <input type='radio' id='femmina' name='Sesso' value='f' disabled='disabled' <?php if (isset($_POST['Sesso']) && $_POST['Sesso'] == 'f') echo ' checked="checked"'; ?>>
                           Femmina
                       </label>
                     </div>
                   </div>

                   <div class='field'><label class='label'>Peso</label><input type='text' class='input <?php echo $errori['Peso'];?>' value='<?PHP print $Peso; ?>'  name='Peso' id='Peso' placeholder='Inserisci il tuo peso' disabled='disabled'><br></div>
                   <div class='field'><label class='label'>Altezza</label><input type='text' class='input <?php echo $errori['Altezza']; ?>' value='<?PHP print $Altezza; ?>' name='Altezza' id='Altezza' placeholder='Inserisci la tua altezza' disabled='disabled'><br></div>
                   <div class='field'><label class='label'>Età</label><input type='text' class='input <?php echo $errori['Eta']; ?>' value='<?PHP print $Eta; ?>' name='Eta' id='Età' placeholder='Inserisci la tua età' disabled='disabled'><br></div>
                   <div class='field'><label class='label'>Massa Grassa</label><input type='text' class='input <?php echo $errori['MassaGrassa']; ?>' value='<?PHP print $MassaGrassa; ?>' name='MassaGrassa' id='MassaGrassa' placeholder='Inserisci la tua percentuale di massa grassa' disabled='disabled'><br></div>
                   <div class='field radioso' <?php echo $errori['Allenamento']; ?>>
                      <label class='label'>Allenamento</label>
                      <input type='radio'  id='si' name='Allenamento' value='si' disabled='disabled' onchange='controlloAllenamento()'> Si
                      <input type='radio'  id='no' name='Allenamento' value='no' disabled='disabled' onchange='controlloAllenamento()'> No<br>
                  </div>
                   <div class='field radioso' id='nascosta' <?php echo $errori['Cardio']; ?>>
                     <label class='label'>Cardio</label>
                     <input type='radio'  id='si' name='Cardio' value='si' disabled='disabled' onchange='controlloCardio()'> Si
                     <input type='radio'  id='no' name='Cardio' value='no' disabled='disabled' onchange='controlloCardio()'> No<br>
                   </div>
                   <div class='field' id='nascosta'><label class='label'>Giorni Cardio</label><input type='text' class='input <?php echo $errori['GiorniCardio']; ?>' value='<?PHP print $GiorniCardio; ?>' name='GiorniCardio' id='GiorniCardio' placeholder='Inserisci quanti giorni fai cardio' disabled='disabled'><br> </div>
                   <div class='field radioso' id='nascosta' <?php echo $errori['Pesi']; ?>>
                     <label class='label'>Pesi</label>
                     <input type='radio'  id='si' name='Pesi' value='si' disabled='disabled' onchange='controlloPesi()'> Si
                     <input type='radio'  id='no' name='Pesi' value='no' disabled='disabled' onchange='controlloPesi()'> No<br>
                   </div>
                   <div class='field' ><label class='label'>Giorni Pesi</label><input type='text' class='input <?php echo $errori['GiorniPesi']; ?>' value='<?PHP print $GiorniPesi; ?>' name='GiorniPesi' id='GiorniPesi' placeholder='Inserisci quanti giorni fai pesi' disabled='disabled'><br> </div>


                   <div class='field'>
                     <label class='label'>Stile di vita</label>
                       <div class='control'>
                         <div class='select' >
                           <select class='input <?php echo $errori['Lavoro']; ?>' id='lavoro' name='lavoro' disabled='disabled'>
                             <option value='1' <?php echo $selezionato["1"]; ?>>Sedentario</option>
                             <option value='2' <?php echo $selezionato["2"]; ?>>Leggermente attivo</option>
                             <option value='3' <?php echo $selezionato["3"]; ?>>Moderatamente attivo</option>
                             <option value='4' <?php echo $selezionato["4"]; ?>>Estremamente attivo</option>
                           </select>
                         </div>
                       </div>
                     </div>

                   <input type='hidden' id='TDEE' name='TDEE' value='<?php echo $_POST['formule']; ?>'>

                   <div class='control'>
                     <button class='button is-primary' onclick='bmr()' name='invia'>Invia</button>
                   </div>
               </form>
             </div>
         </div>
       </div>

       <div class="hero-foot mb-20">
           <div class="container">
               <div class="tabs is-centered">
                   <ul>
                       <li><a><img class="partner-logo" src="data:image/png;base64,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"></a></li>
                       <li><a><img class="partner-logo" src="https://developer.edamam.com/images/logo-dev.png"></a></li>
                   </ul>
               </div>
           </div>
       </div>

     </section>


     <section class="section section-light-grey is-medium">
         <div class="container">
             <div class="title-wrapper has-text-centered">
                 <h2 class="title is-2 is-spaced">Entra in contatto con noi</h2>
                 <h3 class="subtitle is-5 is-muted">chiedici ciò che vuoi</h3>
                 <div class="divider is-centered"></div>
             </div>

             <div class="content-wrapper">
                 <div class="columns">
                     <div class="column is-6 is-offset-3">
                         <form>
                             <div class="columns is-multiline">
                                 <div class="column is-6">
                                     <input class="input is-medium" type="text" placeholder="Nome *">
                                 </div>
                                 <div class="column is-6">
                                     <input class="input is-medium" type="text" placeholder="Cognome *">
                                 </div>
                                 <div class="column is-6">
                                     <input class="input is-medium" type="text" placeholder="Email *">
                                 </div>
                                 <div class="column is-6">
                                     <input class="input is-medium" type="email" placeholder="Azienda">
                                 </div>
                                 <div class="column is-12">
                                     <textarea class="textarea" rows="6" placeholder=""></textarea>
                                 </div>
                                 <div class="column is-12">
                                     <div class="form-footer has-text-right mt-10">
                                         <button class="button cta is-large primary-btn form-button raised is-clear">Invia il messaggio</button>
                                     </div>
                                 </div>
                             </div>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
     </section>




     <div id="auth-modal" class="modal">
         <div class="modal-background"></div>
         <div class="modal-content">
             <div class="flex-card auth-card">
                 <div class="tabs-wrapper">
                     <div class="tabs">
                         <ul>
                             <li class="is-active" data-tab="login-tab"><a>Login</a></li>
                             <li data-tab="register-tab"><a>Register</a></li>
                         </ul>
                     </div>
                     <div id="login-tab" class="tab-content is-active">
                         <div class="field">
                             <label>Username</label>
                             <div class="control">
                                 <input type="text" class="input is-medium" placeholder="Enter username">
                             </div>
                         </div>
                         <div class="field">
                             <label>Password</label>
                             <div class="control">
                                 <input type="password" class="input is-medium" placeholder="Enter password">
                             </div>
                         </div>

                         <a class="button is-fullwidth secondary-btn is-rounded raised">Log in</a>
                     </div>
                 </div>
             </div>
         </div>
         <button class="modal-close is-large" aria-label="close"></button>
     </div>







     <footer class="footer footer-dark">
         <div class="container">
             <div class="columns">
                 <div class="column">
                     <div class="footer-logo">
                         <img src="https://api.freelogodesign.org/files/8c6d4e06dea54409acd52f811de0d6a1/thumb/logo_200x200.png?v=0">
                     </div>
                 </div>
                 <div class="column">
                     <div class="footer-column">
                         <div class="footer-header">
                             <h3>Product</h3>
                         </div>
                         <ul class="link-list">
                             <li><a href="#">Discover features</a></li>
                             <li><a href="#">Why choose our Product ?</a></li>
                             <li><a href="#">Compare features</a></li>
                             <li><a href="#">Our Roadmap</a></li>
                             <li><a href="#">Request features</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="column">
                     <div class="footer-column">
                         <div class="footer-header">
                             <h3>Docs</h3>
                         </div>
                         <ul class="link-list">
                             <li><a href="#">Get Started</a></li>
                             <li><a href="#">User guides</a></li>
                             <li><a href="#">Admin guide</a></li>
                             <li><a href="#">Developers</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="column">
                     <div class="footer-column">
                         <div class="footer-header">
                             <h3>Blogroll</h3>
                         </div>
                         <ul class="link-list">
                             <li><a href="#">Latest News</a></li>
                             <li><a href="#">Tech articles</a></li>
                             <li><a href="#">Video Blog</a></li>
                         </ul>
                     </div>
                 </div>
                 <div class="column">
                     <div class="footer-column">
                         <div class="footer-header">
                             <h3>Follow Us</h3>
                             <nav class="level is-mobile">
                                 <div class="level-left">
                                     <a class="level-item" href="https://github.com/#">
                                         <span class="icon">
                                             <ion-icon name="logo-github" size="large"></ion-icon>
                                         </span>
                                     </a>
                                     <a class="level-item" href="https://facebook.com/#">
                                         <span class="icon">
                                             <ion-icon name="logo-facebook" size="large"></ion-icon>
                                         </span>
                                     </a>
                                     <a class="level-item" href="https://google.com/#">
                                         <span class="icon">
                                             <ion-icon name="logo-google" size="large"></ion-icon>
                                         </span>
                                     </a>
                                     <a class="level-item" href="https://linkedin.com/#">
                                         <span class="icon">
                                             <ion-icon name="logo-linkedin" size="large"></ion-icon>
                                         </span>
                                     </a>
                                 </div>
                             </nav>

                             <a href="https://bulma.io" target="_blank">
                                 <img src="../docs/img/logo/made-with-bulma.png" alt="Made with Bulma" width="128" height="24">
                             </a>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </footer>
     <!-- Back To Top Button -->
     <div x-data="initBackToTop()" x-on:scroll.window="scroll($event)" @click="goTop($event)" id="backtotop"><a href="javascript:" :class="{
         'visible': scrolled,
         '': !scrolled
     }"></a></div>    <div x-data="initSidebar()" class="sidebar" :class="{
             'is-active': $store.app.isSiderbarOpen,
             '': !$store.app.isSiderbarOpen
         }">
         <div class="sidebar-header">
             <img src="../docs/img/logo/fresh-square.svg">
             <a @click="closeSidebar()" class="sidebar-close" href="javascript:void(0);"><i data-feather="x"></i></a>
         </div>
         <div class="inner">
             <ul class="sidebar-menu">
                 <li><span class="nav-section-title"></span></li>
                 <li @click="openSidebarMenu($event)" data-menu="sidebar-menu-1" class="have-children" :class="{
                         'active': openedMenu === 'sidebar-menu-1',
                         '': openedMenu != 'sidebar-menu-1'
                     }">
                 <a href="#">
                     <span class="material-icons">apps</span>
                     <span>Servizi</span>
                 </a>
                     <ul x-show.transition="openedMenu === 'sidebar-menu-1'">
                         <li><a href="http://branceschini.hopto.org/pagine/tdee.php">Calcolo Fabbisogno calorico </a></li>
                         <li><a href="http://branceschini.hopto.org/pagine/dieta.php">Calcolo Piano Alimentare</a></li>
                         <li><a href="http://branceschini.hopto.org/pagine/allenamento.php">Calcolo Piano Allenamento</a></li>
                     </ul>
                 </li>
                 <li @click="openSidebarMenu($event)" data-menu="sidebar-menu-2" class="have-children" :class="{
                         'active': openedMenu === 'sidebar-menu-2',
                         '': openedMenu != 'sidebar-menu-2'
                     }">
                     <a href="#">
                         <span class="material-icons">duo</span>
                         <span>Account</span>
                     </a>
                     <ul x-show.transition="openedMenu === 'sidebar-menu-2'">
                         <li><a href="http://branceschini.hopto.org/pagine/paginaUtente.php">Accedi</a></li>
                         <li><a href="http://branceschini.hopto.org/pagine/registrati.php">Registrati</a></li>
                     </ul>
                 </li>
             </ul>
         </div>
     </div>
     <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
     <script src="../docs/js/bundle.js"></script>

 </body>

 </html>
