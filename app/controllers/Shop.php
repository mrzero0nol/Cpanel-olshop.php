<?php

class Shop extends Controller {
    public function detail($slug) {
        $product = $this->model('Product_model')->getProductBySlug($slug);

        if (!$product) {
            header('Location: ' . BASEURL);
            exit;
        }

        $data['title'] = $product['name'];
        $data['product'] = $product;

        $this->view('home/layout/header', $data);
        $this->view('shop/detail', $data);
        $this->view('home/layout/footer');
    }
}
