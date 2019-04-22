<!DOCTYPE html>
<html>
    <head>
        <title>Редактор укр. пр. календаря</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="jsCalStyles.css">
        <script type="text/javascript">
            function switchVis(fmNm) {
                switch (fmNm) {
                    case 1:
                        document.getElementById("stFm").setAttribute("style", "display:none");
                        document.getElementById("dayFm").setAttribute("style", "display:normal");
                        document.getElementById("btnDay").setAttribute("disabled", "");
                        document.getElementById("btnSt").removeAttribute("disabled");
                        break;
                    case 2:
                        document.getElementById("stFm").setAttribute("style", "display:normal");
                        document.getElementById("dayFm").setAttribute("style", "display:none");
                        document.getElementById("btnSt").setAttribute("disabled", "");
                        document.getElementById("btnDay").removeAttribute("disabled");
                        break;
                }
            }
        </script>
        <!--
            *** Редактор даних украіноязичнго православного каленадаря ***
                Created on : 10.04.2019
                Author     : scadl, 
                Editor     : landriy
        -->
    </head>
    <body>
        <div style="text-align: center">

            <h1>Редактор данных украинского пр. календаря</h1>            

            <div class="myForm">
                <?php require "jsCalIO.php" ?>
            </div>

            <?php if (isset($_COOKIE['jsCalcEdit']) || isset($tmlLogin)) { ?>

                <div class="myForm">
                    <input type="button" value="Форма дня" onclick="switchVis(1)" id="btnDay">
                    <input type="button" value="Форма святого" onclick="switchVis(2)" id="btnSt">
                </div>

                <form id="dayFm" action="" method="POST" class="myForm" style="display: <?php isset($_GET['idDay']) ? print('normal') : print('none'); ?>">

                    <input type="hidden" name="ID" value="<?php print($dayForm['id']); ?>">

                    <label for="thedate">Целевая дата в формате ГГГГ-ММ-ДД</label>
                    <input type="text" name="thedate" maxlength="10" class="myEdit" value="<?php print($dayForm['thedate']); ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">

                    <label for="datetext">Святые, и жития</label>
                    <input type="text" name="datetext" maxlength="103" class="myEdit" value="<?php print($dayForm['dateText']); ?>">

                    <label for="dayprizn">Ифнормация о дне</label>
                    <input type="text" name="dayprizn" maxlength="300" class="myEdit" value="<?php print($dayForm['dayprizn']); ?>">

                    <label for="dayinfo">Информация о постах</label>
                    <input type="text" name="dayinfo" maxlength="300" class="myEdit" value="<?php print($dayForm['dayinfo']); ?>">

                    <label for="stdate">Дата_по_старому_стилю</label>
                    <input type="text" name="stdate" maxlength="39" class="myEdit" value="<?php print($dayForm['stdate']); ?>">

                    <input type="submit" style="margin: 5px;" value="<?php print($dayForm['subText']); ?>">
                </form>

                <form id="stFm" action="" method="POST" class="myForm" style="display: <?php isset($_GET['idSt']) ? print('normal') : print('none'); ?>;">

                    <input type="hidden" name="ID" value="<?php print($stForm['id']); ?>">

                    <label for="thedate">Целевая дата в формате ГГГГ-ММ-ДД</label>
                    <input type="text" name="thedate" maxlength="10" class="myEdit" value="<?php print($stForm['thedate']); ?>" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}">

                    <label for="imgurl">Ссылка на икону в формате img/file.ext </label>
                    <input type="text" name="imgurl" maxlength="200" class="myEdit" value="<?php print($stForm['imgurl']); ?>">

                    <label for="thelife">Житие святого</label>
                    <input type="text" name="thelife" class="myEdit" value="<?php print($stForm['thelife']); ?>">

                    <label for="thename">Имя_святого</label>
                    <input type="text" name="thename" maxlength="100" class="myEdit" value="<?php print($stForm['thename']); ?>">

                    <input type="submit" style="margin: 5px;" value="<?php print($stForm['subText']); ?>">
                </form>

                <form action="" method="POST" class="myForm">
                    <input type="hidden" name="uLogout">
                    <input type="submit" value="Покинуть систему">
                </form>

            <?php } else { ?>
                <form action="" method="POST" class="myForm">
                    <label for="uPass">Введите мастер-пароль</label>
                    <input type="password" name="uPass">
                    <input type="submit" value="Войти">
                </form>
            <?php } ?>

        </div>
    </body>
</html>


