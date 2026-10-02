<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
  
  body {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    color: #1B2233;
    margin: 0;
    padding: 10px;
    background: #f5f5f5;
  }
  
  .receipt {
    max-width: 280px;
    margin: 0 auto;
    background: #fff;
    padding: 15px;
    border: 1px dashed #ccc;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  }
  
  .header {
    text-align: center;
    border-bottom: 2px solid #D4A937;
    padding-bottom: 10px;
    margin-bottom: 10px;
  }
  
  .logo {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid #D4A937;
    margin: 0 auto 5px;
    display: block;
  }
  
  .logo img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .parish-name {
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #0B1B3A;
    margin: 0;
  }
  
  .receipt-title {
    font-size: 14px;
    font-weight: 700;
    color: #D4A937;
    margin: 5px 0 0;
    text-transform: uppercase;
  }
  
  .receipt-number {
    font-size: 9px;
    color: #666;
    margin-top: 3px;
  }
  
  .info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 5px;
    font-size: 10px;
  }
  
  .info-label {
    color: #666;
    font-weight: 500;
  }
  
  .info-value {
    font-weight: 600;
    color: #1B2233;
    text-align: right;
  }
  
  .intention-box {
    background: #f9f9f9;
    border-left: 3px solid #D4A937;
    padding: 8px;
    margin: 10px 0;
    font-size: 10px;
  }
  
  .intention-text {
    font-style: italic;
    color: #333;
    line-height: 1.3;
  }
  
  .amount-section {
    text-align: center;
    margin: 15px 0;
    padding: 10px;
    background: linear-gradient(135deg, rgba(212, 169, 55, 0.1) 0%, rgba(242, 217, 138, 0.15) 100%);
    border: 1px solid #D4A937;
    border-radius: 4px;
  }
  
  .amount-label {
    font-size: 8px;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #666;
    margin-bottom: 3px;
  }
  
  .amount-value {
    font-size: 18px;
    font-weight: 700;
    color: #D4A937;
  }
  
  .footer {
    text-align: center;
    margin-top: 15px;
    padding-top: 10px;
    border-top: 1px dashed #ccc;
    font-size: 8px;
    color: #666;
  }
  
  .footer::before {
    content: '✝';
    display: block;
    font-size: 14px;
    color: #D4A937;
    margin-bottom: 5px;
  }
  
  .date-print {
    font-size: 8px;
    color: #999;
    margin-top: 5px;
  }
</style>
</head>
<body>
<div class="receipt">
  <div class="header">
    <div class="logo">
      <img src="{{ $logoSrc }}" alt="Saint Michel">
    </div>
    <p class="parish-name">Paroisse St Michel</p>
    <h1 class="receipt-title">REÇU</h1>
    <p class="receipt-number">N° {{ $numero }}</p>
  </div>
  
  <div class="info-row">
    <span class="info-label">Date:</span>
    <span class="info-value">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</span>
  </div>
  <div class="info-row">
    <span class="info-label">Reçu de:</span>
    <span class="info-value">{{ $de }}</span>
  </div>
  
  <div class="intention-box">
    <div class="intention-text">{{ $motif }}</div>
  </div>
  
  <div class="amount-section">
    <div class="amount-label">Montant</div>
    <div class="amount-value">{{ number_format($montant, 0, ',', ' ') }} FCFA</div>
  </div>
  
  <div class="footer">
    <p>Paroisse Saint Michel Archange de la BAE</p>
    <div class="date-print">{{ \Carbon\Carbon::parse($date)->format('d/m/Y H:i') }}</div>
  </div>
</div>
</body>
</html>