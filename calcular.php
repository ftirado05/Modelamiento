<?php
$vel = $_POST['vel'];
$consumo = $_POST['consumo'];

// Guardar archivo de entrada
$entrada = $vel . "\n" . $consumo;
file_put_contents("entrada.txt", $entrada);

// Ejecutar Octave desde la misma carpeta
$output = shell_exec("octave optimizacion.m");

// Leer resultado
if (file_exists("salida.txt")) {
    echo trim(file_get_contents("salida.txt"));
} else {
    echo "Error: No se generó salida.txt";
}
?>
