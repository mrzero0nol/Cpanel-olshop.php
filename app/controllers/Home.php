<?php

class Home extends Controller {
    public function index() {
        $data['title'] = APP_NAME;
        $data['categories'] = $this->model('Category_model')->getAllCategories();

        if (isset($_GET['q'])) {
            $data['products'] = $this->model('Product_model')->searchProducts($_GET['q']);
            $data['is_search'] = true;
            $data['search_query'] = $_GET['q'];
        } else {
            $data['products'] = $this->model('Product_model')->getAllProducts();
            $data['is_search'] = false;
        }

        $settings = $this->model('Settings_model')->getSettings();

        $bannerData = $settings['banner_image'] ?? '["https://via.placeholder.com/800x400"]';
        $banners = json_decode($bannerData, true);

        // Fallback if not valid JSON
        if (!is_array($banners)) {
            $banners = [$bannerData];
        }

        $data['banners'] = $banners;

        $this->view('home/layout/header', $data);
        $this->view('home/index', $data);
        $this->view('home/layout/footer');
    }
}
