<?php

use App\Models\Categoria;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->times(1)->create();
        // $this->categoriaMovimiento('Factura');
        // $this->categoriaMovimiento('Recibo');
    }

    private function categoriaMovimiento($nombreCategoria){
        $categoria = new Categoria();
        $categoria->nombreCategoria = $nombreCategoria;
        $categoria->save();
    }
}
