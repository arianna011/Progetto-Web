<?php

//stampa una stringa html rappresentante la valutazione in stelle (valutazione in decimi). ritorna false se la valutazione non è disponibile
function toStars(int $rating)
{
    
    if (!$rating) return false;

    $display = '';
    for ($i = 1; $i < $rating; $i += 2) {
        $display .= '<i class="bi bi-star-fill"></i>';
    }
    if ($rating % 2 != 0) {
        $display .= '<i class="bi bi-star-half"></i>';
    }
    if ($rating < 9) {
        for ($i = 1; $i < 10 - $rating; $i += 2) {
            $display .= '<i class="bi bi-star"></i>';
        }
    }

    return $display;
}

//dato un array di tag sottoforma di stringa, lo stampa come lista di badge di colore bg
function toBadges($tagArray, string $bg)
{
    $display = "";
    $s = explode(",",substr($tagArray,1,-1));
            foreach($s as $str) {
                if ($str != ""){
                    if($str[0] == '"' && $str[-1] =='"') //rimuove i quotes di postgres (vengono messe su stringhe contenenti whitespace)
                    $str = substr($str,1,-1);
                    $display .= '<span class="badge ' . $bg . ' text-wrap"> '. $str .' </span>';
                }
            }
    return $display;
}

function fromPgArray($pgarraystr){
    return explode(",",substr($pgarraystr,1,-1));
}
?>