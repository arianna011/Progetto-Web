<?php

//stampa una stringa html rappresentante la valutazione in stelle (valutazione in decimi). ritorna false se la valutazione non è disponibile
function toStars(int $rating)
{
    
    if (!isset($rating)) return false;

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



function pagination(int $page, int $total_pages) {
    $display = '';
    $display .= '    <nav aria-label="Page navigation">
                    <ol class="pagination justify-content-end">';
    if($page > 1) {
        $previous = $page - 1;  
        $display .= '<li class="page-item" id="1" ><a class="page-link" > << </a></li>';    
        $display .='  <li class="page-item" id="'.$previous.'" ><a class="page-link" > < </a></li>';
    }
   for($i=1; $i<= $total_pages; $i++) {
        $active_class = "";
        if($i == $page) {
            $active_class = "active";
        }
        if($i == $page-1 || $i == $page || $i == $page+1 || $i == $page+2 || $i == $page-2) {
            $display .= '<li class="page-item '.$active_class.'" id="'.$i.'" ><a class="page-link" >'.$i.'</a></li>';
        }
   }
   if($page < $total_pages) {
        $page++;
        $display .= '<li class="page-item"  id="'.$page.'"><a class="page-link" > > </a></li>';
        $display .= '<li class="page-item" id="'.$total_pages.'" ><a class="page-link" > >> </a></li>';
   }

   $display .='</ol> </nav>';
   return $display;
}


?>


