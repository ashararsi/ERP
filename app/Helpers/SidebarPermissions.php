<?php
namespace App\Helpers;

class SidebarPermissions
{
    public static function all()
    {
       
        return [
            'user_management' => [
                'View Roles List',
                'View Permissions List',
                'View Users List',
                'View Suppliers List',
                'View Vendors List',
            ],
        
            'accounting' => [
                'View Groups',
                'Create Groups',
                'View Ledgers',
                'Create Ledgers',
                'Create Vouchers',
                'View Entries',
                'View Reports',
                'View Chart of Accounts',
            ],
        
            'hr' => [
                'View Staff',
                'Create Staff',
                'View Holidays',
                'Create Holidays',
                'View Leave Types',
                'Create Leave Types',
                'View Leave Entitlement',
                'Create Leave Entitlement',
                'View Leave Requests',
                'Create Leave Requests',
                'View Leaves',
                'Create Leaves',
                'View Leave Statuses',
                'Create Leave Statuses',
                'View Loan Plans',
                'Create Loan Plans',
                'View Loans',
                'Create Loans',
                'View Work Shifts',
                'Create Work Shifts',
                'View Work Weeks',
                'Create Work Weeks',
            ],
        
            'inventory' => [
                'View Purchase Order List',
                'View GRN List',
                'View Units',
                'View Processes List',
                'View Raw List',
                'View Product List',
                'View Categories',
                'View Formulation',
                'View Batches',
                'View Goods-Issuance List',
                'View Goods-Receipt',
                'View Packing',
                'View Inventory',
                'View Packing Material',
            ],

            'sale' => [
                'View Customers List',
                'View POS Orders List',
            ],
        
            'location' => [
                'View Companies',
                'View Branches',
                'View Countries',
                'View City',
            ],
        ];
    }

    public static function get($module)
    {
        return self::all()[$module] ?? [];
    }
}
