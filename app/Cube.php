<?php

namespace App;

class Cube 
{
    public $cube;
    
    public function inicializarcube($n)
    {
        for ($i = 1; $i <= $n; $i++) {
            for ($j = 1; $j <= $n; $j++) {
                for ($k = 1; $k <= $n; $k++) {
                    $this->cube[$i][$j][$k] = 0;
                }
            }
        }
		return $this->cube;
    }
    public function updateBloque($x, $y, $z, $value)
    {
        $this->cube[$x][$y][$z] = $value;
    }

    public function sumatoria($x1, $y1, $z1, $x2, $y2, $z2)
    {
        $sum = 0;
        for ($i = $x1; $i <= $x2; $i++) {
            for ($j = $y1; $j <= $y2; $j++) {
                for ($k = $z1; $k <= $z2; $k++) {
                    $sum += $this->cube[$i][$j][$k];
                }
            }
        }
        return $sum;
    }
}
