<?php

/* 
    Created on : 10.04.2019
    Author     : scadl, 
    Editor     : landriy
*/

//Функция "печатает" таблицы с текстом изи базы и кнопкой вызова редактора
function PrintEditableData($link, $phID, $tbName, $title, $textInd){
        print("<hr>");
        print("<h3>".$title."</h3>");
        print("<table width='100%'>");
        $mResult = mysqli_query($link, 'SELECT * FROM '.$tbName.';');
        while ($row = mysqli_fetch_array($mResult, MYSQLI_NUM)) {
            print("<tr>"
                    . "<td>" . $row[1] . "</td>"
                    . "<td>" . $row[$textInd] . "</td>"
                    . "<td>"
                    . "<form action='' method='get'>"
                    . "<input type='hidden' name='".$phID."' value='" . $row[0] . "'>"
                    . "<input type='submit' value='Редактировать'>"
                    . "</form>"
                    . "</td>"
                    . "</tr>");
        }
        print("</table>");
}

// Скелет значений форм.
$dayForm = array(
    'id' => -1,
    'thedate' => '',
    'dateText' => '',
    'dayinfo' => '',
    'dayprizn' => '',
    'stdate' => '',
    'subText' => 'Добавить'
);
$stForm = array(
    'id' => -1,
    'thedate' => '',
    'imgurl' => '',
    'thelife' => '',
    'thename' => '',
    'subText' => 'Добавить'
);

// подключение к базе и настройкам
require './jsCalConf.php';
$link = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSW, $DB_NAME);
//настройка кирилицы
mysqli_query($link, "SET sql_mode = ''");
mysqli_query($link, 'SET NAMES utf8');

// Проверка пароля и вход
if (isset($_POST['uPass'])) {
    if ($_POST['uPass'] == $MPASS) {
        $tmlLogin = true;
        setcookie('jsCalcEdit', 1, time() + 60 * 60 * 24 * 10);
    } else {
        print('<spann class="Err">Не верный пароль</span>');
    }
}

// Выход из системы
if (isset($_POST['uLogout'])) {
    unset($_COOKIE['jsCalcEdit']);
    setcookie('jsCalcEdit', 1, time() - 1);
}

if ($link) {
    print("<div class='OK'>БД подлючена успешно</div>");

    //Пишем данные дня
    if (isset($_POST['datetext'])) {
        
        // ID - скрытое поле формы, заполняемое только при редактировании
        if($_POST['ID'] > 0){
            // Изменяем данные в базе
            $mResult = mysqli_query($link, 'UPDATE dateindex '
                    . 'SET thedate=DATE("' . $_POST['thedate'] . '"), dateText="' . $_POST['datetext'] . '", '
                    . 'dayinfo="' . $_POST['dayinfo'] . '", dayprizn="' . $_POST['dayprizn'] . '", stdate="' . $_POST['stdate'] . '" '
                    . 'WHERE id='.$_POST['ID'].';');
        } else {
            // Добавляем данные в базу
            $mResult = mysqli_query($link, 'INSERT INTO dateindex '
                . '(thedate, dateText, dayinfo, dayprizn, stdate)'
                . ' VALUES (DATE("' . $_POST['thedate'] . '"),'
                . ' "' . $_POST['datetext'] . '", "' . $_POST['dayinfo'] . '", "' . $_POST['dayprizn'] . '", "' . $_POST['stdate'] . '"); ');
        }
        
        if (!$mResult) {
            print("<div class='Err'>Ошибка записи давнных</div>");
        } else {
            print("<div class='OK'>Давные на " . $_POST['thedate'] . " записаны успешно</div>");
        }
    }

    //Пишем данные святого
    if (isset($_POST['thelife'])) {
        
        // ID - скрытое поле формы, заполняемое только при редактировании
        if($_POST['ID'] > 0){
              // Изменяем данные в базе
             $mResult = mysqli_query($link, 'UPDATE datelinked SET '
               . 'thedate=DATE("' . $_POST['thedate'] . '"), imgurl="' . $_POST['imgurl'] . '", '
               . 'thelife="' . $_POST['thelife'] . '", thename="' . $_POST['thename'] . '" '
               . 'WHERE id='.$_POST['ID'].';');
        } else {
            // Добавляем данные в базу
            $mResult = mysqli_query($link, 'INSERT INTO datelinked '
                . '(thedate, imgurl, thelife, thename)'
                . ' VALUES (DATE("' . $_POST['thedate'] . '"),'
                . ' "' . $_POST['imgurl'] . '", "' . $_POST['thelife'] . '", "' . $_POST['thename'] . '"); ');
        }
        
        if (!$mResult) {
            print("<div class='Err'>Ошибка записи давнных</div>");
        } else {
            print("<div class='OK'>Давные на " . $_POST['thedate'] . " записаны успешно</div>");
        }
    }

    // Выводим таблицы текущих значений
    if (isset($_COOKIE['jsCalcEdit']) || isset($tmlLogin)) {
        PrintEditableData($link, "idDay", "dateindex", "Числа и дни",2);
        PrintEditableData($link, "idSt", "datelinked", "Святые и жития",4);
    }
    
    //Читаем данные для форм если получили ид
    if ( isset($_GET['idDay']) ){
        $mResult = mysqli_query($link, 'SELECT * FROM dateindex WHERE id='.$_GET['idDay'].';');
        while ($row = mysqli_fetch_array($mResult, MYSQLI_ASSOC)) {
            $dayForm = $row;
            $dayForm['subText'] = 'Изменить День';
        }
    }
    if ( isset($_GET['idSt']) ){
        $mResult = mysqli_query($link, 'SELECT * FROM datelinked WHERE id='.$_GET['idSt'].';');
        while ($row = mysqli_fetch_array($mResult, MYSQLI_ASSOC)) {
            $stForm = $row;
            $stForm['subText'] = 'Изменить Святого';
        }
    }
    
} else {
    print("<div class='Err'>Ошибка подключения к БД</div>");
}