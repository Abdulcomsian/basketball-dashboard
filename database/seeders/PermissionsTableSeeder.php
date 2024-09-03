<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'inventory_access',
            ],
            [
                'id'    => 18,
                'title' => 'add_stock_create',
            ],
            [
                'id'    => 19,
                'title' => 'add_stock_edit',
            ],
            [
                'id'    => 20,
                'title' => 'add_stock_show',
            ],
            [
                'id'    => 21,
                'title' => 'add_stock_delete',
            ],
            [
                'id'    => 22,
                'title' => 'add_stock_access',
            ],
            [
                'id'    => 23,
                'title' => 'remove_stock_create',
            ],
            [
                'id'    => 24,
                'title' => 'remove_stock_edit',
            ],
            [
                'id'    => 25,
                'title' => 'remove_stock_show',
            ],
            [
                'id'    => 26,
                'title' => 'remove_stock_delete',
            ],
            [
                'id'    => 27,
                'title' => 'remove_stock_access',
            ],
            [
                'id'    => 28,
                'title' => 'available_stock_create',
            ],
            [
                'id'    => 29,
                'title' => 'available_stock_edit',
            ],
            [
                'id'    => 30,
                'title' => 'available_stock_show',
            ],
            [
                'id'    => 31,
                'title' => 'available_stock_delete',
            ],
            [
                'id'    => 32,
                'title' => 'available_stock_access',
            ],
            [
                'id'    => 33,
                'title' => 'report_access',
            ],
            [
                'id'    => 34,
                'title' => 'stock_out_create',
            ],
            [
                'id'    => 35,
                'title' => 'stock_out_edit',
            ],
            [
                'id'    => 36,
                'title' => 'stock_out_show',
            ],
            [
                'id'    => 37,
                'title' => 'stock_out_delete',
            ],
            [
                'id'    => 38,
                'title' => 'stock_out_access',
            ],
            [
                'id'    => 39,
                'title' => 'purchase_create',
            ],
            [
                'id'    => 40,
                'title' => 'purchase_edit',
            ],
            [
                'id'    => 41,
                'title' => 'purchase_show',
            ],
            [
                'id'    => 42,
                'title' => 'purchase_delete',
            ],
            [
                'id'    => 43,
                'title' => 'purchase_access',
            ],
            [
                'id'    => 44,
                'title' => 'product_create',
            ],
            [
                'id'    => 45,
                'title' => 'product_edit',
            ],
            [
                'id'    => 46,
                'title' => 'product_show',
            ],
            [
                'id'    => 47,
                'title' => 'product_delete',
            ],
            [
                'id'    => 48,
                'title' => 'product_access',
            ],
            [
                'id'    => 49,
                'title' => 'profile_password_edit',
            ],
            [
                'id'    => 50,
                'title' => 'customer_create',
            ],
            [
                'id'    => 51,
                'title' => 'customer_edit',
            ],
            [
                'id'    => 52,
                'title' => 'customer_show',
            ],
            [
                'id'    => 53,
                'title' => 'customer_delete',
            ],
            [
                'id'    => 54,
                'title' => 'customer_access',
            ],
            [
                'id'    => 55,
                'title' => 'supplier_create',
            ],
            [
                'id'    => 56,
                'title' => 'supplier_edit',
            ],
            [
                'id'    => 57,
                'title' => 'supplier_show',
            ],
            [
                'id'    => 58,
                'title' => 'supplier_delete',
            ],
            [
                'id'    => 59,
                'title' => 'supplier_access',
            ],
            [
                'id'    => 60,
                'title' => 'categories_create',
            ],
            [
                'id'    => 61,
                'title' => 'categories_edit',
            ],
            [
                'id'    => 62,
                'title' => 'categories_show',
            ],
            [
                'id'    => 63,
                'title' => 'categories_delete',
            ],
            [
                'id'    => 64,
                'title' => 'categories_access',
            ],
            [
                'id'    => 65,
                'title' => 'subcategories_create',
            ],
            [
                'id'    => 66,
                'title' => 'subcategories_edit',
            ],
            [
                'id'    => 67,
                'title' => 'subcategories_show',
            ],
            [
                'id'    => 68,
                'title' => 'subcategories_delete',
            ],
            [
                'id'    => 69,
                'title' => 'subcategories_access',
            ],
            [
                'id'    => 70,
                'title' => 'importstock_access',
            ],
            [
                'id'    => 71,
                'title' => 'material_create',
            ],
            [
                'id'    => 72,
                'title' => 'material_edit',
            ],
            [
                'id'    => 73,
                'title' => 'material_show',
            ],
            [
                'id'    => 74,
                'title' => 'material_delete',
            ],
            [
                'id'    => 75,
                'title' => 'material_access',
            ],
            [
                'id'    => 76,
                'title' => 'material_stock_access',
            ],
            [
                'id'    => 77,
                'title' => 'material_stock_create',
            ],
            [
                'id'    => 78,
                'title' => 'material_stock_show',
            ],
            [
                'id'   => 79,
                'title' => 'material_available_stock_access'
            ],
            [
                'id'   => 80,
                'title' => 'product_available_stock_access'
            ],
            [
                'id'    => 81,
                'title' => 'order_access',
            ],
            [
                'id'    => 82,
                'title' => 'order_show',
            ],
            [
                'id'    => 83,
                'title' => 'order_create',
            ],
            [
                'id'    => 84,
                'title' => 'payment_access',
            ],
            [
                'id'    => 85,
                'title' => 'ware_house_create',
            ],
            [
                'id'    => 86,
                'title' => 'ware_house_edit',
            ],
            [
                'id'    => 87,
                'title' => 'ware_house_show',
            ],
            [
                'id'    => 88,
                'title' => 'ware_house_delete',
            ],
            [
                'id'    => 89,
                'title' => 'ware_house_access',
            ],
            [
                'id'    => 90,
                'title' => 'unit_type_access',
            ],
            [
                'id'    => 91,
                'title' => 'payment_method_create',
            ],
            [
                'id'    => 92,
                'title' => 'payment_method_edit',
            ],
            [
                'id'    => 93,
                'title' => 'payment_method_show',
            ],
            [
                'id'    => 94,
                'title' => 'payment_method_delete',
            ],
            [
                'id'    => 95,
                'title' => 'payment_method_access',
            ],
            [
                'id'    => 96,
                'title' => 'site_settings',
            ],
            [
                'id'    => 97,
                'title' => 'order_delete',
            ],
            [
                'id'    => 98,
                'title' => 'transfer_stock_access',
            ],
            [
                'id'    => 99,
                'title' => 'transfer_stock_create',
            ],
            [
                'id'    => 100,
                'title' => 'transfer_stock_show',
            ],
            [
                'id'    => 101,
                'title' => 'return_order_access',
            ],
            [
                'id'    => 102,
                'title' => 'return_stock_access',
            ],
            [
                'id'    => 103,
                'title' => 'return_stock_create',
            ],
            [
                'id'    => 104,
                'title' => 'return_stock_list',
            ],
            [
                'id'    => 105,
                'title' => 'return_stock_show',
            ],
            [
                'id'    => 106,
                'title' => 'return_stock_delete',
            ],
            [
                'id'    => 107,
                'title' => 'return_stock_add_payment',
            ],
            [
                'id'    => 108,
                'title' => 'return_stock_payment_logs',
            ],
            [
                'id'    => 109,
                'title' => 'return_stock_change_status',
            ],
            [
                'id'    => 110,
                'title' => 'transfer_stock_pdf',
            ]
        ];

        Permission::insert($permissions);
    }
}