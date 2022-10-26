<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use DB;
use Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // user type insert
        $user_type_id = DB::table('user_types')->insertGetId([
            'code' => 'ADM',
            'name' => 'Administrator',
        ]);

        // user role insert
        $user_role_id = DB::table('user_roles')->insertGetId([
            'code' => 'ITS',
            'name' => 'IT Support',
        ]);

        // user status insert
        $user_statuses = ['active', 'inactive'];
        $user_status_id;
        foreach ($user_statuses as $status) {
            $insert_status_id = DB::table('user_statuses')->insertGetId([
                'name' => $status,
            ]);

            if($status == 'active')
                $user_status_id = $insert_status_id;
        }

        // user insert
        $user_id = DB::table('users')->insertGetId([
            'user_role_id' => $user_type_id,
            'user_type_id' => $user_role_id,
            'name' => 'PTC Test User',
            'email' => 'test@primetechcorp.com.ph',
            'password' => Hash::make('password'), //password
        ]);

        // user details insert
        DB::table('user_details')->insertGetId([
            'user_id' => $user_id,
            'firstname' => 'PTC',
            'middlename' => 'Test',
            'lastname' => 'User',
            'email' => 'test@primetechcorp.com.ph',
        ]);

        /**
         *
         * Insert Module Access
         */

        $modules = [
            [
                'name' => 'Settings',
                'sub_modules' => [
                    [
                        'name' => 'Settings - Users',
                        'url' => '/settings/users'
                    ],
                    [
                        'name' => 'Settings - Roles',
                        'url' => '/settings/users/roles'
                    ],
                    [
                        'name' => 'Settings - Types',
                        'url' => '/settings/users/types'
                    ],
                ]
            ]
        ];
        $modules = json_decode(json_encode($modules)); // associative array to object

        if($modules){
            foreach ($modules as $mkey => $module) {
                $module_id = DB::table('modules')->insertGetId([
                    'name' => $module->name,
                ]);

                if($module->sub_modules){
                    foreach ($module->sub_modules as $skey => $sub_modules) {
                        $sub_module_id = DB::table('sub_modules')->insertGetId([
                            'modules_id' => $module_id,
                            'sub_module_name' => $sub_modules->name,
                            'url' => $sub_modules->url,
                        ]);

                        // inserting the module access
                        DB::table('module_accesses')->insertGetId([
                            'user_type_id' => $user_type_id,
                            'sub_module_id' => $sub_module_id,
                        ]);
                    }
                }
            }
        }
    }
}
