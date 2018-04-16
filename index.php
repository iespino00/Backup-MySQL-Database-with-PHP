 <?php
 require_once 'models/DBModel.php';
 error_reporting(E_ALL ^ E_WARNING);
 error_reporting(E_ALL ^ E_DEPRECATED);
require_once 'db.php';
require_once 'lib/backup.php';
$controller_db = new DB();
$dataBases= $controller_db->getDataBases();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>BackUp DataBases</title>
	<link rel="stylesheet" href="">
	<meta name="viewport" content="width=1000, initial-scale=1.0, maximum-scale=1.0">
    <!-- Loading Bootstrap -->
  <link href="dist/css/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Loading Flat UI -->
  <link href="dist/css/flat-ui.css" rel="stylesheet">
  <link href="docs/assets/css/demo.css" rel="stylesheet">

      <!--ALERT -->
  <script src="dist_alert/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="dist_alert/sweetalert.css">

   <script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>

    <style>
      .clase_spinner 
        {
        position:absolute;
        top:0px;
        left:0px;
        width:100%;
        height:100%;
        }
    </style>


<script>

  function msg(title)
      {
             swal({
                  title: title,
                  timer: 1900,
                  showConfirmButton: false
               });

           setTimeout(next, 1000);
      }

        function next()
      {
      location.href="index.php";
      }


function mostrarSpinner()
    {
      document.getElementById('div_spinner').style.display='block';
      document.getElementById('contenedor').style.opacity = 0.1;

    }

    function ocultarSpinner()
    {
      document.getElementById('div_spinner').style.display='none';
      document.getElementById('contenedor').style.opacity = 1;

    }

</script>



</head>
<body background="fondo.jpg">

 	 <div class="container" id="contenedor">
	 	<br>
       <form name="descargar" action="index.php"  method='POST' enctype='multipart/form-data'>
          <div class="login-form"> 

          <div class="row">
              <div class="col-xs-6">
                <div class="form-group has-success">
                  <center><label><strong>Usuario</strong></label></center>
                  <input type="text" id="user" name="user" placeholder="Nómbre de Usuario" class="form-control" required />
                  <span class="input-icon fui-check-inverted"></span>
                </div>
                <div class="form-group has-success">
                  <center><label><strong>Password</strong></label></center>
                  <input type="password" id="password" name="password" placeholder="Password" class="form-control" required />
                  <span class="input-icon fui-check-inverted"></span>
                </div>
              </div>
          <div class="col-xs-6">
                  <center><h4 class="demo-panel-title">Selecciona la Base de Datos</h4>
                <select class="form-control select select-primary" id="db" name="db" data-toggle="select" required>
                   <option value="">Selecciona Alguna</option>
                 <?php 
                 foreach ($dataBases as $u)
                              {
                                 echo "<option value='$u->Database' >$u->Database</option>";
                             //   echo $u->Database;
                              }
                  ?>
                </select></center>
           </div> <!-- /.col-xs-3 -->

          </div>

          <a><button type='submit' class="btn btn-block btn-lg btn-inverse" id="respaldar" name="respaldar">Respaldar</button></a>        
    
          </div>
        </form>

    </div>


    <div id="div_spinner" class="clase_spinner" style="display:none;" >
        <center>
          <div style="position:center; top:250px; left:350px; width:200px; height:20px; border:1px ">
            <img src="spinner.gif">
          </div>
        </center>
    </div>
    <script src="dist/js/vendor/jquery.min.js"></script>
    <script src="dist/js/vendor/video.js"></script>
    <script src="dist/js/flat-ui.min.js"></script>
    <script src="docs/assets/js/application.js"></script>	
</body>
<?php

 if( isset($_POST['respaldar']) ) 
   {
  
      echo '<script>
     document.getElementById("div_spinner").style.display="block";
      document.getElementById("contenedor").style.opacity = 0.1;
      </script>';


      /**
       * Define database parameters here
       */
      define("DB_USER", $_REQUEST['user']);
      define("DB_PASSWORD", $_REQUEST['password']);
      define("DB_NAME", $_REQUEST['db']);
      define("DB_HOST", 'localhost');
      define("BACKUP_DIR", 'c:/databases'); // Comment this line to use same script's directory ('.')
      define("TABLES", '*'); // Full backup
      //define("TABLES", 'table1, table2, table3'); // Partial backup
      define("CHARSET", 'utf8');
      define("GZIP_BACKUP_FILE", true);  // Set to false if you want plain SQL backup files (not gzipped)


      // Set script max execution time
      set_time_limit(900); // 15 minutes
      if (php_sapi_name() != "cli") 
          {
          echo '<div style="font-family: monospace;">';
          }

      $backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
      $result = $backupDatabase->backupTables(TABLES, BACKUP_DIR) ? 'OK' : 'KO';
      $backupDatabase->obfPrint('Resultado del Respaldo: ' . $result, 1);

      if (php_sapi_name() != "cli") 
         {
          echo '</div>';

          sleep(4);
           $msgCreateOK = "Respaldo Generado con éxito";
            echo '<script>msg("'.$msgCreateOK.'");</script>'; 
         }



     
        echo '<script>ocultarSpinner();</script>';
   }




?>
</html>