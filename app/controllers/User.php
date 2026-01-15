<?php

class User extends Controller {
    public function index() {
        if (!isset($_SESSION['user_logged_in'])) {
            $this->login();
            return;
        }

        $data['title'] = 'Saya';
        $data['user'] = $this->model('User_model')->getUserById($_SESSION['user_id']);

        $this->view('home/layout/header', $data);
        $this->view('user/index', $data); // Profile page
        $this->view('home/layout/footer');
    }

    public function login() {
        if (isset($_SESSION['user_logged_in'])) {
             header('Location: ' . BASEURL . '/user');
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $loggedInUser = $this->model('User_model')->login($email, $password);
            if ($loggedInUser) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $loggedInUser['id'];
                $_SESSION['user_name'] = $loggedInUser['name'];
                header('Location: ' . BASEURL . '/user');
                exit;
            } else {
                Flasher::setFlash('Error', 'Invalid Email or Password', 'danger');
            }
        }

        $data['title'] = 'Login';
        $this->view('home/layout/header', $data);
        $this->view('user/login', $data);
        $this->view('home/layout/footer');
    }

    public function register() {
         if (isset($_SESSION['user_logged_in'])) {
             header('Location: ' . BASEURL . '/user');
             exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'phone' => $_POST['phone']
            ];

            if ($this->model('User_model')->findUserByEmail($data['email'])) {
                 Flasher::setFlash('Error', 'Email already registered', 'danger');
            } else {
                if ($this->model('User_model')->register($data)) {
                    Flasher::setFlash('Success', 'Registered successfully. Please login.', 'success');
                    header('Location: ' . BASEURL . '/user/login');
                    exit;
                } else {
                    Flasher::setFlash('Error', 'Registration failed', 'danger');
                }
            }
        }

        $data['title'] = 'Register';
        $this->view('home/layout/header', $data);
        $this->view('user/register', $data);
        $this->view('home/layout/footer');
    }

    public function logout() {
        unset($_SESSION['user_logged_in']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        session_destroy();
        header('Location: ' . BASEURL . '/user/login');
        exit;
    }

    public function assets() {
        if (!isset($_SESSION['user_logged_in'])) {
            header('Location: ' . BASEURL . '/user/login');
            exit;
        }

        $data['title'] = 'My Assets';
        $data['assets'] = $this->model('Product_model')->getAssetsByUserId($_SESSION['user_id']);

        $this->view('home/layout/header', $data);
        $this->view('user/assets', $data);
        $this->view('home/layout/footer');
    }
}
