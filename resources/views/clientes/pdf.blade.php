
<!DOCTYPE html>
<html>
<head>
  <title>Recibo de Dinero</title>
  <meta charset="utf-8">
</head>
<body>
<style type="text/css">
    body {
    padding: 50px;
    font-family: serif;
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
  height: 50px;
  margin: 50px 0;
  padding: 0 50px;
  background: #fff;
}

img {
  float: right;
}

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
  
  <p class="receipt-title">Recibo de Dinero</p> 

   <img src="http://studiosanchez.rocemi.com.py/images/qr_code.png" width="100" height="100">

  <div class="receipt-section pull-left">
    <span class="receipt-label text-large">Nº/Fecha:</span>
    <span class="text-large">{{$id}}</span>
    <span class="text-large"> - {{date_format($fecha, 'd/m/Y')}}</span>
  </div>

  <div class="receipt-section pull-left">
    <span class="receipt-label text-large">Nombre/Cliente:</span>
    <span class="text-large">{{$nombre}}</span>
  </div>
  
  <div class="pull-right receipt-section">
    <span class="text-large receipt-label">Entrega Gs.:</span>
    <span class="text-large">  {{number_format($entrega, 0, ',', '.')}}</span>
  </div>
  
  <div class="pull-right receipt-section">
    <span class="text-large receipt-label">Total Gs.:</span>
    <span class="text-large">  {{number_format($total, 0, ',', '.')}}</span>
  </div>

   <div class="pull-right receipt-section">
    <span class="text-large receipt-label">Saldo Gs.:</span>
    <span class="text-large">{{number_format($saldo, 0, ',', '.')}}</span>
  </div>
  
  <div class="receipt-section">
    <p class="pull-right text-large">El presente documento fué realizado en concepto de <b>{{$concepto}}. </b></p>
  </div>
  
  <div class="receipt-section">
    <p class="pull-right text-large">Gracias por su preferencia.</p> 
  </div>
  

  <div class="receipt-signature col-xs-6">
    <p class="receipt-line"></p>
    <p class="text-large">Studio Digital Sánchez</p>
    <p><b>Teléfonos:</b>071 - 208 206 / 0982- 359 850 <b>Email:</b>sanchezdigital1520@hotmail.com</p>
    <p>Mons. Wiessen Nº 856 e/ Avda. Irrazábal y Tte. Honorio González</p>
    <p>Encarnación - Paraguay</p>

  </div>


</div>

               

</body>
</html>

  
               
 