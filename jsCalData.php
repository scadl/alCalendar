<?php

/* 
    Created on : 10.04.2019
    Author     : scadl, 
    Editor     : landriy
*/

// Отображать все ошибки.
// error_reporting(E_ALL);

// Установка локали
setlocale(LC_ALL, 'uk_UA.UTF-8', 'ukr');
//$locale_time = setlocale (LC_TIME, 'ru_RU.UTF-8', 'Rus');

function UkrSymb($unsafe){
    $safeVal = str_ireplace("'", "&rsquo;", $unsafe);
    return $safeVal;
}

if (isset($_GET['dofcet'])){
    // Использвание переданной гет-даты
    $rDate = strtotime($_GET['dofcet']);
    $aDate = $_GET['dofcet'];    
} else {
    // Получение текущей даты на сервере
    $rDate = time();
    $aDate = date("Y-m-d");
}
// подключение к базе
require './jsCalConf.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSW, $DB_NAME);

if ($link) {

    //настройка кирилицы
    mysqli_query($link, "SET sql_mode = ''");
    mysqli_query($link, 'SET NAMES utf8');

    $daysinfo = '';
    $dayspic = '';
    $altpic = '';
    $data = mysqli_query($link, "SELECT * FROM datelinked WHERE thedate='" . $aDate . "';");
    while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
        // Разбор ответа от базы
        $daysinfo .= $row['thename'].", ";
        $dayspic = $row['imgurl'];
        $altpic = $row['thelife'];
    }
    
    // запрос данных из базы
    $data = mysqli_query($link, "SELECT * FROM dateindex WHERE thedate='" . $aDate . "';");
    while ($row = mysqli_fetch_array($data, MYSQLI_ASSOC)) {
        // Разбор ответа от базы
        print("function print_day(){"
                . "document.write('". strftime("%e %B %Y", $rDate) . "р. (" . $row['stdate'] . " ст.сті.), " . UkrSymb(strftime("%A", $rDate)) ."'); "
              ."}");
        print("function print_week(){"
                . "document.write('" . UkrSymb($row['dayprizn']) . "'); "
                ."}");
        print("function print_trapeza(){"
                . "document.write('" . UkrSymb($row['dayinfo']) . "'); "
                ."}");
        print("function print_saints(){"
                . "document.write('" . UkrSymb($daysinfo) . "'); "
                ."}");
        
        $normalPath = '';
        $fixpath = $_SERVER['REQUEST_URI'];
        $fixpath = explode('/', $fixpath);        
        array_pop($fixpath);
        foreach ($fixpath as $value) {
            $normalPath .= $value."/";
        }         
        print("function print_icon(){"
                . "document.write(\"<img src='".$normalPath.$dayspic."' alt='".$altpic."' width='112' border='0'>\"); "
                ."}");
        
        //print( . $row['dayprizn'] .  $row['dayinfo'] );
    }
    
    if(mysqli_num_rows($data)==0){
        print("function print_day(){"
                . "document.write('". strftime("%e %B %Y", $rDate) . "р. <br> Нет данных об указанном дне'); "
              ."}");
    }

} else {
    print(mysqli_connect_error() . PHP_EOL);
}