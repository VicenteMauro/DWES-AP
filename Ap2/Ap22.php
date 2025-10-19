<?php

class VehiculoCarrera
{
    protected string $marca;
    protected string $modelo;
    protected string $color;
    protected int $velocidad;
    protected int $combustible;
    protected int $velocidadMaxima;
    protected float $distanciaRecorrida;

    public function __construct(string $marca, string $modelo, string $color, int $combustible)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->color = $color;
        $this->velocidad = 0;
        $this->combustible = $combustible;
        $this->velocidadMaxima = rand(250, 300);
        $this->distanciaRecorrida = 0.0;
        echo "Vehículo $marca $modelo ($color) creado con velocidad máxima de {$this->velocidadMaxima} km/h.\n";
    }

    public function __destruct()
    {
        echo "El vehículo $this->marca $this->modelo se ha retirado.\n";
    }

    protected function consumirCombustible(): void
    {
        if ($this->combustible > 0) {
            $this->combustible -= 5;
        } else {
            echo "Combustible agotado.\n";
        }
    }

    public function acelerar(int $valorDado): void
    {
        if ($this->combustible <= 0) {
            echo "$this->marca $this->modelo no tiene combustible.\n";
            return;
        }

        $incremento = $valorDado * 5;
        $this->velocidad += $incremento;

        if ($this->velocidad > $this->velocidadMaxima) {
            $this->velocidad = $this->velocidadMaxima;
        }

        $this->consumirCombustible();
        echo "$this->marca $this->modelo acelera a $this->velocidad km/h.\n";
    }

    public function avanzar(): void
    {
        $metros = $this->velocidad / 3.6;
        $this->distanciaRecorrida += $metros;
        echo "$this->marca $this->modelo avanza $metros metros. Total: {$this->distanciaRecorrida} m.\n";
    }

    public function mostrarEstado(): void
    {
        echo "Estado de $this->marca $this->modelo ($this->color):\n";
        echo "   Velocidad: $this->velocidad km/h\n";
        echo "   Combustible: $this->combustible %\n";
        echo "   Distancia recorrida: {$this->distanciaRecorrida} m\n\n";
    }

    public function getDistancia(): float
    {
        return $this->distanciaRecorrida;
    }

    public function getNombre(): string
    {
        return "$this->marca $this->modelo ($this->color)";
    }
}

// Juego principal
echo "Bienvenido al juego de carreras F1 por turnos.\n";
$jugadores = (int) readline("Ingrese el número de jugadores (2-6): ");
while ($jugadores < 2 || $jugadores > 6) {
    $jugadores = (int) readline("Número inválido. Ingrese entre 2 y 6 jugadores: ");
}

$coches = [];

for ($i = 1; $i <= $jugadores; $i++) {
    echo "\nJugador $i:\n";
    $marca = readline("Marca del coche: ");
    $modelo = readline("Modelo del coche: ");
    $color = readline("Color del coche: ");
    $coches[] = new VehiculoCarrera($marca, $modelo, $color, 100);
}

$ganador = null;
$turno = 1;

while (!$ganador) {
    echo "\n--- Turno $turno ---\n";
    foreach ($coches as $coche) {
        echo "\nTurno de " . $coche->getNombre() . ":\n";
        echo "Presiona Enter para lanzar el dado...";
        fgets(STDIN);

        $dado = rand(1, 10);
        echo "Lanzamiento de dado: $dado\n";
        $coche->acelerar($dado);
        $coche->avanzar();
        $coche->mostrarEstado();

        if ($coche->getDistancia() >= 100) {
            $ganador = $coche->getNombre();
            break;
        }
    }
    $turno++;
}

echo "\n🏆 ¡El ganador es $ganador! Ha alcanzado los 100 metros.\n";

?>
