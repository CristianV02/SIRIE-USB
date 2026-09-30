<!DOCTYPE html>
html>
<head>
    <meta charset="utf-8">
    <title>Oficio de Resolución - USB</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; margin: 30px; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h3 { margin: 0; color: #800000; }
        .content { margin-top: 20px; line-height: 1.6; }
        .footer { margin-top: 50px; text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h3>UNIVERSIDAD SIMÓN BOLÍVAR - EXTENSIÓN CÚCUTA</h3>
        <p>Sistema Institucional de Reportes e Ideas Estudiantiles</p>
        <hr>
    </div>
    <div class="content">
        <p><strong>Fecha de Emisión:</strong> {{ date('d/m/Y') }}</p>
        <p><strong>Código de Radicado:</strong> {{ $solicitud->codigo_radicado }}</p>
        <p><strong>Código Institucional:</strong> {{ $solicitud->codigo_institucional }}</p>
        <p><strong>Tipo de Solicitud:</strong> {{ $solicitud->tipo }}</p>
        <br>
        <h4>Asunto: Constancia Formal de Resolución de Caso</h4>
        <p>Por medio del presente documento, se da constancia formal de que el caso radicado bajo el código <strong>{{ $solicitud->codigo_radicado }}</strong> ha sido debidamente procesado, revisado y cerrado de manera oficial por las directivas institucionales.</p>
        <p><strong>Detalle de la resolución / Observaciones:</strong><br>{{ $observaciones }}</p>
    </div>
    <div class="footer">
        <p>Atentamente,</p>
        <br><br>
        <p><strong>Dirección / Coordinación Académica</strong><br>Universidad Simón Bolívar</p>
    </div>
</body>
</html>
