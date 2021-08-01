<?php
## Database configuration
require_once('conf.php');
function get($conf, $con)
{

  $conf['DEBUG'] = isset($conf['DEBUG']) && $conf['DEBUG'] != false ? true : false;

  if ( $conf['DEBUG'] == true)
  {
    $ERR = fopen('php://stderr', 'w');

    $CHECK_GET = var_export($_GET, true);
    $CHECK_POST = var_export($_POST, true);

    fwrite($ERR, $CHECK_GET . "\n");
    fwrite($ERR, $CHECK_POST . "\n");
  }

  ## Read value
  $searchValue = $_GET['searchValue'];
  
  ## Search 
  $searchQuery = " ";
  if($searchValue != '')
  {
    $terms = explode(' ', $searchValue);

    foreach ($terms as $term)
    {
      if ($term != '')
      {
        $searchQuery .= " and (preusuel like '".$term."' or 
            annais = '".$term."') ";
      }
    }
  }

  ## Fetch total
  $empQuery = "select max(nombre) as nombre from dpt2019 WHERE 1 ".$searchQuery.";";

  if ( $conf['DEBUG'] == true)
  {
    fwrite($ERR, $empQuery . "\n");
  }
  $empRecords = mysqli_query($con, $empQuery);
  $row = mysqli_fetch_assoc($empRecords);
  $max = $row["nombre"];

  ## Fetch records
  $empQuery = "select dpt, sum(nombre) as nombre from dpt2019 WHERE 1 ".$searchQuery." group by dpt;";

  if ( $conf['DEBUG'] == true)
  {
    fwrite($ERR, $empQuery . "\n");
  }

  $empRecords = mysqli_query($con, $empQuery);
  $data = array();
  $raw = array();

  while ($row = mysqli_fetch_assoc($empRecords)) {
    if ($row["dpt"] == "20")
    {
      $data["2A"] = getColor($max, $row["nombre"], $conf);
      $data["2B"] = getColor($max, $row["nombre"], $conf);

      $raw["2A"] = $row["nombre"];
      $raw["2B"] = $row["nombre"];
    }
    else
    {
        $dpt = $row["dpt"];
        if($dpt < 10)
        {
          $dpt = "0" . $dpt;
        }
        $data[$dpt] = getColor($max, $row["nombre"], $conf);
        $raw[$dpt] = $row["nombre"];
    }
  }
  
  $result = array(
      "MAX" => $max,
      "DATA" => $data,
      "RAW" => $raw
  );

  echo json_encode($result);
}

function getColor($max, $value, $conf)
{
  $green = ceil(255 * $value / $max);
  $red = (255 - $green);
  $color = $red * 256 * 256 + $green * 256;
  return "#" . str_pad(dechex($color), 6, "0", STR_PAD_LEFT);
}

get($conf, $con);