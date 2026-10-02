<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<style>
  @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;600;700&family=Cormorant+Garamond:wght@400;500;600;700&family=Inter:wght@300;400;500;600&display=swap');
  
  body {
    font-family: 'Cormorant Garamond', Georgia, serif;
    font-size: 12px;
    color: #1B2233;
    background: #FAF7F0;
    margin: 0;
    padding: 20px;
  }
  
  .document-container {
    max-width: 800px;
    margin: 0 auto;
    background: #FFFFFF;
    position: relative;
    box-shadow: 0 10px 40px rgba(11, 27, 58, 0.1);
  }
  
  .document-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 6px;
    background: linear-gradient(90deg, #D4A937 0%, #F2D98A 50%, #D4A937 100%);
  }
  
  .document-header {
    text-align: center;
    padding: 30px 40px 20px;
    border-bottom: 2px solid #E6E1D3;
  }
  
  .logo {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 3px solid #D4A937;
    padding: 3px;
    margin: 0 auto 15px;
    display: block;
  }
  
  .logo img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
  }
  
  .parish-name {
    font-family: 'Cinzel', serif;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 2px;
    color: #0B1B3A;
    margin: 0 0 5px;
    text-transform: uppercase;
  }
  
  .document-title {
    font-family: 'Cinzel', serif;
    font-size: 24px;
    font-weight: 700;
    letter-spacing: 4px;
    color: #D4A937;
    margin: 10px 0 5px;
    text-transform: uppercase;
  }
  
  .info-bar {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    color: #6B7590;
    letter-spacing: 1px;
    margin-top: 10px;
  }
  
  .document-body {
    padding: 30px 40px;
  }
  
  .intention-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .intention-table th {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 600;
    color: #6B7590;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 10px;
    text-align: left;
    border-bottom: 2px solid #D4A937;
    background: #FAF7F0;
  }
  
  .intention-table td {
    padding: 12px 10px;
    border-bottom: 1px solid #F0EBDF;
    vertical-align: top;
  }
  
  .intention-table tr:last-child td {
    border-bottom: none;
  }
  
  .intention-table tr:nth-child(even) {
    background: #FAF7F0;
  }
  
  .type-badge {
    display: inline-block;
    padding: 4px 10px;
    border-radius: 4px;
    font-family: 'Inter', sans-serif;
    font-size: 9px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
  }
  
  .type-action-grace {
    background: #E6F5EC;
    color: #1D5B34;
  }
  
  .type-repos-eternel {
    background: #F5F5F5;
    color: #333;
  }
  
  .type-autre {
    background: #F0EBDF;
    color: #6B7590;
  }
  
  .intention-text {
    font-style: italic;
    color: #1B2233;
  }
  
  .document-footer {
    text-align: center;
    padding: 20px 40px 30px;
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    color: #6B7590;
    border-top: 1px solid #E6E1D3;
  }
  
  .empty-state {
    text-align: center;
    padding: 40px;
    color: #6B7590;
    font-style: italic;
  }
</style>
</head>
<body>
<div class="document-container">
  <div class="document-header">
    <div class="logo">
      <img src="{{ $logoSrc }}" alt="Saint Michel Archange">
    </div>
    <p class="parish-name">Paroisse Saint Michel Archange de la BAE</p>
    <h1 class="document-title">Liste des Intentions</h1>
    <div class="info-bar">
      @if($type !== 'tous')
        Type : {{ \App\Models\Intention::TYPES[$type] ?? 'Tous' }} ·
      @endif
      @if($numeroSemaine)
        Semaine {{ $numeroSemaine }} ·
      @endif
      {{ $intentions->count() }} intention(s)
    </div>
  </div>
  
  <div class="document-body">
    @if($intentions->count() > 0)
      <table class="intention-table">
        <thead>
          <tr>
            <th style="width: 20%">Demandeur</th>
            <th style="width: 15%">Type</th>
            <th style="width: 65%">Intention</th>
          </tr>
        </thead>
        <tbody>
          @foreach($intentions as $intention)
            <tr>
              <td><strong>{{ $intention->demandeur }}</strong></td>
              <td>
                <span class="type-badge type-{{ str_replace('_', '-', $intention->type) }}">
                  {{ \App\Models\Intention::TYPES[$intention->type] ?? 'Autre' }}
                </span>
              </td>
              <td><span class="intention-text">{{ $intention->intention }}</span></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    @else
      <div class="empty-state">Aucune intention trouvée.</div>
    @endif
  </div>
  
  <div class="document-footer">
    <p>Paroisse Saint Michel Archange de la BAE</p>
    <p style="margin-top: 5px; font-size: 9px;">Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
  </div>
</div>
</body>
</html>