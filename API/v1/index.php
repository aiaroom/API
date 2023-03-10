    <?php

    include_once('config.php');
    include_once('err_handler.php');
    include_once('db_connect.php');
    include_once('functions.php');
    //include_once('find_token.php');


    if((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) #Получаем протокол сайта.
    $protocol="https://";
    else
    $protocol="http://";
    $domain=$_SERVER['SERVER_NAME'];
    $currentUrl=$_SERVER['REQUEST_URI']; 
    $url=$protocol.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
    $new_url = 'http://188.17.157.3/DDPT/Alisa/API/v1/?type=start';

    if ($url == "http://188.17.157.3/DDPT/Alisa/API/v1/"){
        header('Location: '.$new_url);
        }

    if (preg_match_all("/^(start)$/ui", $_GET['type'])) {

        $content = "Для быстрого доступа к нужной функции кликните на неё и при необходимости введите данные в пустующие поля в адрессной строке<br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1/?type=add_creator&first_name=имя&second_name=фамилия&middle_name=отчество'>добавить автора</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=add_type_area&name=имя типа зала'>добавить новый тип зала</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=add_hall&name=id_типа_зала'>добавить зал</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=add_art&name=название_картины&year_create=год создания&creator=id_автора&hall=id_зала'>добавить картину</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=update_area_name&name=новое_имя&name2=старое_имя&id=id_типа_зала'>обновление названия типа зала</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1/?type=update_location_art&hall=id_нового_зала&name=имя_картины&first_name=имя_художника&second_name=фамилия_художника&middle_name=отчество_художника&id=id_картины'>обновление местоположения картины</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=list_art&hall_name=название_зала&first_name=имя_автора&second_name=фамилия_автора&middle_name=отчество автора'>вывод списка картин в зале</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=list_author'>вывод списка художников</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=list_hall_type&name=название_жанра'>вывод списка зала с жанром</a><br>\n
        <a href='http://188.17.157.3/DDPT/Alisa/API/v1?type=ip'>добавление ip собственного устройства</a><br>\n";

	    echo $content;
    }





///добавить автора
    if(preg_match_all("/^(add_creator)$/ui", $_GET['type'])){
        if(!isset($_GET['first_name'])){
            echo ajax_echo(
                "Ошибка!", // Заголовок ответа
                "Вы не указали GET параметр first_name!", // Описание ответа
                true, // Наличие ошибки в ответе
                "ERROR", // Статус ответа
                null // Дополнительные параметры ответа
            );
            exit();
        }
        
        

        $second_name = '';
        if(isset($_GET['second_name'])){
          $second_name = $_GET['second_name'];
        }
        $middle_name = '';
        if(isset($_GET['middle_name'])){
          $middle_name = $_GET['middle_name'];
        }

        
        $query = "INSERT INTO `creaters`(";
        
        if(isset($_GET['first_name']) && iconv_strlen($_GET['first_name']) > 0){
            $query .= "`first_name`,";
        }
       
            $query .= " `second_name`, ";
        


        
            $query .= " `middle_name`";
        

        
        $query .= ") VALUES (";
        
        if(isset($_GET['first_name']) && iconv_strlen($_GET['first_name']) > 0){
            $query .= "'".$_GET['first_name']."',";
        }
        if(iconv_strlen($second_name) == 0 || preg_match_all("/^(NULL)$/ui", $second_name)){
            $query .= "NULL ,";
        } else {
            $query .= "'".$second_name."',";
        } 

        if(iconv_strlen($middle_name) == 0 || preg_match_all("/^(NULL)$/ui", $middle_name)){
            $query .= "NULL";
        } else {
            $query .= "'".$middle_name."'";
        }     
        $query .= ");";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                "ERROR",
                null
            );
            exit();
        }
        
        $ip = get_ip();
        $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
        $res=mysqli_query($connection, $query);

        echo ajax_echo(
            "Уcпех!",
            "Новый автор добавлен в бд!",
            false,
            "SUCCESS",
            null
        );
        exit();
    }

  // добавить тип зала  
    else if(preg_match_all("/^(add_type_area)$/ui", $_GET['type'])){
        if(!isset($_GET['name'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр name!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        $query = "INSERT INTO `type_area`(`name`) VALUES ('".$_GET['name']."')";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                "ERROR",
                null
            );
            exit();
        }
        
        $ip = get_ip();
        $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
        $res=mysqli_query($connection, $query);


        echo ajax_echo(
            "Уcпех!",
            "Новый тип зала добавлен в бд!",
            false,
            "SUCCESS",
            null
        );
        exit();
    }

    // добавить зал
    else if(preg_match_all("/^(add_hall)$/ui", $_GET['type'])){
        if(!isset($_GET['name'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр id типа зала!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        $query = "INSERT INTO `hall`(`area_id`) VALUES ('".$_GET['name']."')";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                "ERROR",
                null
            );
            exit();
        }
        
        $ip = get_ip();
        $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
        $res=mysqli_query($connection, $query);

        echo ajax_echo(
            "Уcпех!",
            "Новый зал добавлен в бд!",
            false,
            "SUCCESS",
            null
        );
        exit();
    }

//добавить картину
    else if(preg_match_all("/^(add_art)$/ui", $_GET['type'])){
        if(!isset($_GET['name'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр name!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        if(!isset($_GET['year_create'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр year_create!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        if(!isset($_GET['creater'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр creater!",
                true,
                "ERROR",
                null
            );
            exit();
        }


        if(!isset($_GET['hall'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр hall!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        

        $query = "INSERT INTO `art`(`name`,`year_create`,`creater_id`,`hall_id`) VALUES ('".$_GET['name']."','".$_GET['year_create']."',
        '".$_GET['creater']."','".$_GET['hall']."')";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                "ERROR",
                null
            );
            exit();
        }
        
        $ip = get_ip();
        $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
        $res=mysqli_query($connection, $query);

        echo ajax_echo(
            "Уcпех!",
            "Новая картина добавлена в бд!",
            false,
            "SUCCESS",
            null
        );
        exit();
    }    


    // обнавить название типа зоны

    else if(preg_match_all("/^(update_area_name)$/ui", $_GET['type'])){


        if(!isset($_GET['name'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр name!",
                true,
                "ERROR",
                null
            );
            exit();
        } else{
            $name =  $_GET['name'];
        }

        
        $name2 = '';
        if(isset($_GET['name2'])){
          $name2 = $_GET['name2'];
        }
        $area_id = '';
        if(isset($_GET['id'])){
          $area_id = $_GET['id'];
        }


        if(!isset($_GET['name2']) && !isset($_GET['id'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр name2 или id!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        

        $query = "UPDATE `type_area` SET `name`= '" .$name. "' WHERE ";   
        if(iconv_strlen($name2) > 0 ){
            $query .= " `name`= '".$name2."' ";
        }
        if(iconv_strlen($name2) > 0 && iconv_strlen($area_id) > 0 ){
            $query .= " AND ";
        }

        if(iconv_strlen($area_id) > 0){
            $query .= " `id`='".$area_id."'";
        }     
        $query .= ";";

        $res_query = mysqli_query($connection, $query);

        if(!$res_query){
            echo ajax_echo(
                "Ошибка!",
                "Ошибка в запросе!",
                true,
                "ERROR",
                null
            );
            exit();
        }
        
        $ip = get_ip();
        $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
        $res=mysqli_query($connection, $query);

        echo ajax_echo(
            "Уcпех!",
            "Название зоны изменено в бд!",
            false,
            "SUCCESS",
            null
        );
        exit();
    } 

//обнавить местоположение картины 2
else if(preg_match_all("/^(update_location_art)$/ui", $_GET['type'])){
    if(!isset($_GET['hall'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали Get параметр hall!",
            true,
            "ERROR",
            null
        );
        exit();
    }



    $id = '';
    if(isset($_GET['id'])){
      $id = $_GET['id'];
    }

        $name = '';
        if(isset($_GET['name'])){
          $name = $_GET['name'];
        }


        $first_name = '';
        if(isset($_GET['first_name'])){
          $first_name = $_GET['first_name'];
        }
        $second_name = '';
        if(isset($_GET['second_name'])){
          $second_name = $_GET['second_name'];
        }
        $middle_name = '';
        if(isset($_GET['middle_name'])){
          $middle_name = $_GET['middle_name'];
        }

        $query = "UPDATE `art` INNER JOIN `creaters` on `art`.`creater_id` = `creaters`.`id` SET `hall_id`= '" . $_GET['hall'] . "'";
        
        

        $query .= " WHERE ";
        if (iconv_strlen($name) > 0 ) {
            $query .= " `name`= '".$name."'";
        } 
        if (iconv_strlen($name) > 0 && (iconv_strlen($first_name) > 0 || iconv_strlen($second_name) > 0 ||(iconv_strlen($middle_name) > 0 ) )) {
            $query .= " AND ";

        }


        if (isset($first_name) && iconv_strlen($first_name) > 0) {
            $query .= "`creaters`.`first_name`= '" . $_GET['first_name']. "'";
        } else {
            $query .= "";
        }

        if (iconv_strlen($second_name) == 0 || preg_match_all("/^(NULL)$/ui", $second_name)) {
            $query .= " ";
        } 
        else {
            $query .= " AND `creaters`.`second_name`='" .$second_name. "'";
        }


        if (iconv_strlen($middle_name) == 0 || preg_match_all("/^(NULL)$/ui", $middle_name)) {
            $query .= " ";
        } 
        else {
            $query .= " AND `creaters`.`middle_name`='" .$middle_name. "'";
        }


        if (iconv_strlen($id) > 0 && (iconv_strlen($first_name) > 0 || iconv_strlen($second_name) > 0 || (iconv_strlen($middle_name) > 0 ) || iconv_strlen($name) > 0)) {
            $query .= " AND ";

        }

        if (iconv_strlen($id) == 0 || preg_match_all("/^(NULL)$/ui", $id)) {
            $query .= " ";
        } 
        else {
            $query .= " `art`.`id`= '" .$id. "'";
        }


       

        $query .= ";";



        // WHERE `name` = '".$_GET['name']."'";

    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }
    
    $ip = get_ip();
    $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
    $res=mysqli_query($connection, $query);

    echo ajax_echo(
        "Уcпех!",
        "Местоположение картины изменено в бд!",
        false,
        "SUCCESS",
        null
    );
    exit();
} 







// список картин в зале
if(preg_match_all("/^(list_art|lst_art)$/ui", $_GET['type'])){
    $hall_name = '';
    if(isset($_GET['hall_name'])){
      $hall_name = $_GET['hall_name'];
    }
    $first_name = '';
    if(isset($_GET['first_name'])){
      $first_name = $_GET['first_name'];
    }
    $second_name = '';
    if(isset($_GET['second_name'])){
      $second_name = $_GET['second_name'];
    }
    $middle_name = '';
    if(isset($_GET['middle_name'])){
      $middle_name = $_GET['middle_name'];
    }
    
    $query = "SELECT `art`.`name` FROM `art` ";
       
            $query .= "INNER JOIN `creaters` on `art`.`creater_id` = `creaters`.`id`";
        
        $query .= " WHERE ";
        if (iconv_strlen($hall_name) == 0 || preg_match_all("/^(NULL)$/ui", $hall_name)) {
            $query .= "";
        } else{
            $query .=" `hall_id`= '".$hall_name."' ";
        }
        
        //
        if (((iconv_strlen($first_name) == 0 || preg_match_all("/^(NULL)$/ui", $first_name)) && 
        (iconv_strlen($second_name) == 0 || preg_match_all("/^(NULL)$/ui", $second_name)) && 
         (iconv_strlen($middle_name) == 0 || preg_match_all("/^(NULL)$/ui", $middle_name))) Xor  
         (iconv_strlen($hall_name) == 0 || preg_match_all("/^(NULL)$/ui", $hall_name)))
         {
            $query .= "";
        } else {
            $query .= " AND ";
        }
            //
            if (isset($first_name) && iconv_strlen($first_name) > 0) {
                $query .= "`creaters`.`first_name`= '" . $_GET['first_name'] . "'";
            } else {
                $query .= "";
            }

            if (iconv_strlen($second_name) == 0 || preg_match_all("/^(NULL)$/ui", $second_name)) {
                $query .= " ";
            } else {
                $query .= "AND `creaters`.`second_name`='" . $second_name . "'";
            }

            if (iconv_strlen($middle_name) == 0 || preg_match_all("/^(NULL)$/ui", $middle_name)) {
                $query .= " ";
            } else {
                $query .= "AND `creaters`.`middle_name`='" . $middle_name . "'";
            }
  
            $query .= ";";
       
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }

    $ip = get_ip();
    $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
    $res=mysqli_query($connection, $query);

    echo ajax_echo(
        "Уcпех!",
        "Список картин",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}



// список художников
if(preg_match_all("/^(list_author)$/ui", $_GET['type'])){

    $query = "SELECT `first_name`, `second_name`, `middle_name` FROM `creaters` WHERE 1";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }

    $ip = get_ip();
    $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
    $res=mysqli_query($connection, $query);

    echo ajax_echo(
        "Уcпех!",
        "Список продукции",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}



//Вывод списка залов с жанром

if(preg_match_all("/^(list_hall_type)$/ui", $_GET['type'])){

    if(!isset($_GET['name'])){
        echo ajax_echo(
            "Ошибка!",
            "Вы не указали Get параметр name!",
            true,
            "ERROR",
            null
        );
        exit();
    }
    $query = "SELECT `hall`.`id` FROM `hall` INNER JOIN `type_area` on `hall`.`area_id` = `type_area`.`id` WHERE `type_area`.`name`= '".$_GET['name']."'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!",
            "Ошибка в запросе!",
            true,
            "ERROR",
            null
        );
        exit();
    }

    $arr_res = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_res, $row);
    }

    $ip = get_ip();
    $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
    $res=mysqli_query($connection, $query);

    echo ajax_echo(
        "Уcпех!",
        "Список продукции",
        false,
        "SUCCESS",
        $arr_res
    );
    exit();
}

if(preg_match_all("/^(users_ip|ip)$/ui", $_GET['type'])){
    $ip = get_ip();
    $query = "INSERT INTO ip_logs (`ip`,`action`) VALUES ('".$ip."','".$_GET['type']."')";
    $res=mysqli_query($connection, $query);

    $query2 = "SELECT COUNT(id) FROM `ip_logs` WHERE ip = '".$ip."'";
    $res2 =  mysqli_query($connection, $query2);
    
    $arr_res = array();
    $rows = mysqli_num_rows($res2);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res2);
        array_push($arr_res, $row);
    }
    
    echo ajax_echo(
        "Уcпех!",
        "Список продукции",
        false,
        "SUCCESS",
        $arr_res
    );
    //echo strval($res2);
    exit();
}
