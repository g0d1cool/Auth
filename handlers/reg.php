<?php
session_start();

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_POST)) {
        header('Content-Type: application/json');

        $reg = new Reg($_POST['login'], $_POST['email'], $_POST['password'], $_POST['confirm_password'], $_POST['name']);
        $errors = $reg->validate();

        if (empty($errors)) {

            if ($reg->create()) {
                http_response_code(201);
                echo json_encode([
                    'success' => true
                ]);
                
                exit();
            }
            http_response_code(500);
            echo json_encode([
                'success' => false
            ]);
            exit();
        }

        http_response_code(422);
        echo json_encode([
            'success' => false,
            'errors' => $errors
        ]);

        exit();
    }
}

class Reg
{

    public $login;
    public $email;
    public $password;
    public $password_confirm;
    public $name;

    public function __construct($login, $email, $password, $password_confirm, $name) {
        $this->login = htmlspecialchars(strip_tags($login));
        $this->email = htmlspecialchars(strip_tags($email));
        $this->password = htmlspecialchars(strip_tags($password));
        $this->password_confirm = htmlspecialchars(strip_tags($password_confirm));
        $this->name = htmlspecialchars(strip_tags($name));
    }


    function validate()
    {
        $errors = [];
        $l = 0;
        $e = 0;
        $users = json_decode(file_get_contents('bd.json'), true);
        if(empty($users)){
            return false;
        }

        foreach ($users as $key => $user) {
            $login = $user['login'];
            $email = $user['email'];

            if($this->login == $login)
                $l++;
            if($this->email == $email)
                $e++;
        }


        if(strlen($this->login) == 0){
            $errors[]['login'] = "Заполните поле";
        }
        else if($l > 0){
            $errors[]['login'] = "Данный логин уже занят";
        }
    	else if(strlen($this->login) < 6){
    		$errors[]['login'] = "Длинна логина должна быть минимум 6 символов";
        }

    	if(strlen($this->password) == 0){
            $errors[]['password'] = "Заполните поле";
        }
        else if (!preg_match('/([0-9]+[a-z]+)|([a-z]+[0-9]+)/i', $this->password)){
            $errors[]['password'] = "Пароль должен состоять из цифр и букв"; 
        }
        else if(strlen($this->password) < 6){
    		$errors[]['password'] = "Длинна пароля должна быть минимум 6 символов";
        }
        else if($this->password != $this->password_confirm){
            $errors[]['confirm_password'] = "Пароли не совпадают";
        }

        if(strlen($this->password_confirm) == 0){
            $errors[]['confirm_password'] = "Заполните поле";
        }

    	if(strlen($this->email) == 0){
            $errors[]['email'] = "Заполните поле";
        }
        else if($e > 0){
            $errors[]['email'] = "Данная почта уже занята";
        }
        else if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    		$errors[]['email'] = "Почта указана не верно";
        }

    	if(strlen($this->name) == 0){
            $errors[]['name'] = "Заполните поле";
        }
        else if(strlen($this->name) < 2){
    		$errors[]['name'] = "Имя должно состоять минимум из двух букв";
        }
    	else if(preg_match('/[^а-яА-Яa-zA-Z]/', $this->name)){
    		$errors[]['name'] = "Имя должно состоять только из букв";
        }

    	if(count($errors) > 0){
            return $errors;
        }     
    }

    function getRandString($num)
    {
        $letter = range('a', 'z');
        $number = range(0, 9);

        $letter = implode('', $letter);
        $letter = $letter.strtoupper($letter).implode('', $number);

        $randStr = '';
        for ($i = 0; $i < $num; $i++)
            $randStr .= $letter[rand(0, strlen($letter) - 1)];
        
        return $randStr;
    }

    function create() 
    {
    	$users = file_get_contents("bd.json", true);
    	$salt = $this->getRandString(rand(10,30));
        $values = array(
            "login" => $this->login, 
            "password" => sha1($this->password . $salt), 
            "email" => $this->email, 
            "name" => $this->name,
            "salt" => $salt
        );

        $value = json_encode($values);
        if(!empty($users))
        	$users = trim($users, ']') . ",\n" . $value . ']';
        else
        	$users = '[' . $value . ']';

        if(file_put_contents('bd.json', $users))
        {
            $_SESSION['IsAuth'] = sha1($this->login . sha1($this->password . $salt));
            $_SESSION['name'] = $this->name;
            setcookie("Token", sha1($this->login . sha1($this->password . $salt)), time()+3600*3, "/");
            return true;
        }
        else
            return false;
    }
}
?>