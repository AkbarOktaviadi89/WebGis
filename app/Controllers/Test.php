<?php
// Create a simple test controller to check database connection
// Save this as app/Controllers/Test.php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->query('SELECT 1');
            $result = $query->getResult();
            
            if ($result) {
                return "Database connection successful!";
            } else {
                return "Database connection failed!";
            }
        } catch (\Exception $e) {
            return "Database error: " . $e->getMessage();
        }
    }
}