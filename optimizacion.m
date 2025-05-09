fid = fopen('entrada.txt');
vel = str2num(fgetl(fid));
consumo = str2num(fgetl(fid));
fclose(fid);

p = polyfit(vel, consumo, 2);
f = @(x) polyval(p, x);
optima = fminbnd(f, min(vel), max(vel));

% Generar puntos para la curva
x_curva = linspace(min(vel), max(vel), 100);
y_curva = arrayfun(f, x_curva);

% Guardar resultado y curva
fid_out = fopen('salida.txt', 'w');
fprintf(fid_out, '%.2f\n', optima);
fclose(fid_out);

fid_curve = fopen('curva.txt', 'w');
for i = 1:length(x_curva)
    fprintf(fid_curve, '%.2f,%.2f\n', x_curva(i), y_curva(i));
end
fclose(fid_curve);