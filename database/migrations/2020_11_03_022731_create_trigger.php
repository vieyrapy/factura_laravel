<?php

use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Migrations\Migration;

class CreateTrigger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared("
        CREATE TRIGGER tr_movimiento_venta AFTER INSERT ON `ventas` FOR EACH ROW
        BEGIN
            INSERT INTO movimientos (fecha, entidad, categoria_id, concepto, tipo_movimiento, monto, created_at, updated_at)
            VALUES (now(), NEW.cliente_id, 1, CONCAT('Factura ', NEW.nro_factura), 'Ingreso', NEW.total, now(), now());
        END
        ");
        DB::unprepared("
        CREATE TRIGGER tr_movimiento_pago AFTER INSERT ON `pagos` FOR EACH ROW
        BEGIN
            INSERT INTO movimientos (fecha, entidad, categoria_id, concepto, tipo_movimiento, monto, created_at, updated_at)
            VALUES (now(), NEW.clientes_id, 2, 'Recibo', 'Ingreso', NEW.entrega, now(), now());
        END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `tr_movimiento_venta`');
    }
}
