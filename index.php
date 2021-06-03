<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Source de la page : https://makitweb.com/datatables-ajax-pagination-with-search-and-sort-php/ -->

    <!-- JQUERY -->
      <link href='//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
      <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- /JQUERY -->

    <title>Assignation des prénoms depuis 1900 jusqu'en 2019</title>

    <!-- Activation DATATABLE -->
      <script>
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

        $(document).ready(function(){
          $('#national_decenie').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'get_national.php?decenie=1'
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
          $('#departement_decenie').DataTable({
              'processing': true,
              'serverSide': true,
              'serverMethod': 'post',
              'ajax': {
                  'url':'get_departement.php?decenie=1'
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

        $(document).ready(function() {
          $("#div_departement").hide();
          $("#div_national_decenie").hide();
          $("#div_departement_decenie").hide();

          $("#tab_national").css('font-weight', 'bold');
          $(".datatable").width('100%');
        });

        function hideTab(tab)
        {
          $("#div_" + tab).hide();
          $("#tab_" + tab).css('font-weight', 'normal');
        }

        function showTab(tab)
        {
          hideTab("national");
          hideTab("departement");
          hideTab("national_decenie");
          hideTab("departement_decenie");

          $("#div_" + tab).show();
          $("#tab_" + tab).css('font-weight', 'bold');
        }
      </script>
      <style>
        .tab
        {
          padding: 20px;
          display: inline-block;
          border-top: 1px solid black;
          border-left: 1px solid black;
          border-right: 1px solid black;
          cursor: pointer;
          color: blue;
        }
      </style>
    <!-- /Activation DATATABLE -->
  </head>

  <body>
    <div>
      <h1>Assignation des prénoms depuis 1900 jusqu'en 2019</h1>
      <p>Conditions portant sur les prénoms retenus :</p>
      <ol>
        <li>Sur la période allant de 1900 à 1945, le prénom a été attribué au moins 20 fois à des personnes de sexe féminin et/ou au moins 20 fois à des personnes de sexe masculin</li>
        <li>Sur la période allant de 1946 à 2019, le prénom a été attribué au moins 20 fois à des personnes de sexe féminin et/ou au moins 20 fois à des personnes de sexe masculin</li>
        <li>Pour une année de naissance donnée, le prénom a été attribué au moins 3 fois à des personnes de sexe féminin ou de sexe masculin</li>
      </ol>
      <p>Les effectifs des prénoms ne remplissant pas les conditions 1 et 2 sont regroupés (pour chaque sexe et chaque année de naissance) dans un enregistrement dont le champ prénom (PREUSUEL) prend la valeur «_PRENOMS_RARES_». Les effectifs des prénoms remplissant la condition 2 mais pas la condition 3 sont regroupés (pour chaque sexe et chaque prénom) dans un enregistrement dont le champ année de naissance (ANNAIS) est NULL.</p>
      <p>Le code département 20 est utilisé pour toute la corse, le code département 97 est utilisé pour la Guadeloupe, la Martinique, la Guyane et la Réunion</p>
      <p>Attention : la recherche se fait désormais sur le terme exact. Toutefois, il est possible de mettre des jokers dans la recherche</p>
      <ul>
        <li>Le signe % correspond à *, soit 0 ou plus caractères. Exemple : <pre>Sylv%</pre> recherche les prénoms commençant par « Sylv » (Sylvain, Sylvette, ...)</li>
        <li>Le signe _ correspond à ?. soit 1 caractère exactement.  Exemple : <pre>_ylvain</pre> recherche les prénoms commençant par une lettre quelconque, puis « ylvain » (Sylvain, Çylvain). La lettre est obligatoire. « Ylvain » ne sera pas trouvé, ni « Jean-
        sylvain »</li>
      </ul>
    </div>

    <div class="tab" id="tab_national" onclick="showTab('national')">National</div>
    <div class="tab" id="tab_departement" onclick="showTab('departement')">Départemental</div>
    <div class="tab" id="tab_national_decenie" onclick="showTab('national_decenie')">National (par décénie)</div>
    <div class="tab" id="tab_departement_decenie" onclick="showTab('departement_decenie')">Départemental (par décénie)</div>

    <div id="div_national">
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

    <div id="div_departement">
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

    <div id="div_national_decenie">
      <table id="national_decenie" class="display datatable">
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

    <div id="div_departement_decenie">
      <table id="departement_decenie" class="display datatable">
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
  </body>
</html>
