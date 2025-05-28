<?php

require_once __DIR__ . '/../models/Producto.php';

class ProductoController
{
    private $productoModel;

    public function __construct()
    {
        $this->productoModel = new Producto();
    }

    public function index()
    {
        $productos = $this->productoModel->getAll();
        require __DIR__ . '/../views/productos/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../views/productos/create.php';
    }

    public function store()
    {
        $codigo = $_POST['codigo'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;

        if (!$codigo || !$descripcion) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: " . BASE_URL . "productos/create");
            exit;
        }

        // Verificar si ya existe un producto con el mismo código
        if ($this->productoModel->getByCodigo($codigo)) {
            $_SESSION['error'] = "Ya existe un producto con ese código.";
            header("Location: " . BASE_URL . "productos/create");
            exit;
        }

        $this->productoModel->create($codigo, $descripcion);
        $_SESSION['success'] = "Producto creado correctamente.";
        header("Location: " . BASE_URL . "productos");
    }

    public function edit($id)
    {
        $producto = $this->productoModel->getById($id);
        if (!$producto) {
            http_response_code(404);
            require __DIR__ . '/../views/error/404.php';
            return;
        }

        require __DIR__ . '/../views/productos/edit.php';
    }

    public function update($id)
    {
        $codigo = $_POST['codigo'] ?? null;
        $descripcion = $_POST['descripcion'] ?? null;

        if (!$codigo || !$descripcion) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: " . BASE_URL . "productos/edit/$id");
            exit;
        }

        $productoExistente = $this->productoModel->getByCodigo($codigo);
        if ($productoExistente && $productoExistente['id'] != $id) {
            $_SESSION['error'] = "Ya existe otro producto con ese código.";
            header("Location: " . BASE_URL . "productos/edit/$id");
            exit;
        }

        $this->productoModel->update($id, $codigo, $descripcion);
        $_SESSION['success'] = "Producto actualizado correctamente.";
        header("Location: " . BASE_URL . "productos");
    }

    public function delete($id)
    {
        $this->productoModel->delete($id);
        $_SESSION['success'] = "Producto eliminado correctamente.";
        header("Location: " . BASE_URL . "productos");
    }
}
