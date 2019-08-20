<?php
//include('./DBPower.php');


if(!empty($_POST['attack'])){
  $attackId = $_POST['attack'];


  $return[] = array();
  switch ($attack) {
    case 1:
      $return["damage"] = 20;
      echo json_encode($return);
      break;
    case 2:
      $return["damage"] = 40;
      echo json_encode($return);
      break;
    case 3:
      $return["damage"] = 80;
      echo json_encode($return);
      break;
  }
}
else{
    echo "Attaque introuvable";
}

?>
