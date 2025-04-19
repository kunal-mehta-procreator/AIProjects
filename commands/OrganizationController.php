<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Organization;

class OrganizationController extends Controller
{
    public function actionGenerateSample()
    {
        Organization::generateSampleData();
        echo "Generated 100 sample records.\n";
    }
} 