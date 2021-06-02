<?php
include("get_xx.php");
$decenie = isset($_GET['decenie']) && $_GET['decenie'] == "1";

if ($decenie == true)
{
  get("dptdec2019");
}
else
{
  get("dpt2019");
}
