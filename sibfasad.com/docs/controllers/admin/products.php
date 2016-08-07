<?php

namespace Controllers\Admin;

class products extends \Controllers\skeleton {

    public function actionindex() {
        global $dbLink;

        $active = 'products';
        $search = '';
        $whereClause = '';
        $products = $brands = [];
        $brandIds = [-1 => -1];

        // Fetch products
        if (
            isset($_REQUEST['search']) &&
            $_REQUEST['search'] !== ''
        ) {
            $search = $_REQUEST['search'];
            $_search = trim(mysqli_real_escape_string($dbLink, $search));
            $whereClause = 'WHERE name LIKE \'%' . $search . '%\'';
            unset($_search);
        }
        $sql = 'SELECT *
            FROM products
            ' . (($whereClause !== '') ? $whereClause : '') . '
            ORDER BY name ASC';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $row['properties'] = unserialize($row['properties']);
            $row['prices']     = unserialize($row['prices']);

            $brandIds[$row['brand']] = $row['brand'];
            $products[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Fetch brands information
        $sql = 'SELECT *
            FROM brands
            WHERE id IN (' . implode(', ', $brandIds) . ')';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[$row['id']] = $row;
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        $this->template->assign('products', $products);
        $this->template->assign('brands', $brands);
        $this->template->assign('search', $search);
        $this->template->assign('active', $active);
        $this->setTemplate('products.tpl');
    }

    public function actionmanage($args) {
        global $dbLink;

        $active = 'products';
        $id = (int) array_shift($args);

        // Prepare variables
        $brands = $categories = $vehicles = $oils = $fluids = [];

        // Get brands array
        $sql = 'SELECT *
            FROM brands';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $brands[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get categories array
        $sql = 'SELECT *
            FROM categories';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $categories[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get vehicles array
        $sql = 'SELECT *
            FROM vehicle_types';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $vehicles[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get oils array
        $sql = 'SELECT *
            FROM motor_oil_types';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $oils[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        // Get fluids array
        $sql = 'SELECT *
            FROM transmission_types';
        $result = mysqli_query($dbLink, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            $fluids[$row['id']] = $row['name'];
            unset($row);
        }
        mysqli_free_result($result);
        unset($sql, $result);

        if (isset($_REQUEST['name']) === true) {

            // Add new product

            // Prepare varibles
            $data = [
                'name'   => '',
                'brand'  => 0,

                'oil_type'          => 0,
                'vehicle_type'      => 0,
                'transmission_type' => 0,

                'category'     => 0,
                'margins'      => '',
                'margins_full' => '',
                'descr'        => '',
                'packages'     => [],
                'prices'       => [],
                'properties'   => [],
                'values'       => [],
                'active'       => 0,
                'priority'     => 0,
            ];
            foreach ($data as $fieldName => $fieldDefault) {
                if (isset($_REQUEST[$fieldName]) === true) {
                    $data[$fieldName] = $_REQUEST[$fieldName];
                    settype($data[$fieldName], gettype($fieldDefault));
                }
                unset($fieldName, $fieldDefault);
            }

            // Combine packages and prices
            $_packages = [];
            foreach ($data['packages'] as $priceId => $priceValue) {
                $_packages[$priceValue] = str_replace(' ', '', $data['prices'][$priceId]);
                unset($priceId, $priceValue);
            }
            $data['prices'] = $_packages;
            unset($_packages, $data['packages']);

            // Combine properties and values
            $_properties = [];
            foreach ($data['properties'] as $propertyId => $propertyValue) {
                $_properties[$propertyValue] = $data['values'][$propertyId];
                unset($propertyId, $propertyValue);
            }
            $data['properties'] = $_properties;
            unset($_properties, $data['values']);

            // Upload photo if submited
            $productPhoto = '';
            if (
                isset($_FILES['productPhoto']['tmp_name']) === true &&
                $_FILES['productPhoto']['tmp_name'] !== ''
            ) {
                $data['photo'] = sha1(time()) . '.jpg';
                move_uploaded_file($_FILES['productPhoto']['tmp_name'], UPLOADS_PATH . '/productPhotos/' . $data['photo']);
            }

            // Update or insert new product
            if ($id === 0) {
                // Insert
                $sqlFields = $sqlValues = [];
                foreach ($data as $fieldName => $fieldValue) {
                    // Serialize arrays
                    if (gettype($fieldValue) === 'array') {
                        $fieldValue = serialize($fieldValue);
                    }

                    $sqlFields[] = $fieldName;
                    $sqlValues[] = mysqli_real_escape_string($dbLink, $fieldValue);

                    unset($fieldName, $fieldValue);
                }

                $sql = 'INSERT INTO products (' . implode(', ', $sqlFields) . ')
                    VALUES (\'' . implode('\', \'', $sqlValues) . '\')';

                unset($sqlFields, $sqlValues);
            } else {
                // Update
                $sqlFields = [];
                foreach ($data as $fieldName => $fieldValue) {
                    // Serialize arrays
                    if (gettype($fieldValue) === 'array') {
                        $fieldValue = serialize($fieldValue);
                    }

                    $fieldValue = mysqli_real_escape_string($dbLink, $fieldValue);

                    $sqlFields[] = sprintf(
                        '%1$s = \'%2$s\'',
                        $fieldName,
                        $fieldValue
                    );
                    unset($fieldName, $fieldValue);
                }

                $sql = 'UPDATE products
                    SET ' . implode(', ', $sqlFields) . '
                    WHERE id = ' . $id;

                unset($sqlFields);
            }

            mysqli_query($dbLink, $sql);
            header('location: /admin/products');
            exit;
        }

        $product = [
            'name'   => '',
            'brand'  => 0,

            'oil_type'          => 0,
            'vehicle_type'      => 0,
            'transmission_type' => 0,

            'category'     => 0,
            'margins'      => '',
            'margins_full' => '',
            'descr'        => '',
            'packages'     => [],
            'prices'       => [],
            'properties'   => [],
            'values'       => [],
            'active'       => 1,
            'priority'     => 0,
        ];

        $showVehicle = $showOil = $showFluid = 0;
        if ($id === 0) {
            // Add products

            // Hide proper divs
            $showVehicle = $showOil = 1;

            $this->template->assign('header', 'Добавление продукта');
            $this->setTemplate('productManage.tpl');
            $this->setTitle('Добавление продукта');
        } else {
            // Manage product

            // Check if product exists
            $sql = 'SELECT * FROM products WHERE id = ' . (int) $id;
            $result = mysqli_query($dbLink, $sql);
            if (($product = mysqli_fetch_assoc($result)) === null) {
                $this->setTemplate('error.tpl');
                $this->setHeader('404 Not Found');
                $this->setTitle('Страница не найдена');
            } else {
                $this->template->assign('header', 'Редактирование продукта');
                $this->setTemplate('productManage.tpl');
                $this->setTitle('Редактирование продукта');

                if ($product['category'] == 1) {
                    $showVehicle = $showOil = 1;
                } elseif ($product['category'] == 2) {
                    $showFluid = 1;
                }
                $product['prices'] = unserialize($product['prices']);
                $product['properties'] = unserialize($product['properties']);
            }
        }

        $this->template->assign('product', $product);
        $this->template->assign('brands', $brands);
        $this->template->assign('categories', $categories);
        $this->template->assign('vehicles', $vehicles);
        $this->template->assign('oils', $oils);
        $this->template->assign('fluids', $fluids);

        $this->template->assign('vehicle', $showVehicle);
        $this->template->assign('oil',     $showOil);
        $this->template->assign('fluid',   $showFluid);

        $this->template->assign('active', $active);
    }

    public function actiondelete($args) {
        global $dbLink;

        $id = (int) array_shift($args);

        $sql = 'DELETE FROM products WHERE id =' . $id;
        mysqli_query($dbLink, $sql);

        header('location: /admin/products');
        exit;
    }
}
