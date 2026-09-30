<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Notificación USB</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333;">
    <h2>Universidad Simón Bolívar - Sistema de Solicitudes</h2>
    <p>Estimado(a) usuario(a),</p>
    <p>{{ $detalles['mensaje'] }}</p>
    @isset($detalles['codigo_radicado'])
        <p><strong>Código de Radicado:</strong> {{ $detalles['codigo_radicado'] }}</p>
    @endisset
    <br>
    <p>Atentamente,<br><strong>Gestión Institucional</strong></p>
</body>
</html>
