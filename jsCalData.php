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

// Структура ответного массива для JSON
$calResp = array(
    'day' => '',
    'holiday' => '',
    'week' => '',
    'post' => '',
    'trapeza' => '',
    'saints' => '',
    'chten' => '',
    'iconSrc' => '',
    'iconAlt' => ''
);

// подключение к базе
require './jsCalConf.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSW, $DB_NAME);

if ($link) {

    //настройка кирилицы
    mysqli_query($link, "SET sql_mode = ''");
    mysqli_query($link, 'SET NAMES utf8');

    // Заготовка наполняемых структур святых
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
        
        // Разбор ответа от базы, и формирование ответа
        $thisDate = strftime("%e %B %Y", $rDate);               // Дата в человеческом формате
        $thisWeekday = UkrSymb(strftime("%A", $rDate));         // День недели на основе даты
        
        // Собираем строку даты на основе данных из бд и преобразований даты.
        $calResp['day'] = $thisDate . "р. (" . $row['stdate'] . " ст.сті.), " . $thisWeekday; 
        
        // Готовим другие данные на основе ответа бд
        $calResp['week'] = UkrSymb($row['dayprizn']); 
        $calResp['trapeza'] = UkrSymb($row['dayinfo']);
        $calResp['saints'] = UkrSymb($daysinfo);        
        
        $normalPath = '';
        $fixpath = $_SERVER['REQUEST_URI'];
        $fixpath = explode('/', $fixpath);        
        array_pop($fixpath);
        foreach ($fixpath as $value) {
            $normalPath .= $value."/";
        }         
        
        $calResp['iconSrc'] = $normalPath.$dayspic;
        $calResp['iconAlt'] = $altpic;
        
    }
    
    if(mysqli_num_rows($data)==0){
        $calResp['day'] = strftime("%e %B %Y", $rDate) . "р. <br> Нет данных об указанной дне";
    }

} else {
    $calResp['day'] = mysqli_connect_error();
}

print(json_encode($calResp));