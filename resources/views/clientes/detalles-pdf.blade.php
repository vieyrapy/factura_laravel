


                    <a href="../recibo">Crear PDF</a>
                    <a href="../clientes" class="btn btn-default float-right">Volver</a>

               
                <style type="text/css">
    body {
  padding: 50px;
}

* {
  box-sizing: border-box;
}

.receipt-main {
  display: inline-block;
  width: 100%;
  padding: 15px;
  font-size: 12px;
  border: 1px solid #000;
}

.receipt-title {
  text-align: center;
  text-transform: uppercase;
  font-size: 20px;
  font-weight: 600;
  margin: 0;
}
  
.receipt-label {
  font-weight: 600;
}

.text-large {
  font-size: 16px;
}

.receipt-section {
  margin-top: 10px;
}

.receipt-footer {
  text-align: center;
  background: #ff0000;
}

.receipt-signature {
  height: 80px;
  margin: 50px 0;
  padding: 0 50px;
  background: #fff;
  
  .receipt-line {
    margin-bottom: 10px;
    border-bottom: 1px solid #000;
  }
  
  p {
    text-align: center;
    margin: 0;
  }
}
</style>

<div class="receipt-main">
  
  <p class="receipt-title">Recibo</p>
  
  <div class="receipt-section pull-left">
    <span class="receipt-label text-large">Número:</span>
    <span class="text-large">{{$pagos->id}}</span>
  </div>
  
  <div class="pull-right receipt-section">
    <span class="text-large receipt-label">Gs:</span>
    <span class="text-large">{{$pagos->entrega}}</span>
  </div>
  
  <div class="clearfix"></div>
  
  <div class="receipt-section">
    <span class="receipt-label">Total:</span>
    <span>{{$pagos->total}}</span>
  </div>
  
  <div class="receipt-section">
    <span class="receipt-label">Saldo:</span>
    <span>{{$pagos->saldo}}</span>
  </div>
  
  <div class="receipt-section">
    <p>El presente documento fue realizado en concepto de {{$pagos->concepto}} </p>
  </div>
  
  <div class="receipt-section">
    <p class="pull-right text-large">Encarnación, {{$pagos->created_at}}</p>
  </div>
  
  <div class="clearfix"></div>
  
  <div class="receipt-signature col-xs-6">
    <p class="receipt-line"></p>
    <p>Studio Digital Sánchez</p>
    <p>071 - 208 206</p>
    <p>Mons. Wiessen Nº 856 e/ Avda. Irrazábal y Tte. Honorio González</p>
    <p>Encarnación - Paraguay</p>
  </div>


</div>

               
