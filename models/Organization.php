<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "organization".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 */
class Organization extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'organization';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'value' => new Expression('CURRENT_TIMESTAMP'),
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['name', 'email', 'phone', 'address'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Organization Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'address' => 'Address',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Generate sample data
     */
    public static function generateSampleData()
    {
        $unitTypes = ['Faculty', 'Administration', 'Campus', 'Branch', 'Hostel', 'School', 'Office', 'Library', 'Committee'];
        $parents = ['Campus', 'Institute', 'Library', 'Hostel', 'Institution', 'Study Center', 'School'];
        $instituteTypes = ['Administrative', 'Academic', 'National Institute of Technology'];
        
        // Clear existing data
        static::deleteAll();
        
        // Reset auto-increment
        $db = static::getDb();
        $db->createCommand('ALTER TABLE organization AUTO_INCREMENT = 20000000')->execute();
        
        for ($i = 1; $i <= 100; $i++) {
            $model = new static();
            $model->name = self::generateTitle();
            $model->email = self::generateEmail();
            $model->phone = self::generatePhone();
            $model->address = self::generateAddress();
            $model->save();
        }
    }

    /**
     * Generate a random title
     */
    private static function generateTitle()
    {
        $prefixes = ['Department', 'Campus', 'Committee', 'Alumni', 'Research'];
        $prefix = $prefixes[array_rand($prefixes)];
        return $prefix . rand(100, 999);
    }

    /**
     * Generate a random email
     */
    private static function generateEmail()
    {
        $domains = ['@example.com', '@university.edu', '@college.edu', '@school.edu'];
        $localPart = self::generateLocalPart();
        $domain = $domains[array_rand($domains)];
        return $localPart . $domain;
    }

    /**
     * Generate a random phone
     */
    private static function generatePhone()
    {
        $areaCode = rand(100, 999);
        $exchange = rand(100, 999);
        $subscriber = rand(1000, 9999);
        return $areaCode . '-' . $exchange . '-' . $subscriber;
    }

    /**
     * Generate a random address
     */
    private static function generateAddress()
    {
        $streets = ['Main St', 'Elm St', 'Oak St', 'Maple St', 'Pine St'];
        $cities = ['New York', 'Los Angeles', 'Chicago', 'Houston', 'Miami'];
        $states = ['NY', 'CA', 'IL', 'TX', 'FL'];
        $zipCodes = ['10001', '90001', '60601', '77001', '33101'];
        
        $street = $streets[array_rand($streets)];
        $city = $cities[array_rand($cities)];
        $state = $states[array_rand($states)];
        $zipCode = $zipCodes[array_rand($zipCodes)];
        
        return $street . ', ' . $city . ', ' . $state . ' ' . $zipCode;
    }

    /**
     * Generate a random local part for email
     */
    private static function generateLocalPart()
    {
        $length = rand(5, 10);
        $localPart = '';
        for ($i = 0; $i < $length; $i++) {
            $localPart .= chr(rand(97, 122)); // ASCII lowercase letters
        }
        return $localPart;
    }
}