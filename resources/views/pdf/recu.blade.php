<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');
  
  body {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: 14px;
    color: #1B2233;
    background: linear-gradient(135deg, #FAF7F0 0%, #F5F2EC 100%);
    margin: 0;
    padding: 40px;
  }
  
  .receipt-container {
    max-width: 700px;
    margin: 0 auto;
    background: #FFFFFF;
    position: relative;
    box-shadow: 0 20px 60px rgba(11, 27, 58, 0.15);
  }
  
  .receipt-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 8px;
    background: linear-gradient(90deg, #D4A937 0%, #F2D98A 50%, #D4A937 100%);
  }
  
  .receipt-container::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 8px;
    background: linear-gradient(90deg, #D4A937 0%, #F2D98A 50%, #D4A937 100%);
  }
  
  .receipt-header {
    text-align: center;
    padding: 40px 50px 30px;
    border-bottom: 2px solid #E6E1D3;
    position: relative;
  }
  
  .logo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    border: 4px solid #D4A937;
    padding: 4px;
    margin: 0 auto 20px;
    display: block;
    box-shadow: 0 4px 20px rgba(212, 169, 55, 0.3);
    background: #FAF7F0;
  }
  
  .logo img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .parish-name {
    font-family: 'Cinzel', serif;
    font-size: 18px;
    font-weight: 600;
    letter-spacing: 3px;
    color: #0B1B3A;
    margin: 0 0 8px;
    text-transform: uppercase;
  }
  
  .receipt-title {
    font-family: 'Cinzel', serif;
    font-size: 32px;
    font-weight: 700;
    letter-spacing: 8px;
    color: #D4A937;
    margin: 15px 0 0;
    text-transform: uppercase;
    position: relative;
    display: inline-block;
  }
  
  .receipt-title::before,
  .receipt-title::after {
    content: '✦';
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    color: #D4A937;
    font-size: 20px;
  }
  
  .receipt-title::before {
    left: -35px;
  }
  
  .receipt-title::after {
    right: -35px;
  }
  
  .receipt-number {
    font-family: 'Inter', sans-serif;
    font-size: 12px;
    font-weight: 500;
    color: #6B7590;
    letter-spacing: 2px;
    margin-top: 10px;
  }
  
  .receipt-body {
    padding: 40px 50px;
  }
  
  .info-grid {
    display: grid;
    grid-template-columns: 140px 1fr;
    gap: 18px 30px;
    margin-bottom: 30px;
  }
  
  .info-label {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: #6B7590;
    text-transform: uppercase;
    letter-spacing: 1.5px;
  }
  
  .info-value {
    font-family: 'Cormorant Garamond', serif;
    font-size: 16px;
    font-weight: 500;
    color: #1B2233;
  }
  
  .info-value strong {
    font-weight: 600;
    color: #0B1B3A;
  }
  
  .amount-section {
    background: linear-gradient(135deg, rgba(212, 169, 55, 0.08) 0%, rgba(242, 217, 138, 0.12) 100%);
    border: 2px solid #D4A937;
    border-radius: 12px;
    padding: 25px 30px;
    text-align: center;
    margin-top: 20px;
  }
  
  .amount-label {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    font-weight: 600;
    color: #6B7590;
    text-transform: uppercase;
    letter-spacing: 2px;
    margin-bottom: 8px;
  }
  
  .amount-value {
    font-family: 'Cinzel', serif;
    font-size: 36px;
    font-weight: 700;
    color: #D4A937;
    letter-spacing: 2px;
  }
  
  .signature-section {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid #E6E1D3;
    display: flex;
    justify-content: space-between;
    gap: 40px;
  }
  
  .signature-box {
    flex: 1;
    text-align: center;
    position: relative;
  }
  
  .signature-line {
    width: 100%;
    height: 60px;
    border-bottom: 2px solid #D4A937;
    margin-bottom: 15px;
    position: relative;
  }
  
  .signature-line::before {
    content: '';
    position: absolute;
    bottom: -2px;
    left: 50%;
    transform: translateX(-50%);
    width: 40px;
    height: 40px;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><path d="M50 10 C30 10, 20 30, 20 50 C20 70, 30 90, 50 90 C70 90, 80 70, 80 50 C80 30, 70 10, 50 10" fill="none" stroke="%23D4A937" stroke-width="2" opacity="0.3"/></svg>') no-repeat center;
    background-size: contain;
  }
  
  .signature-title {
    font-family: 'Cinzel', serif;
    font-size: 13px;
    font-weight: 600;
    color: #0B1B3A;
    letter-spacing: 1px;
    margin-bottom: 5px;
  }
  
  .signature-subtitle {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 400;
    color: #6B7590;
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  
  .receipt-footer {
    text-align: center;
    padding: 30px 50px 40px;
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    color: #6B7590;
    letter-spacing: 1px;
  }
  
  .receipt-footer::before {
    content: '†';
    display: block;
    font-size: 24px;
    color: #D4A937;
    margin-bottom: 10px;
  }
</style>
</head>
<body>
<div class="receipt-container">
  <div class="receipt-header">
    <div class="logo">
      <img src="{{ $logoSrc }}" alt="Saint Michel Archange">
    </div>
    <p class="parish-name">Paroisse Saint Michel Archange de la BAE</p>
    <h1 class="receipt-title">Reçu</h1>
    <p class="receipt-number">N° {{ $numero }}</p>
  </div>
  
  <div class="receipt-body">
    <div class="info-grid">
      <div class="info-label">Date</div>
      <div class="info-value">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</div>
      
      <div class="info-label">Reçu de</div>
      <div class="info-value"><strong>{{ $de }}</strong></div>
      
      <div class="info-label">Motif</div>
      <div class="info-value">{{ $motif }}</div>
    </div>
    
    <div class="amount-section">
      <div class="amount-label">Montant</div>
      <div class="amount-value">{{ number_format($montant, 0, ',', ' ') }} FCFA</div>
    </div>
    
    <div class="signature-section">
      <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-title">Le Trésorier / L'Économe</div>
        <div class="signature-subtitle">Signature et Cachet</div>
      </div>
      <div class="signature-box">
        <div class="signature-line"></div>
        <div class="signature-title">Vu et Approuvé : Le Curé</div>
        <div class="signature-subtitle">Signature et Cachet</div>
      </div>
    </div>
  </div>
  
  <div class="receipt-footer">
    Paroisse Saint Michel Archange de la BAE • Fait à {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
  </div>
</div>
</body>
</html>
