<?php
function get($table)
{
  $DEBUG = isset($conf['DEBUG']) && $conf['DEBUG'] != false ? true : false;

  if ($DEBUG == true)
  {
    $ERR = fopen('php://stderr', 'w');
  }
  ## Database configuration
  require_once('conf.php');

  ## Read value
  $draw = $_POST['draw'];
  $row = $_POST['start'];
  $rowperpage = $_POST['length']; // Rows display per page
  $columnIndex = $_POST['order'][0]['column']; // Column index
  $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
  $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
  $searchValue = mysqli_real_escape_string($con,$_POST['search']['value']); // Search value

  ## Search 
  $searchQuery = " ";
  if($searchValue != '')
  {
    $terms = explode(' ', $searchValue);

    foreach ($terms as $term)
    {
      if ($term != '')
      {
        $searchQuery .= " and (preusuel like '%".$term."%' or 
            annais = '".$term."' ";
        if ($table == "dpt2019")
        {
          $searchQuery .= "or dpt = '".$term."' ";
        }
        $searchQuery .= ")";
      }
    }
  }

  ## Total number of records without filtering
  $sel = mysqli_query($con,"select count(*) as allcount from ".$table."");
  $records = mysqli_fetch_assoc($sel);
  $totalRecords = $records['allcount'];

  ## Total number of record with filtering
  $countQuery = "select count(*) as allcount from ".$table." WHERE 1 ".$searchQuery;
  $sel = mysqli_query($con, $countQuery);

  $records = mysqli_fetch_assoc($sel);
  $totalRecordwithFilter = $records['allcount'];

  ## Fetch records
  $empQuery = "select * from ".$table." WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row.",".$rowperpage;

  if ($DEBUG == true)
  {
    fwrite($ERR, $empQuery . "\n");
  }

  $empRecords = mysqli_query($con, $empQuery);
  $data = array();

  while ($row = mysqli_fetch_assoc($empRecords)) {
    $newrow = array( 
      "sexe"=>$row['sexe'],
      "preusuel"=>$row['preusuel'],
      "annais"=>$row['annais'],
      "nombre"=>$row['nombre']
    );

    if ($table == "dpt2019")
    {
      $newrow["dpt"] = $row['dpt'];
    }

    $data[] = $row;
  }


  ## Response
  $response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
  );

  if ($DEBUG == true)
  {
    $message = json_encode($response);
    fwrite($ERR, var_export($message));
    fclose($ERR);
  }
  echo json_encode($response);
}