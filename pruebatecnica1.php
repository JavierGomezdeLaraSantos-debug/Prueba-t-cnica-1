<?php

// Datos usados

// Patata,oi8,oo
// ElMejor,oF8,Fo
// BoLiTa,0123456789,23
// Azul,01,01100
// OtRo,54?t,?4?
// Manolita,kju2aq,u2ka
// PiMiEnTo,_-/.!#,#_



//Se toman los datos del csv

$score = fopen('./puntuacion.csv', 'r');

$lines = fgetcsv($score, 0, ',');


$namesArray = [];
$codificationArray = [];
$scoresArray = [];

//Separo los datos en 3 arrays

while ($lines != false) {

    $namesArray[] = $lines[0];
    $codificationArray[] = $lines[1];
    $scoresArray[] = $lines[2];

    $lines = fgetcsv($score, 0, ',');

}

// echo ("name: " );

// print_r($namesArray);
// echo ("<br>");
// echo ("<br>");
// echo ("code: " );

// print_r($codificationArray);
// echo ("<br>");
// echo ("<br>");
// echo ("score: " );
// print_r($scoresArray);


//Se cierra el fichero

fclose($score);

//Lista con los resultados definitivos
$definitiveList = [];


foreach ($scoresArray as $key => $score) {

    //Parto el string
    $auxString = str_split($score);

    $stringValue = [];

    //Busco la posicion de cada letra del string en el array de codificaciones
    foreach ($auxString as  $splitString) {

        $stringValue[] = array_search($splitString,  str_split($codificationArray[$key]));

    }

    //Hago el cálculo del valor con la fórmula que se da en el enunciado
    $calc = 0;

    foreach ($stringValue as $key2 => $value) {
        
        $calc += $value * pow(strlen($codificationArray[$key]),(count($stringValue)-$key2-1));
        
    }

    // echo ($namesArray[$key] .' || '.$calc);

    //Meto todos los valores en el array definitivo, nombre con la puntuación que le corresponde

    $definitiveList[] = ["name"=>$namesArray[$key], "points" => $calc];


}

//Ordeno los resultados por puntuación en orden descendiente
usort($definitiveList, function($a, $b) {
    return $b['points'] <=> $a['points']; 
});

//Mostrar resultado
foreach ($definitiveList as $table) {
    echo $table['name'].','.$table['points'];
    echo('<br>');
}
?>