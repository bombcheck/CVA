<?php

use App\Role;
use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $client = new \App\Client();
        $client->name = 'Client 1';
        $client->iwinback_api_key = 'iWINBACK API KEY';
        $client->iwinback_api_secret = 'iWINBACK API SECRET';
        $client->save();

        $brand = new \App\Brand();
        $brand->name = 'Brand 1';
        $brand->client_id = $client->id;
        $brand->save();

        $campaign = new \App\Campaign();
        $campaign->title = 'Campaign Title';
        $campaign->description = 'Campaign Description';
        $campaign->sms_script = 'Sms Script';
        $campaign->email_html = 'Email Html';
        $campaign->email_subject = 'Email Subject';
        $campaign->call_script = 'Call Script';
        $campaign->brand_id = $brand->id;
        $campaign->client_id = $brand->client_id;
        $campaign->save();

        $user = new \App\User();
        $user->first_name = "Admin";
        $user->last_name = "Admini";
        $user->username = "Admin";
        $user->email = "admin@admin.com";
        $user->password = bcrypt("admin");
        $user->active = true;
        $role = Role::where('name', 'super admin')->first();
        $user->role_id = $role->id;
        $user->save();

        $clientAdmin = new \App\User();
        $clientAdmin->first_name = "Client Admin";
        $clientAdmin->last_name = "Admini";
        $clientAdmin->username = "clientAdmin";
        $clientAdmin->email = "client@admin.com";
        $clientAdmin->password = bcrypt("client");
        $clientAdmin->active = true;
        $clientAdmin->client_id = $client->id;
        $role2 = Role::where('name', 'client admin')->first();
        $clientAdmin->role_id = $role2->id;
        $clientAdmin->save();

        $clientUser = new \App\User();
        $clientUser->first_name = "Client User";
        $clientUser->last_name = "User";
        $clientUser->username = "clientUser";
        $clientUser->email = "client@user.com";
        $clientUser->password = bcrypt("client");
        $clientUser->active = true;
        $clientUser->client_id = $client->id;
        $role3 = Role::where('name', 'client user')->first();
        $clientUser->role_id = $role3->id;
        $clientUser->save();

        $clientViewer = new \App\User();
        $clientViewer->first_name = "Client Viewer";
        $clientViewer->last_name = "Viewer";
        $clientViewer->username = "clientViewer";
        $clientViewer->email = "client@viewer.com";
        $clientViewer->password = bcrypt("client");
        $clientViewer->active = true;
        $clientViewer->client_id = $client->id;
        $role4 = Role::where('name', 'client viewer')->first();
        $clientViewer->role_id = $role4->id;
        $clientViewer->save();
    }
}
