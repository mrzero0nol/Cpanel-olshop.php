<?php

class Product extends Controller {
    public function __construct() {
        if (!isset($_SESSION['admin_logged_in'])) {
            header('Location: ' . BASEURL . '/admin');
            exit;
        }
    }

    public function index() {
        $data['title'] = 'Product Management';
        $data['products'] = $this->model('Product_model')->getAllProducts();
        $this->view('admin/layout/header', $data);
        $this->view('admin/products/index', $data);
        $this->view('admin/layout/footer');
    }

    public function create() {
        $data['title'] = 'Add Product';
        $data['categories'] = $this->model('Category_model')->getAllCategories();
        $this->view('admin/layout/header', $data);
        $this->view('admin/products/create', $data);
        $this->view('admin/layout/footer');
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => $_POST['name'],
                'slug' => $this->slugify($_POST['name']),
                'category_id' => $_POST['category_id'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'original_price' => !empty($_POST['original_price']) ? $_POST['original_price'] : null,
                'is_active' => isset($_POST['is_active']) ? 1 : 0,
                'image' => ''
            ];

            // Image Upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $target_dir = __DIR__ . "/../../public/assets/img/products/";
                if (!file_exists($target_dir)) {
                    mkdir($target_dir, 0777, true);
                }
                $file_extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $file_extension;
                $target_file = $target_dir . $filename;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $data['image'] = $filename;
                }
            }

            if ($this->model('Product_model')->addProduct($data) > 0) {
                Flasher::setFlash('Success', 'Product added successfully', 'success');
                header('Location: ' . BASEURL . '/product');
                exit;
            } else {
                Flasher::setFlash('Error', 'Failed to add product', 'danger');
                header('Location: ' . BASEURL . '/product');
                exit;
            }
        }
    }

    public function stock($id) {
        $data['title'] = 'Manage Stock';
        $data['product'] = $this->model('Product_model')->getProductById($id);
        $data['accounts'] = $this->model('Product_model')->getAccountsByProductId($id);

        $this->view('admin/layout/header', $data);
        $this->view('admin/products/stock', $data);
        $this->view('admin/layout/footer');
    }

    public function addStock() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'product_id' => $_POST['product_id'],
                'account_data' => $_POST['account_data']
            ];

            if ($this->model('Product_model')->addAccount($data) > 0) {
                 Flasher::setFlash('Success', 'Stock added successfully', 'success');
            } else {
                 Flasher::setFlash('Error', 'Failed to add stock', 'danger');
            }
            header('Location: ' . BASEURL . '/product/stock/' . $_POST['product_id']);
            exit;
        }
    }

    // Quick Category Add for simplicity
    public function addCategory() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $data = [
                 'name' => $_POST['name'],
                 'slug' => $this->slugify($_POST['name']),
                 'icon' => '' // Skipping icon upload for now
             ];
             $this->model('Category_model')->addCategory($data);
             header('Location: ' . BASEURL . '/product/create');
        }
    }

    private function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        if (empty($text)) {
            return 'n-a';
        }
        return $text;
    }
}
