<?php

class Admin extends Controller {
    public function index() {
        if (isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/admin/dashboard');
            exit;
        }
        $this->view('admin/login');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Check against Environment Variables
            if ($username === PAKASIR_PROJECT_SLUG && $password === PAKASIR_API_KEY) {
                $_SESSION['admin_logged_in'] = true;
                header('Location: ' . BASEURL . '/admin/dashboard');
                exit;
            } else {
                Flasher::setFlash('Login Failed', 'Username or Password incorrect', 'danger');
                header('Location: ' . BASEURL . '/admin');
                exit;
            }
        }
    }

    public function dashboard() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }

        $data['title'] = 'Dashboard';
        $data['income_month'] = $this->model('Order_model')->getIncomeReport(date('m'), date('Y'));

        $this->view('admin/layout/header', $data);
        $this->view('admin/dashboard', $data);
        $this->view('admin/layout/footer');
    }

    public function settings() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $settingsModel = $this->model('Settings_model');
             foreach($_POST as $key => $value) {
                 $settingsModel->updateSetting($key, $value);
             }
             Flasher::setFlash('Success', 'Settings updated', 'success');
             header('Location: ' . BASEURL . '/admin/settings');
             exit;
        }

        $data['title'] = 'Settings';
        $data['settings'] = $this->model('Settings_model')->getSettings();

        $this->view('admin/layout/header', $data);
        $this->view('admin/settings/index', $data);
        $this->view('admin/layout/footer');
    }

    public function logout() {
        unset($_SESSION['admin_logged_in']);
        session_destroy();
        header('Location: ' . BASEURL . '/admin');
        exit;
    }
}
