<?php
/* @var $this yii\web\View */

$this->title = 'Admin Dashboard';
?>

<div class="admin-dashboard">
    <h1><?= $this->title ?></h1>
    
    <div class="dashboard-content">
        <div class="dashboard-card">
            <h3>Welcome to Admin Dashboard</h3>
            <p>This is your admin control panel. Use the navigation menu on the left to access different sections.</p>
        </div>
    </div>
</div>

<style>
.admin-dashboard {
    padding: 20px;
}

.dashboard-content {
    margin-top: 20px;
}

.dashboard-card {
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.dashboard-card h3 {
    margin-top: 0;
    color: #333;
}
</style> 