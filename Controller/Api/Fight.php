<?php
if(!empty($_POST['attack'])){
  $attack = $_POST['attack'];

  // Search attack on DB

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
