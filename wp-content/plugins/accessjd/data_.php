<?php
function getadm(){
    $bgs = get_users('role=Administrator');
    //print_r($blogusers);
    foreach ($bgs as $user) {
        $adms.= $user->user_email;
      }  
	  return $adms;
}

?>