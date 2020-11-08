<?php

function makeImageFromName($name){
    $userImage = "";
    $shortName = "";
    $names = explode(" ", $name);
    foreach ($names as $n) {
       $shortName .= $n[0];
    }
    $userImage = '<div class="name-image bg-primary">' .$shortName . '</div>';
    return $userImage;
}
