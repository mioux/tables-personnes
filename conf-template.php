<?php
  $conf['db_host'] = 'localhost';
  $conf['db_user'] = 'user';
  $conf['db_password'] = 'password';
  $conf['db_name'] = 'prenoms';
  
  $con = mysqli_connect($conf['db_host'],
                        $conf['db_user'],
                        $conf['db_password'],
                        $conf['db_name']);

  if ($con === null)
  {
    die("Connexion à la base de données échouée");
  }