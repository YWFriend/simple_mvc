<?php

class UsersController extends Controller
{
    public function register()
    {
        $this->_view->set('title', 'Register Form');
        return $this->_view->output();
    }

    public function signIn()
    {
        $this->_view->set('title', 'Login Form');
        return $this->_view->output();
    }

    public function save()
    {
        if (!isset($_POST['userFormSubmit']))
        {
            header('Location: /users/register');
        }

        $errors = array();
        $check = true;

        $name = isset($_POST['name']) ? trim($_POST['name']) : NULL;
        $password = isset($_POST['password']) ? trim($_POST['password']) : NULL;
        $email = isset($_POST['email']) ? trim($_POST['email']) : "";
        $isAdmin = $_POST['isAdmin'];

        if (empty($name))
        {
            $check = false;
            array_push($errors, "Name is required!");
        }
        else if (empty($password))
        {
            $check = false;
            array_push($errors, "Password is required!");
        }
        else if (empty($email))
        {
            $check = false;
            array_push($errors, "E-mail is required!");
        }
        else if (!filter_var( $email, FILTER_VALIDATE_EMAIL ))
        {
            $check = false;
            array_push($errors, "Invalid E-mail!");
        }

        if (!$check)
        {
            $this->_setView('register');
            $this->_view->set('title', 'Invalid form data!');
            $this->_view->set('errors', $errors);
            $this->_view->set('formData', $_POST);
            return $this->_view->output();
        }

        try {

            $contact = new UsersModel();
            $contact->setName($name);
            $contact->setPassword($password);
            $contact->setEmail($email);
            $contact->setIsAdmin($isAdmin);

            if ($contact->checkUser() != 0)
            {
                $this->_setView('register');
                $this->_view->set('title', 'Invalid form data!');
                $this->_view->set('errors', array("Пользователь с таким e-mail уже существует"));
                $this->_view->set('formData', $_POST);
                return $this->_view->output();
            }

            $contact->store();

            $this->_setView('success');
            $this->_view->set('title', 'Store success!');

        } 
        catch (Exception $e) 
        {
            $this->_setView('register');
            $this->_view->set('title', 'There was an error saving the data!');
            $this->_view->set('formData', $_POST);
            $this->_view->set('saveError', $e->getMessage());
        }

        return $this->_view->output();
    }

    public function login()
    {
        if (!isset($_POST['userFormSubmit']))
        {
            header('Location: /users/signin');
        }
        $check = true;
        $password = isset($_POST['password']) ? trim($_POST['password']) : NULL;
        $email = isset($_POST['email']) ? trim($_POST['email']) : "";

        if (empty($password))
        {
            $check = false;
            array_push($errors, "Password is required!");
        }
        else if (empty($email))
        {
            $check = false;
            array_push($errors, "E-mail is required!");
        }
        else if (!filter_var( $email, FILTER_VALIDATE_EMAIL ))
        {
            $check = false;
            array_push($errors, "Invalid E-mail!");
        }
        if (!$check)
        {
            $this->_setView('signin');
            $this->_view->set('title', 'Invalid form data!');
            $this->_view->set('errors', $errors);
            $this->_view->set('formData', $_POST);
            return $this->_view->output();
        }

        try
        {
            $user = new UsersModel;
            $user->setEmail($email);
            $user->setPassword($password);

            $userData = $user->selectUser();
            
            if ($userData) 
            {
                $session = Session::getInstance();
                if ($userData['is_admin'] == 1)
                {
                    $session->role = "admin";
                }
                else $session->role = "user";

                $session->password = $userData['password'];
                $session->username = $userData['name'];
                $session->email = $userData['email'];

                print_r($_SESSION);
                $this->_setView('success');
                $this->_view->set('title', 'Store success!');
            } 
            else 
            {
                $this->_view->set('errors', "Неверные email или пароль");
                return $this->_view->output();
            }
        }
        catch (Exception $e) 
        {
            $this->_setView('signin');
            $this->_view->set('title', 'There was an error saving the data!');
            $this->_view->set('formData', $_POST);
            $this->_view->set('saveError', $e->getMessage());
        }

        return $this->_view->output();
    }
}