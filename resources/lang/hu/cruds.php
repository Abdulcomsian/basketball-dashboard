<?php

return [
    'userManagement' => [
        'title'          => 'Felhasználó kezelés',
        'title_singular' => 'Felhasználó kezelés',
    ],
    'permission' => [
        'title'          => 'Jogosultságok',
        'title_singular' => 'Jogosultság',
        'fields'         => [
            'id'                => 'Azonosító',
            'id_helper'         => ' ',
            'title'             => 'Cím',
            'title_helper'      => ' ',
            'created_at'        => 'Létrehozva',
            'created_at_helper' => ' ',
            'updated_at'        => 'Frissítve',
            'updated_at_helper' => ' ',
            'deleted_at'        => 'Törölve',
            'deleted_at_helper' => ' ',
        ],
    ],
    'role' => [
        'title'          => 'Szerepkörök',
        'title_singular' => 'Szerepkör',
        'fields'         => [
            'id'                 => 'Azonosító',
            'id_helper'          => ' ',
            'title'              => 'Cím',
            'title_helper'       => ' ',
            'permissions'        => 'Jogosultságok',
            'permissions_helper' => ' ',
            'created_at'         => 'Létrehozva',
            'created_at_helper'  => ' ',
            'updated_at'         => 'Frissítve',
            'updated_at_helper'  => ' ',
            'deleted_at'         => 'Törölve',
            'deleted_at_helper'  => ' ',
        ],
    ],
    'user' => [
        'title'          => 'Felhasználók',
        'title_singular' => 'Felhasználó',
        'fields'         => [
            'id'                       => 'Azonosító',
            'id_helper'                => ' ',
            'name'                     => 'Név',
            'name_helper'              => ' ',
            'email'                    => 'E-mail',
            'email_helper'             => ' ',
            'email_verified_at'        => 'E-mail ellenőrzve',
            'email_verified_at_helper' => ' ',
            'password'                 => 'Jelszó',
            'password_helper'          => ' ',
            'roles'                    => 'Szerepek',
            'roles_helper'             => ' ',
            'remember_token'           => 'Emlékeztető token',
            'remember_token_helper'    => ' ',
            'created_at'               => 'Létrehozva',
            'created_at_helper'        => ' ',
            'updated_at'               => 'Frissítve',
            'updated_at_helper'        => ' ',
            'deleted_at'               => 'Törölve',
            'deleted_at_helper'        => ' ',
            'contact'               => 'Kapcsolat',
            'contact_helper'        => ' ',
            'address'               => 'Cím',
            'address_helper'        => ' ',
        ],
    ],
    'inventory' => [
        'title'          => 'Készlet',
        'title_singular' => 'Készlet',
    ],
    'addStock' => [
        'title'          => 'Készlet hozzáadás',
        'title_singular' => 'Készlet hozzáadás',
        'fields'         => [
            'id'                    => 'Azonosító',
            'id_helper'             => ' ',
            'barcode'               => 'Vonalkód',
            'barcode_helper'        => 'kattintson erre a mezőre, majd szkenelje be a vonalkódot egy szkennelővel',
            'quantity'              => 'Mennyiség',
            'quantity_helper'       => ' ',
            'created_at'            => 'Létrehozva',
            'created_at_helper'     => ' ',
            'updated_at'            => 'Frissítve',
            'updated_at_helper'     => ' ',
            'deleted_at'            => 'Törölve',
            'deleted_at_helper'     => ' ',
            'select_product'        => 'Válassza ki a terméket',
            'select_product_helper' => ' ',
            'price'               => 'Ár',
            'price_helper'        => ' ',
            'buying_price'               => 'Vásárlási ár',
            'buying_price_helper'        => ' ',
        ],
    ],
    'availableStock' => [
        'title'          => 'Elérhető készlet',
        'title_singular' => 'Elérhető készlet',
    ],
    'report' => [
        'title'          => 'Jelentések',
        'title_singular' => 'Jelentés',
    ],
    'stockin' => [
        'title'          => 'Készlet kifogyás',
        'title_singular' => 'Készlet kifogyás',
    ],
    'stockOut' => [
        'title'          => 'Készlet kifogyás',
        'title_singular' => 'Készlet kifogyás',
    ],
    'importstock' => [
        'title'          => 'Készlet importálása',
        'title_singular' => 'Készlet importálása',
    ],
    'purchase_orders' => [
        'title'          => 'Vásárlás',
        'title_singular' => 'Vásárlás',
    ],
    'product' => [
        'title'          => 'Termék',
        'title_singular' => 'Termék',
        'fields'         => [
            'id'                   => 'Azonosító',
            'id_helper'            => ' ',
            'product_image'        => 'Termék kép',
            'category'             => 'Kategória',
            'name'                 => 'Név',
            'unit_price'           => 'Egységár',
            'article_no'            => 'Cikk szám',
            'material'             => 'Anyag',
            'status'               => 'Állapot',
            'qr_code'              => 'QR-kód',
            'download_qr_code'     => 'QR-kód letöltése',
            'name_helper'          => ' ',
            'product_image_helper' => ' ',
            'category_helper'      => ' ',
            'unit_price_helper'    => ' ',
            'material_helper'      => ' ',
            'status_helper'        => ' ',
            'created_at'           => 'Létrehozva',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Frissítve',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Törölve',
            'deleted_at_helper'    => ' ',
        ],
    ],
    'product_category' => [
        'title'          => 'Termékkategória',
        'title_singular' => 'Termékkategória',
        'fields'         => [
            'id'                   => 'Azonosító',
            'id_helper'            => ' ',
            'name'                 => 'Név',
            'name_helper'          => ' ',
            'created_at'           => 'Létrehozva',
            'created_at_helper'    => ' ',
            'updated_at'           => 'Frissítve',
            'updated_at_helper'    => ' ',
            'deleted_at'           => 'Törölve',
            'deleted_at_helper'    => ' ',
        ],
        'add_category'          => 'Kategória hozzáadása',
        'edit_category'         => 'Kategória szerkesztése',
        'update_category'       => 'Kategória frissítése',
        'category_list'         => 'Termékkategória lista',
        'category_name'         => 'Kategória név',
    ],
    'customer' => [
        'title'          => 'Vevők',
        'title_singular' => 'Vevő',
        'fields'         => [
            'id'            => 'Azonosító',
            'id_helper'     => ' ',
            'name'          => 'Név',
            'contact'       => 'Kapcsolat',
            'email'         => 'E-mail',
            'address'       => 'cím',
            'shipping_address' => 'Szállítási cím ',
            'created_at'    => 'Létrehozva',
            'created_at_helper' => ' ',
            'updated_at'    => 'Frissítve',
            'updated_at_helper' => ' ',
            'deleted_at'    => 'Törölve',
            'deleted_at_helper' => ' ',
        ],
        'add' => 'Vevő hozzáadása',
        'edit' => 'Vevő szerkesztése',
        'update' => 'Vevő frissítése',
        'list' => 'Vevő lista',
        'name' => 'Vevő neve',
    ],

    'supplier' => [
        'title'          => 'Beszállítók',
        'title_singular' => 'Beszállító',
        'fields'         => [
            'id'            => 'Azonosító',
            'id_helper'     => ' ',
            'name'          => 'Név',
            'contact'       => 'Kapcsolat',
            'email'         => 'E-mail',
            'address'       =>  'cím',
            'created_at'    => 'Létrehozva',
            'created_at_helper' => ' ',
            'updated_at'    => 'Frissítve',
            'updated_at_helper' => ' ',
            'deleted_at'    => 'Törölve',
            'deleted_at_helper' => ' ',
        ],
        'add' => 'Beszállító hozzáadása',
        'edit' => 'Beszállító szerkesztése',
        'update' => 'Beszállító frissítése',
        'list' => 'Beszállító lista',
        'name' => 'Beszállító neve',
    ],

    'order' => [
        'title'          => 'Vásárlás',
        'title_singular' => 'Vásárlás',
    ],

    'product' => [
        'title'          => 'Termékek',
        'title_singular' => 'Termék',
        'all_categories' => 'Összes kategória',
        'all_suppliers' => 'Minden beszállító',
    ],

    'setting' => [
        'warehouse'   => 'Raktár',
        'store_name'  => 'Bolt neve',
        'whatsapp_no' => 'WhatsApp szám',
        'phone_no'    => 'Telefonszám',
        'email'       => 'E-mail',
        'address'     => 'Cím',
    ],
];
