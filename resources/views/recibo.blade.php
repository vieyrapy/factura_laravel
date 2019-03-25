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
    <span class="text-large">2016/02</span>
  </div>
  
  <div class="pull-right receipt-section">
    <span class="text-large receipt-label">R$</span>
    <span class="text-large">50,00</span>
  </div>
  
  <div class="clearfix"></div>
  
  <div class="receipt-section">
    <span class="receipt-label">Beneficiário:</span>
    <span>Tabata Ruiz (CPF: 333.333.333-99)</span>
  </div>
  
  <div class="receipt-section">
    <span class="receipt-label">Responsável:</span>
    <span>Tabata Ruiz (CPF: 333.333.333-99)</span>
  </div>
  
  <div class="receipt-section">
    <p>Recebi de Tabata Ruiz a importância de cinquenta reais</p>
    <p>Referente a meus serviços profissionais</p>
  </div>
  
  <div class="receipt-section">
    <p class="pull-right text-large">São Paulo, 07/11/2016</p>
  </div>
  
  <div class="clearfix"></div>
  
  <div class="receipt-signature col-xs-6">
    <p class="receipt-line"></p>
    <p>Clínica Matriz</p>
    <p>41.254.455/0001-00</p>
    <p>Rua Blablabla, 3456 - Jd. das Cerejeiras</p>
    <p>São Paulo - SP - 09889-349</p>
  </div>

  <div class="receipt-signature col-xs-6">
    <p class="receipt-line"></p>
    <p>Tabata Ruiz</p>
    <p>333.333.333-99</p>
  </div>
</div>