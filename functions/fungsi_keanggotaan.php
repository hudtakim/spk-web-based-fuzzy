<?php
//////Done///////////////////

function getbobot_non_fuzzy($subkrit){
    $bobot = array();
    if($subkrit == "sub1"){
        $sub1=1; $sub2=0; $sub3=0; $sub4=0; $sub5=0;
        array_push($bobot, $sub1); array_push($bobot, $sub2);array_push($bobot, $sub3);array_push($bobot, $sub4);array_push($bobot, $sub5);
        return $bobot;
    }
    if($subkrit == "sub2"){
        $sub1=0; $sub2=1; $sub3=0;$sub4=0;$sub5=0;
        array_push($bobot, $sub1); array_push($bobot, $sub2);array_push($bobot, $sub3);array_push($bobot, $sub4);array_push($bobot, $sub5);
        return $bobot;
    }
    if($subkrit == "sub3"){
        $sub1=0; $sub2=0; $sub3=1;$sub4=0;$sub5=0;
        array_push($bobot, $sub1); array_push($bobot, $sub2);array_push($bobot, $sub3);array_push($bobot, $sub4);array_push($bobot, $sub5);
        return $bobot;
    }
    if($subkrit == "sub4"){
        $sub1=0; $sub2=0; $sub3=0;$sub4=1;$sub5=0;
        array_push($bobot, $sub1); array_push($bobot, $sub2);array_push($bobot, $sub3);array_push($bobot, $sub4);array_push($bobot, $sub5);
        return $bobot;
    }
    if($subkrit == "sub5"){
        $sub1=0; $sub2=0; $sub3=0;$sub4=0;$sub5=1;
        array_push($bobot, $sub1); array_push($bobot, $sub2);array_push($bobot, $sub3);array_push($bobot, $sub4);array_push($bobot, $sub5);
        return $bobot;
    }
}

function getbobot_fuzzy5($value, $subkrit, $sub1, $sub2, $sub3, $sub4, $sub5){
    $bobot = array();
    if($subkrit == "sub1"){
        if($value <= $sub1){
            $bobot = 1; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($sub2 - $value)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= 0;
            return $bobot;
        }
    }
    if($subkrit == "sub2"){
        if($value <= $sub1 || $value >= $sub3){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($value - $sub1)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= ($sub3 - $value)/($sub3-$sub2);
            return $bobot;
        }
    }
    if($subkrit == "sub3"){
        if($value <= $sub2 || $value >= $sub4){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub2 && $value <= $sub3){
            $bobot= ($value - $sub2)/($sub3-$sub2);
            return $bobot;
        } else {
            $bobot= ($sub4 - $value)/($sub4-$sub3);
            return $bobot;
        }
    }
    if($subkrit == "sub4"){
        if($value <= $sub3 || $value >= $sub5){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub3 && $value <= $sub4){
            $bobot= ($value - $sub3)/$sub4-$sub3;
            return $bobot;
        } else {
            $bobot= ($sub5-$value)/($sub5-$sub4);
            return $bobot;
        }
    }
    if($subkrit == "sub5"){
        if($value <= $sub4){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub4 && $value <= $sub5){
            $bobot= ($value - $sub4)/($sub5-$sub4);
            return $bobot;
        } else {
            $bobot= 1;
            return $bobot;
        }
    }
}

function getbobot_fuzzy4($value, $subkrit, $sub1, $sub2, $sub3, $sub4){
    $bobot = array();
    if($subkrit == "sub1"){
        if($value <= $sub1){
            $bobot = 1; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($sub2 - $value)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= 0;
            return $bobot;
        }
    }
    if($subkrit == "sub2"){
        if($value <= $sub1 || $value >= $sub3){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($value - $sub1)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= ($sub3 - $value)/($sub3-$sub2);
            return $bobot;
        }
    }
    if($subkrit == "sub3"){
        if($value <= $sub2 || $value >= $sub4){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub2 && $value <= $sub3){
            $bobot= ($value - $sub2)/($sub3-$sub2);
            return $bobot;
        } else {
            $bobot= ($sub4 - $value)/($sub4-$sub3);
            return $bobot;
        }
    }
    if($subkrit == "sub4"){
        if($value <= $sub3){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub3 && $value <= $sub4){
            $bobot= ($value - $sub3)/($sub4-$sub3);
            return $bobot;
        } else {
            $bobot= 1;
            return $bobot;
        }
    }
}

function getbobot_fuzzy3($value, $subkrit, $sub1, $sub2, $sub3){
    $bobot = array();
    if($subkrit == "sub1"){
        if($value <= $sub1){
            $bobot = 1; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($sub2 - $value)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= 0;
            return $bobot;
        }
    }
    if($subkrit == "sub2"){
        if($value <= $sub1 || $value >= $sub3){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($value - $sub1)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= ($sub3 - $value)/($sub3-$sub2);
            return $bobot;
        }
    }
    if($subkrit == "sub3"){
        if($value <= $sub2){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub2 && $value <= $sub3){
            $bobot= ($value - $sub2)/($sub3-$sub2);
            return $bobot;
        } else {
            $bobot= 1;
            return $bobot;
        }
    }
}

function getbobot_fuzzy2($value, $subkrit, $sub1, $sub2){
    $bobot = array();
    if($subkrit == "sub1"){
        if($value <= $sub1){
            $bobot = 1; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($sub2 - $value)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= 0;
            return $bobot;
        }
    }
    if($subkrit == "sub2"){
        if($value <= $sub1){
            $bobot = 0; 
            return $bobot;
        } elseif($value >= $sub1 && $value <= $sub2){
            $bobot= ($value - $sub1)/($sub2-$sub1);
            return $bobot;
        } else {
            $bobot= 1;
            return $bobot;
        }
    }
}
?>

