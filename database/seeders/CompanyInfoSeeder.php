<?php

namespace Database\Seeders;

use App\Models\CompanyInfo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanyInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company = [
            [
                'company_name' => 'Woman Safety',
                'latitude' => '17.345290',
                'langitude' => '78.457010',
                'address' => 'Lahore',
            ],

        ];

        foreach ($company as $row){
            CompanyInfo::updateOrCreate(
                ['company_name' =>$row['company_name']],
                [
                    'company_name' => $row['company_name'],
                    'latitude' => $row['latitude'],
                    'langitude' => $row['langitude'],
                    'address' => $row['address'],
                ]);
        }
    }
}
