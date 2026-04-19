<?php

namespace Database\Seeders;

use App\Models\Condicion;
use App\Models\Zona;
use Illuminate\Database\Seeder;

class ZonasCondicionesSeeder extends Seeder
{
    public function run(): void
    {
        $zonas = [
            'Capital', 'Rawson', 'Caucete', 'Jachal', 'Pocito',
            'Sarmiento', '9 de Julio', 'Albardón', 'Chimbas',
            'Santa Lucía', 'Rivadavia', 'Iglesia', 'Valle Fértil', 'Angaco',
        ];

        foreach ($zonas as $zona) {
            Zona::firstOrCreate(['nombre' => $zona], ['activo' => true]);
        }

        $condiciones = ['Activo', 'Jubilado', 'Pensionado', 'Viuda'];

        foreach ($condiciones as $condicion) {
            Condicion::firstOrCreate(['nombre' => $condicion], ['activo' => true]);
        }
    }
}
