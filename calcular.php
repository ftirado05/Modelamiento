<?php
header('Content-Type: application/json'); // Para retornar JSON

$vel = array_map('floatval', explode(',', $_POST['vel']));
$consumo = array_map('floatval', explode(',', $_POST['consumo']));

// Guardar archivo de entrada
$entrada = implode(',', $vel) . "\n" . implode(',', $consumo);
file_put_contents("entrada.txt", $entrada);

// Ejecutar Octave
$output = shell_exec("octave optimizacion.m");

// Leer resultado y curva generada por Octave
$optima = trim(file_get_contents("salida.txt"));
$curva = [];
$puntos_curva = file("curva.txt", FILE_IGNORE_NEW_LINES);
foreach ($puntos_curva as $punto) {
    list($x, $y) = explode(',', $punto);
    $curva[] = ['x' => (float)$x, 'y' => (float)$y];
}

// Calcular consumo en el punto óptimo (para el gráfico)
$consumo_optimo = null;
foreach ($curva as $punto) {
    if (abs($punto['x'] - $optima) < 0.01) {
        $consumo_optimo = $punto['y'];
        break;
    }
}

echo json_encode([
    'optima' => $optima,
    'puntos' => $vel,
    'consumos' => $consumo,
    'curva' => $curva,
    'consumo_optimo' => $consumo_optimo
]);
?>