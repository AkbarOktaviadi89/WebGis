<?php
namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $this->data['page_title'] = 'Dashboard';
        $this->data['breadcrumb'] = 'Dashboard';
        
        // Data statistik untuk dashboard
        $this->data['stats'] = [
            'total_incidents' => 1024,
            'monthly_incidents' => 87,
            'high_risk_areas' => 12,
            'resolved_cases' => 892
        ];
        
        return view('dashboard/index', $this->data);
    }
}