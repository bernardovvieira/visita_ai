<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Relatório Epidemiológico - Visita Aí</title>
  <style>
    @page {
      margin: 120px 50px 100px 50px;
    }

    body {
      font-family: 'Arial', sans-serif;
      font-size: 12px;
      color: #222;
      line-height: 1.6;
      position: relative;
    }

    header {
      position: fixed;
      top: -100px;
      left: 0;
      right: 0;
      text-align: center;
      padding-bottom: 8px;
      border-bottom: 2px solid #0e4a76;
    }

    header h1 {
      font-size: 18px;
      margin: 0;
      color: #0e4a76;
      text-transform: uppercase;
    }

    header h2 {
      font-size: 13px;
      margin-top: 4px;
      font-weight: normal;
    }

    footer {
      position: fixed;
      bottom: -60px;
      left: 0;
      right: 0;
      text-align: center;
      font-size: 10px;
      color: #555;
      border-top: 1px solid #ccc;
      padding-top: 6px;
    }

    .page-number:after {
      content: "Página " counter(page);
    }

    h2 {
      font-size: 14px;
      text-transform: uppercase;
      border-left: 5px solid #0e4a76;
      padding-left: 10px;
      margin-top: 40px;
      margin-bottom: 10px;
      color: #0e4a76;
    }

    h3 {
      font-size: 12.5px;
      margin-top: 30px;
      color: #333;
    }

    p {
      text-align: justify;
      margin: 10px 0;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin: 20px 0;
      font-size: 11.5px;
    }

    th, td {
      border: 1px solid #999;
      padding: 6px 8px;
    }

    th {
      background-color: #e9f2fa;
      text-align: center;
      font-weight: bold;
    }

    .img-container {
      text-align: center;
      margin: 40px 0 10px;
    }

    .img-container img {
      max-width: 65%;
      border: 1px solid #ccc;
    }

    .descricao {
      font-size: 10px;
      text-align: center;
      color: #666;
      margin-top: 6px;
    }
  </style>
</head>
<body>

<header>
  <h1>{{ $titulo }}</h1>
  <h2 style="border-left: none">Município de {{ $visitas->first()->local->loc_cidade ?? 'Município' }} - {{ $visitas->first()->local->loc_estado ?? 'UF' }}</h2>
</header>

<footer>
  <div class="page-number"></div>
  Gerado automaticamente em {{ now()->format('d/m/Y H:i') }} pelo Sistema Visita Aí.
</footer>

<main>
  <p style="margin-bottom: 25px;">
    @if ($data_inicio === $data_fim)
      Data da visita: <strong>{{ \Carbon\Carbon::parse($data_inicio)->format('d/m/Y') }}</strong>
    @else
      Período selecionado: <strong>{{ \Carbon\Carbon::parse($data_inicio)->format('d/m/Y') }}</strong> a
      <strong>{{ \Carbon\Carbon::parse($data_fim)->format('d/m/Y') }}</strong>
    @endif
    <br>
    Bairro filtrado: <strong>{{ $bairro ?: 'Todos os bairros' }}</strong>
  </p>

  <h2>1. Introdução</h2>
  <p>
    Este documento apresenta os dados epidemiológicos do município de <strong>{{ $visitas->first()->local->loc_cidade ?? 'Município' }}</strong>, consolidando informações coletadas em visitas técnicas realizadas por agentes de saúde. Seu objetivo é auxiliar o planejamento estratégico e ações preventivas.
  </p>

  <h2>2. Dados Gerais</h2>
  <p>
    @if ($titulo === 'Relatório de Visita Individual')
      Esta seção descreve os dados detalhados de uma única visita epidemiológica realizada.
    @else
      @if ($visitas->count() === 1)
        Foi registrada <strong>1</strong> visita no período selecionado.
      @else
        Foram registradas <strong>{{ $visitas->count() }}</strong> visitas únicas no período selecionado.
      @endif
    @endif
    @if (!empty($doencaMaisFrequente['nome']))
      A doença mais frequente foi <strong>{{ $doencaMaisFrequente['nome'] }}</strong>, com <strong>{{ $doencaMaisFrequente['quantidade'] }}</strong> ocorrência{{ $doencaMaisFrequente['quantidade'] !== 1 ? 's' : '' }}.
    @endif
  </p>

  <h2>3. Doenças Monitoradas</h2>
  <table>
    <thead>
      <tr>
        <th>Doença</th>
        <th>Sintomas</th>
        <th>Transmissão</th>
        <th>Medidas de Controle</th>
      </tr>
    </thead>
    <tbody>
      @foreach(\App\Models\Doenca::all() as $doenca)
        <tr>
          <td>{{ $doenca->doe_nome }}</td>
          <td>{{ is_array($doenca->doe_sintomas) ? implode(', ', $doenca->doe_sintomas) : $doenca->doe_sintomas }}</td>
          <td>{{ is_array($doenca->doe_transmissao) ? implode(', ', $doenca->doe_transmissao) : $doenca->doe_transmissao }}</td>
          <td>{{ is_array($doenca->doe_medidas_controle) ? implode(', ', $doenca->doe_medidas_controle) : $doenca->doe_medidas_controle }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h2>4. Visitas Realizadas</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Data</th>
        <th>Endereço</th>
        <th>Bairro</th>
        <th>Agente</th>
      </tr>
    </thead>
    <tbody>
      @foreach($visitas as $visita)
        <tr>
          <td>{{ $visita->vis_id }}</td>
          <td>{{ \Carbon\Carbon::parse($visita->vis_data)->translatedFormat('d/m/Y (l)') }}</td>
          <td>{{ $visita->local->loc_endereco }}, {{ $visita->local->loc_numero }}</td>
          <td>{{ $visita->local->loc_bairro }}</td>
          <td>{{ $visita->usuario->use_nome ?? '—' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <h2>5. Análises Visuais</h2>
  @foreach([
    'graficoDoencasBase64' => 'Distribuição das doenças registradas.',
    'graficoBairrosBase64' => 'Número de visitas por bairro.',
    'graficoZonasBase64' => 'Quantidade de visitas por zona (Urbana/Rural).',
    'graficoDiasBase64' => 'Evolução do número de visitas ao longo dos dias.',
    'graficoInspBase64' => 'Total de inspeções por tipo de depósito.',
    'graficoTratamentosBase64' => 'Distribuição das formas de tratamento aplicadas.',
    'mapaCalorBase64' => 'Mapa de calor dos locais com visitas registradas.'
  ] as $grafico => $descricao)
    @if(isset($$grafico) && $$grafico)
      <div class="img-container">
        <img src="{{ $$grafico }}" alt="Gráfico">
        <p class="descricao">{{ $descricao }}</p>
      </div>
    @endif
  @endforeach

  <h2>6. Conclusão</h2>
  <p>
    Reforça-se a importância da vigilância contínua nas áreas com maior incidência e a adoção de campanhas educativas. Os dados aqui apresentados subsidiam ações de prevenção e resposta imediata a surtos no município.
  </p>
</main>
</body>
</html>