<?php
$file = 'datos.txt';
$data = file_exists($file) ? file($file, FILE_IGNORE_NEW_LINES) : [];
$Boton = isset($_GET['Boton']) ? $_GET['Boton'] : (isset($data[0]) ? $data[0] : 'N/A');
$Potenciometro = isset($_GET['Potenciometro']) ? $_GET['Potenciometro'] : (isset($data[1]) ? $data[1] : 'N/A');
$Movimiento = isset($_GET['Movimiento']) ? $_GET['Movimiento'] : (isset($data[2]) ? $data[2] : 'N/A');
file_put_contents($file, "$Boton\n$Potenciometro\n$Movimiento");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard IoT</title>
    <style>
        * {
            font-family: Arial, sans-serif;
            box-sizing: border-box;
        }
        body {
            background-color: #f4f4f4;
            text-align: center;
            padding: 20px;
        }
        h1 {
            color: #333;
        }
        .container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            width: 200px;
            text-align: center;
        }
        .value {
            font-size: 2em;
            font-weight: bold;
            color: #d62020;
        }
        .label {
            font-size: 1.2em;
            color: #555;
        }
        .iframe-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        iframe {
            border: 1px solid #ccc;
            border-radius: 10px;
        }
    </style>
    <script>
        function actualizarDatos() {
            fetch('datos.txt')
                .then(response => response.text())
                .then(text => {
                    let valores = text.split('\n');
                    document.getElementById('boton').innerText = valores[0] || 'N/A';
                    document.getElementById('potenciometro').innerText = valores[1] || 'N/A';
                    document.getElementById('movimiento').innerText = valores[2] || 'N/A';
                });
        }
        setInterval(actualizarDatos, 1000);
    </script>
</head>
<body onload="actualizarDatos()">
    <h1>📊 Dashboard de Sensores IoT</h1>
    <div class="container">
        <div class="card">
            <div class="label">🟢 Botón</div>
            <div class="value" id="boton">N/A</div>
        </div>
        <div class="card">
            <div class="label">🎛️ Potenciómetro</div>
            <div class="value" id="potenciometro">N/A</div>
        </div>
        <div class="card">
            <div class="label">📡 Movimiento</div>
            <div class="value" id="movimiento">N/A</div>
        </div>
    </div>
    <div class="iframe-container">
        <iframe width="450" height="260" src="https://thingspeak.com/channels/2847440/charts/1?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
        <iframe width="450" height="260" src="https://thingspeak.com/channels/2847440/charts/2?bgcolor=%23ffffff&color=%23d62020&dynamic=true&results=60&type=line&update=15"></iframe>
    </div>
</body>
</html>
