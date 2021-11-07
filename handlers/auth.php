<?php
session_start();

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_POST)) {
        header('Content-Type: application/json');

        $auth = new Auth($_POST['login'], $_POST['password']);
        $errors = $auth->validation();

        if (empty($errors)) {

            $errors = $auth->isUsersExists();

            if (empty($errors)) {

                http_response_code(201);
                echo json_encode([
                    'success' => true
                ]);
                exit();
            }
        }

        http_response_code(422);
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);

        exit();
    }
}

class Auth
{
    public $login;
    public $password;
    
    function __construct($login, $password)
    {
        $this->login = htmlspecialchars(strip_tags($login));
        $this->password = htmlspecialchars(strip_tags($password));
    }
    public function validation()
    {
        $errors = [];

        if(strlen($this->login) == 0)
            $errors[]['login'] = "Заполните поле";

        if(strlen($this->password) == 0)
            $errors[]['password'] = "Заполните поле";

        return $errors;
    }
    public function isUsersExists()
    {
        $errors = [];
        $salt = "";
        $name = "";
        $count = 0;
        $users = json_decode(file_get_contents('bd.json'), true);

        if(empty($users))
        {
            $errors[]['login'] = "Данный пользователь не существует";
            return $errors;
        }

        foreach ($users as $key => $user) {
            if($this->login == $user['login'])
                $count++;
        }
        if($count != 1){
            $errors[]['login'] = "Неверный логин";
            return $errors;
        }

        foreach ($users as $key => $user) {
            if(sha1($this->password . $user['salt']) == $user['password']){
                $salt = $user['salt'];
                $name = $user['name'];
                $count++;
            }
        }
        if($count != 2){
            $errors[]['password'] = "Неверный пароль";
            return $errors;
        }else {
            $_SESSION['IsAuth'] = sha1($this->login . sha1($this->password . $salt));
            $_SESSION['name'] = $name;
            setcookie("Token", sha1($this->login . sha1($this->password . $salt)), time()+3600*3, "/");
        }

        
    }
}

?>