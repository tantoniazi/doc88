<?php

use App\Model\OauthClient;
use Illuminate\Database\Seeder;

class OauthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        (new OauthClient())->insert([
            'id' => 1,
            'name' => 'Laravel Personal Access Client',
            'secret' =>  'KgrFEsNALDdkjrzgsJD4XrQyxGiHRLnQIcrMTBHu' ,
            'redirect' =>  'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false
        ]);
        
        (new OauthClient())->insert([ 
            'id' => 2,
            'name' => 'Laravel Password Grant Client',
            'secret' => 'xnd43bO27iQwNDGSmovwMAYFoNHkTAV64RTJ8Cwt' ,
            'redirect' =>  'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false
        ]);
    }
}
