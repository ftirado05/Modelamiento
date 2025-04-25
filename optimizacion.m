fid = fopen('entrada.txt');
vel = str2num(fgetl(fid));
consumo = str2num(fgetl(fid));
fclose(fid);

p = polyfit(vel, consumo, 2);
f = @(x) polyval(p, x);
optima = fminbnd(f, min(vel), max(vel));

fid_out = fopen('salida.txt', 'w');
fprintf(fid_out, '%.2f\n', optima);
fclose(fid_out);
