<!DOCTYPE html>
<html>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Source de la page : https://makitweb.com/datatables-ajax-pagination-with-search-and-sort-php/ -->
    <!-- BOOTSTRAP -->
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <!-- /BOOTSTRAP -->

    <!-- JQUERY -->
      <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- /JQUERY -->

    <title>Assignation des prénoms depuis 1900 jusqu'en 2019</title>

    <!-- Activation DATATABLE -->
      <script language="ecmascript" type="text/ecmascript">
        $(document).ready(function(){
          $('#national').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'get_national.php'
              },
              'columns': [
                { data: 'sexe' },
                { data: 'preusuel' },
                { data: 'annais' },
                { data: 'nombre' },
              ]
          });
        });

        $(document).ready(function(){
          $('#departement').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'get_departement.php'
              },
              'columns': [
                { data: 'sexe' },
                { data: 'preusuel' },
                { data: 'annais' },
                { data: 'dpt' },
                { data: 'nombre' },
              ]
          });
        });
      </script>
    <!-- /Activation DATATABLE -->
  </head>

  <body>
    <div>
      <p><h1>Assignation des prénoms depuis 2019</h1></p>
      <p>Conditions portant sur les prénoms retenus :</p>
      <p>
        <ol>      
          <li>Sur la période allant de 1900 à 1945, le prénom a été attribué au moins 20 fois à des personnes de sexe féminin et/ou au moins 20 fois à des personnes de sexe masculin</li>
          <li>Sur la période allant de 1946 à 2019, le prénom a été attribué au moins 20 fois à des personnes de sexe féminin et/ou au moins 20 fois à des personnes de sexe masculin</li>
          <li>Pour une année de naissance donnée, le prénom a été attribué au moins 3 fois à des personnes de sexe féminin ou de sexe masculin</li>
        </ol>
      </p>
      <p>Les effectifs des prénoms ne remplissant pas les conditions 1 et 2 sont regroupés (pour chaque sexe et chaque année de naissance) dans un enregistrement dont le champ prénom (PREUSUEL) prend la valeur «_PRENOMS_RARES_». Les effectifs des prénoms remplissant la condition 2 mais pas la condition 3 sont regroupés (pour chaque sexe et chaque prénom) dans un enregistrement dont le champ année de naissance (ANNAIS) est NULL.</p>
      <p>Le code département 20 est utilisé pour toute la corse, le code département 97 est utilisé pour la Guadeloupe, la Martinique, la Guyane et la Réunion</p>
    </div>
    <div>
      <!-- Tabs navs -->
      <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
        <li class="nav-item" role="presentation">
          <a class="nav-link active" id="ex1-tab-1" data-mbd-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="true">National</a>
        </li>
        <li>
          <a class="nav-link active" id="ex1-tab-2" data-mbd-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Départemental</a>
        </li>
      </ul>
      <!-- /Tabs navs -->

      <!-- Tabs content -->
      <div class="tab-content" id="ex1-content">
        <div class="tab-pane fade show active" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
          <table id="national" class="display datatable">
            <thead>
              <tr>
                <th>Sexe</th>
                <th>Prénom (preusuel)</th>
                <th>Année de naissance (annais)</th>
                <th>Nombre</th>
              </tr>
            </thead>
          </table>
        </div>
        
        <div class="tab-pane fade show active" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
          <table id="departement" class="display datatable">
            <thead>
              <tr>
                <th>Sexe</th>
                <th>Prénom (preusuel)</th>
                <th>Année de naissance (annais)</th>
                <th>Département (dpt)</th>
                <th>Nombre</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
    <!-- /Tabs content -->
  </body>
</html> 
  
