<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $Permission = new Permission  ();
        $Permission->name = "User_Mangement";
        $Permission->main = 1;
        $Permission->parrent_id = 0;
        $Permission->guard_name = 'web';
        $Permission->save();

        $Permission_setting = new Permission  ();
        $Permission_setting->name = "Settings";
        $Permission_setting->main = 1;
        $Permission_setting->parrent_id = 0;
        $Permission_setting->guard_name = 'web';
        $Permission_setting->save();

        $Permission = new Permission  ();
        $Permission->name = "Basic_Setup";
        $Permission->main = 1;
        $Permission->parrent_id = 0;
        $Permission->guard_name = 'web';
        $Permission->save();


        // user permissons

        $Permission = new Permission  ();
        $Permission->name = "Users";
        $Permission->main = 1;
        $Permission->parrent_id = 0;
        $Permission->guard_name = 'web';
        $Permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "User_create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "User_Index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "User_Edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "User_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


//

        $Permission = new Permission  ();
        $Permission->name = "Permissions";
        $Permission->main = 1;
        $Permission->parrent_id = 0;
        $Permission->guard_name = 'web';
        $Permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Permission_Create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Permission_Edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "Permission_Index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Permission_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


//role permission
        $Permission = new Permission  ();
        $Permission->name = "Roles";
        $Permission->main = 1;
        $Permission->parrent_id = 0;
        $Permission->guard_name = 'web';
        $Permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Role_Create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Role_Edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "Role_Index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Role_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        //$Permission_setting  permission


        //Page  permissions


        $Page_permission = new Permission  ();
        $Page_permission->name = "Page";
        $Page_permission->main = 1;
        $Page_permission->parrent_id = 0;
        $Page_permission->guard_name = 'web';
        $Page_permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Page_create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Page_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Page_index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Page_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "Page_edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Page_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Page_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Page_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        //Subscriber  permissions

        $Subscriber_permission = new Permission  ();
        $Subscriber_permission->name = "Subscriber";
        $Subscriber_permission->main = 1;
        $Subscriber_permission->parrent_id = 0;
        $Subscriber_permission->guard_name = 'web';
        $Subscriber_permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Subscriber_create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Subscriber_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Subscriber_index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Subscriber_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "Subscriber_edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Subscriber_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Subscriber_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Subscriber_permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        //Blogs  permissions

        $Blogs_Permission = new Permission  ();
        $Blogs_Permission->name = "Blogs";
        $Blogs_Permission->main = 1;
        $Blogs_Permission->parrent_id = 0;
        $Blogs_Permission->guard_name = 'web';
        $Blogs_Permission->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Blogs_create";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Blogs_Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Blogs_index";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Blogs_Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();


        $Permission_child = new Permission  ();
        $Permission_child->name = "Blogs_edit";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Blogs_Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();

        $Permission_child = new Permission  ();
        $Permission_child->name = "Blogs_Delete";
        $Permission_child->main = 0;
        $Permission_child->parrent_id = $Blogs_Permission->id;
        $Permission_child->guard_name = 'web';
        $Permission_child->save();



    }
}
