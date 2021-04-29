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
        $this->moneda(['Guaranies', 'Gs.', 1, 1]);
        $this->moneda(['Dólares', '$', 6500, 0]);
        $this->moneda(['Reales', 'R$', 1200, 0]);
        $this->moneda(['Pesos', '$', 70, 0]);
        // $this->categoriaMovimiento('Factura');
        // $this->categoriaMovimiento('Recibo');
    }

    private function categoriaMovimiento($nombreCategoria){
        $categoria = new Categoria();
        $categoria->nombreCategoria = $nombreCategoria;
        $categoria->save();
    }

    private function moneda($moneda){
      Moneda::create([
        'nombre' => $moneda[0],
        'simbolo' => $moneda[1],
        'valor' => $moneda[2],
        'predeterminada' => $moneda[3],
      ])
    }
}
