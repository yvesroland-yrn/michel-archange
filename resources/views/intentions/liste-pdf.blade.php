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
  
  .week-info {
    font-family: 'Inter', sans-serif;
    font-size: 11px;
    color: #6B7590;
    letter-spacing: 1px;
  }
  
  .document-body {
    padding: 30px 40px;
  }
  
  .day-section {
    margin-bottom: 30px;
  }
  
  .day-header {
    font-family: 'Cinzel', serif;
    font-size: 16px;
    font-weight: 600;
    color: #0B1B3A;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 2px solid #D4A937;
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .day-header.samedi {
    color: #1F8A70;
    border-color: #1F8A70;
  }
  
  .day-header.dimanche {
    color: #2748B8;
    border-color: #2748B8;
  }
  
  .intention-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 10px;
  }
  
  .intention-table th {
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 600;
    color: #6B7590;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 8px 10px;
    text-align: left;
    border-bottom: 1px solid #E6E1D3;
    background: #FAF7F0;
  }
  
  .intention-table td {
    padding: 10px;
    border-bottom: 1px solid #F0EBDF;
    vertical-align: top;
  }
  
  .intention-table tr:last-child td {
    border-bottom: none;
  }
  
  .type-badge {
    display: inline-block;
    padding: 3px 8px;
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
  
  .offrande {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    color: #D4A937;
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
    padding: 20px;
    color: #6B7590;
    font-style: italic;
  }
</style>
</head>
<body>
<div class="document-container">
  <div class="document-header">
    <div class="logo">
      <img src="{{ public_path('images/saint.jpg') }}" alt="Saint Michel Archange">
    </div>
    <p class="parish-name">Paroisse Saint Michel Archange de la BAE</p>
    <h1 class="document-title">Intentions de Messe</h1>
    <p class="week-info">Semaine {{ $numeroSemaine }}</p>
  </div>
  
  <div class="document-body">
    <!-- Samedi -->
    <div class="day-section">
      <div class="day-header samedi">
        <span><i class="bi bi-calendar-week"></i> SAMEDI</span>
        <span>{{ $samediIntentions->count() }} intention(s)</span>
      </div>
      @if($samediIntentions->count() > 0)
        <table class="intention-table">
          <thead>
            <tr>
              <th style="width: 15%">Demandeur</th>
              <th style="width: 15%">Type</th>
              <th style="width: 50%">Intention</th>
              <th style="width: 20%">Offrande</th>
            </tr>
          </thead>
          <tbody>
            @foreach($samediIntentions as $intention)
              <tr>
                <td><strong>{{ $intention->demandeur }}</strong></td>
                <td>
                  <span class="type-badge type-{{ str_replace('_', '-', $intention->type) }}">
                    {{ $intention->type_libelle }}
                  </span>
                </td>
                <td><span class="intention-text">{{ $intention->intention }}</span></td>
                <td class="offrande">{{ number_format($intention->offrande, 0, ',', ' ') }} FCFA</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">Aucune intention prévue pour le samedi</div>
      @endif
    </div>
    
    <!-- Dimanche -->
    <div class="day-section">
      <div class="day-header dimanche">
        <span><i class="bi bi-calendar-week"></i> DIMANCHE</span>
        <span>{{ $dimancheIntentions->count() }} intention(s)</span>
      </div>
      @if($dimancheIntentions->count() > 0)
        <table class="intention-table">
          <thead>
            <tr>
              <th style="width: 15%">Demandeur</th>
              <th style="width: 15%">Type</th>
              <th style="width: 50%">Intention</th>
              <th style="width: 20%">Offrande</th>
            </tr>
          </thead>
          <tbody>
            @foreach($dimancheIntentions as $intention)
              <tr>
                <td><strong>{{ $intention->demandeur }}</strong></td>
                <td>
                  <span class="type-badge type-{{ str_replace('_', '-', $intention->type) }}">
                    {{ $intention->type_libelle }}
                  </span>
                </td>
                <td><span class="intention-text">{{ $intention->intention }}</span></td>
                <td class="offrande">{{ number_format($intention->offrande, 0, ',', ' ') }} FCFA</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      @else
        <div class="empty-state">Aucune intention prévue pour le dimanche</div>
      @endif
    </div>
  </div>
  
  <div class="document-footer">
    <p>Paroisse Saint Michel Archange de la BAE • Semaine {{ $numeroSemaine }}</p>
    <p style="margin-top: 5px; font-size: 9px;">Document généré le {{ now()->format('d/m/Y à H:i') }}</p>
  </div>
</div>
</body>
</html>