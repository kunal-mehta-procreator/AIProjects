<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Organization;
use yii\db\Expression;

class SeedController extends Controller
{
    public function actionOrganizations()
    {
        $organizations = json_decode('[
            {
                "name": "Tech Solutions Inc",
                "email": "contact@techsolutions.com",
                "phone": "212-555-0123",
                "address": "123 Silicon Valley, San Jose, CA 95110"
            },
            {
                "name": "Global Education Center",
                "email": "info@globaledu.org",
                "phone": "415-555-0124",
                "address": "456 Learning Ave, San Francisco, CA 94105"
            },
            {
                "name": "Healthcare Systems Ltd",
                "email": "support@healthsys.com",
                "phone": "650-555-0125",
                "address": "789 Medical Plaza, Palo Alto, CA 94301"
            },
            {
                "name": "Green Energy Solutions",
                "email": "info@greenenergy.com",
                "phone": "408-555-0126",
                "address": "321 Eco Street, Mountain View, CA 94043"
            },
            {
                "name": "Digital Marketing Pro",
                "email": "hello@digmarketing.com",
                "phone": "510-555-0127",
                "address": "654 Social Media Blvd, Oakland, CA 94612"
            },
            {
                "name": "Financial Services Group",
                "email": "contact@finserv.com",
                "phone": "925-555-0128",
                "address": "987 Investment Row, Walnut Creek, CA 94596"
            },
            {
                "name": "Creative Design Studio",
                "email": "design@creative.studio",
                "phone": "628-555-0129",
                "address": "246 Art Avenue, Berkeley, CA 94704"
            },
            {
                "name": "Cloud Computing Corp",
                "email": "support@cloudcomp.tech",
                "phone": "669-555-0130",
                "address": "135 Server Lane, Santa Clara, CA 95051"
            },
            {
                "name": "Research & Development Lab",
                "email": "research@rdlab.org",
                "phone": "831-555-0131",
                "address": "864 Innovation Way, Santa Cruz, CA 95060"
            },
            {
                "name": "Sustainable Agriculture",
                "email": "info@susag.org",
                "phone": "707-555-0132",
                "address": "753 Organic Farm Rd, Napa, CA 94559"
            }
        ]', true);

        // Clear existing data
        Organization::deleteAll();
        
        // Reset auto-increment
        \Yii::$app->db->createCommand('ALTER TABLE organization AUTO_INCREMENT = 20000000')->execute();

        $timestamp = new Expression('CURRENT_TIMESTAMP');
        
        foreach ($organizations as $org) {
            $organization = new Organization();
            $organization->name = $org['name'];
            $organization->email = $org['email'];
            $organization->phone = $org['phone'];
            $organization->address = $org['address'];
            $organization->created_at = $timestamp;
            $organization->updated_at = $timestamp;
            
            if (!$organization->save()) {
                echo "Error saving organization: " . json_encode($organization->errors) . "\n";
            } else {
                echo "Saved organization: {$organization->name}\n";
            }
        }

        echo "\nSeeding completed successfully!\n";
    }
} 