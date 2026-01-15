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
            // CSRF Check
            if (!Csrf::verify($_POST['csrf_token'])) {
                die('Invalid CSRF Token');
            }

            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            $password = $_POST['password'];

            $admin = $this->model('Admin_model')->getAdminByUsername($username);

            if ($admin && password_verify($password, $admin['password'])) {
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                header('Location: ' . BASEURL . '/admin/dashboard');
                exit;
            } else {
                Flasher::setFlash('Login Gagal', 'Username atau Password salah', 'danger');
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
                 // Sanitize simple inputs, but keep JSON raw for banner_image
                 if ($key !== 'banner_image') {
                     $value = htmlspecialchars($value);
                 }
                 $settingsModel->updateSetting($key, $value);
             }
             Flasher::setFlash('Sukses', 'Pengaturan berhasil disimpan', 'success');
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
        unset($_SESSION['admin_id']);
        session_destroy();
        header('Location: ' . BASEURL . '/admin');
        exit;
    }
}
