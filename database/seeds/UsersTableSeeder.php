<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            // [ 
            //     'id'             => null,
            //     'name'           =>'Admin',
            //     'initials_name'  =>'A.',
            //     'first_name'     =>'Admin',
            //     'last_name'      =>'Admin',
            //     'email'          =>'admin@admin.in',
            //     'company_name'   =>null,
            //     'phone'          =>null,
            //     'registration_no'=>null,
            //     'address'        =>null,
            //     'host_name'      =>null,
            //     'password'       =>'$2y$10$40enDFKxi7XV9oN.8Tsof.1WaMkqdzKURD9/3hDHv4J/TI0HUjKeu',
            //     'website_id'     =>null,
            //     'subscription'   =>null,
            // ],
            [ 
                'id'             => null,
                'name'           =>'super Admin',
                'initials_name'  =>'S.A.',
                'first_name'     =>'super',
                'last_name'      =>'Admin',
                'email'          =>'super@gmail.in',
                'company_name'   =>'superAdmin',
                'phone'          =>'049999999999',
                'registration_no'=>'PHA0012350020202008',
                'address'        =>'Super Admin Panel',
                'host_name'      =>'superadmin',
                'password'       =>'$2y$10$40enDFKxi7XV9oN.8Tsof.1WaMkqdzKURD9/3hDHv4J/TI0HUjKeu',
                'website_id'     =>1,
                'subscription'   =>1,
            ],
        ];

        User::insert($users);
    }
}
