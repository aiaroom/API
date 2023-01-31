    <?php
// Я сделал корректный вывод по автору :)
    include_once('config.php');
    include_once('err_handler.php');
    include_once('db_connect.php');
    include_once('functions.php');
    //include_once('find_token.php');

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
        if(iconv_strlen($second_name) == 0 || preg_match_all("/^(NULL)$/ui", $second_name)){
            $query .= " `second_name`, ";
        } 


        if(iconv_strlen($middle_name) == 0 || preg_match_all("/^(NULL)$/ui", $middle_name)){
            $query .= " `middle_name`";
        }

        
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

        

        $query = "INSERT INTO `art`(`name`,`year_create`,`creater`,`hall`) VALUES ('".$_GET['name']."','".$_GET['year_create']."',
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
        }
        
        if(!isset($_GET['name2'])){
            echo ajax_echo(
                "Ошибка!",
                "Вы не указали Get параметр name!",
                true,
                "ERROR",
                null
            );
            exit();
        }

        $area_id = '';
        if(isset($_GET['area_id'])){
          $area_id = $_GET['area_id'];
        }

        $query = "UPDATE `type_area` SET `name`= '".$_GET['name']."' WHERE `name`= '".$_GET['name2']."'";

        if(iconv_strlen($area_id) == 0 || preg_match_all("/^(NULL)$/ui", $area_id)){
            $query .= " ";
        } else {
            $query .= "AND `id`='".$area_id."'";
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

// обнавить местоположение картины
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

    $query = "UPDATE `art` SET `hall_id`= '".$_GET['hall']."' WHERE `name` = '".$_GET['name']."'";

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
                $query .= "AND `creaters`.`second_name`='" . $second_name . "',";
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