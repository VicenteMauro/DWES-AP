<?php

class VehiculoCarrera
{
    protected string $marca;
    protected string $modelo;
    protected int $velocidad;
    protected int $combustible;

    public function __construct(string $marca, string $modelo, int $velocidad, int $combustible)
    {
        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->velocidad = $velocidad;
        $this->combustible = $combustible;
        echo "Vehiculo marca: $marca, modelo: $modelo, creado.<br>";
    }

    public function __destruct() {
        echo "El vehiculo $this->marca $this->modelo se ha retirado.<br>";
    }

    protected function consumirCombustible(): void
    {
        if ($this->combustible > 0) {
            $this->combustible -= 10;
        } else {
            echo "Combustible agotado.<br>";
        }
    }

    public function arrancar(): void
    {
        echo "<br>$this->marca $this->modelo ha arrancado.<br>";
    }

    public function acelerar(): void
    {
        if ($this->combustible > 0) {
            $this->velocidad += 20;
            $this->consumirCombustible();
            echo "$this->marca $this->modelo acelera a $this->velocidad km/h.<br>";
        } else {
            echo "$this->marca $this->modelo no tiene combustible.<br>";
        }
    }

    public function detener(): void
    {
        $this->velocidad = 0;
        echo "$this->marca $this->modelo se ha detenido.<br>";
    }

    public function mostrarEstado(): void
    {
        echo "Estado de $this->marca $this->modelo:<br>";
        echo "   Velocidad: $this->velocidad km/h<br>";
        echo "   Combustible: $this->combustible %<br><br>";
    }
}

class CocheGasolinaF1 extends VehiculoCarrera {
    private bool $alerones;

    public function __construct(string $marca, string $modelo, int $velocidad, int $combustible, bool $alerones) {
        parent::__construct($marca, $modelo, $velocidad, $combustible);
        $this->alerones = $alerones;
    }

    public function activarDRS(): void {
        if ($this->alerones) {
            echo "$this->marca $this->modelo activa DRS.<br>";
            $this->velocidad += 30;
            $this->consumirCombustible();
            echo "Velocidad aumentada a $this->velocidad km/h.<br>";
        } else {
            echo "$this->marca $this->modelo no puede activar el DRS.<br>";
        }
    }
}

class CocheElectricoF1 extends VehiculoCarrera {
    private int $bateria;

    public function __construct(string $marca, string $modelo, int $velocidad, int $combustible, int $bateria) {
        parent::__construct($marca, $modelo, $velocidad, $combustible);
        $this->bateria = $bateria;
    }

    public function recargar(): void {
        $this->bateria = 100;
        echo "$this->marca $this->modelo ha recargado la batería al 100%.<br>";
    }
}

// Ejemplos

$coche1 = new CocheGasolinaF1("Aston Martin", "AMR25", 0, 100, true);
$coche2 = new CocheElectricoF1("Masserati", "MCPura", 0, 100, 80);

$coche1->arrancar();
$coche1->acelerar();
$coche1->activarDRS();
$coche1->mostrarEstado();

$coche2->arrancar();
$coche2->acelerar();
$coche2->recargar();
$coche2->mostrarEstado();

$coche1->detener();
$coche2->detener();

?>