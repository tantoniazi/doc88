<?php

use App\Model\Pastel;
use Illuminate\Database\Seeder;


class PastelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 
        (new Pastel())->insert([
            'id' => 1,
            'nome' => 'Frango com catupiry',
            'preco' =>   7.50,
            'foto' =>  'storage/pastel/1.jpeg'
        ]);


 
        (new Pastel())->insert([
            'id' => 2,
            'nome' => 'Queijo',
            'preco' =>   6.50,
            'foto' =>  'storage/pastel/2.jpeg'
        ]);


        (new Pastel())->insert([
            'id' => 3,
            'nome' => 'Carne',
            'preco' =>   5.50,
            'foto' =>  'storage/pastel/3.jpeg'
        ]);


        (new Pastel())->insert([
            'id' => 4,
            'nome' => 'Pizza',
            'preco' =>   4.50,
            'foto' =>  'storage/pastel/4.jpeg'
        ]);
        
    }
}
