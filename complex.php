<?php 


class Complex {
    private $real;
    private $imaginary;

    public function __construct($real, $imaginary) {
        $this->real = $real;
        $this->imaginary = $imaginary;
    }

    public function getReal() {
        return $this->real;
    }

    public function getImaginary() {
        return $this->imaginary;
    }

    public function multiply($scalar) {
        if (is_numeric($scalar)) {
            $this->real *= $scalar;
            $this->imaginary *= $scalar;
        } else if ($scalar instanceof Complex) {
            $realPart = $this->real * $scalar->getReal() - $this->imaginary * $scalar->getImaginary();
            $imaginaryPart = $this->real * $scalar->getImaginary() + $this->imaginary * $scalar->getReal();
            $this->real = $realPart;
            $this->imaginary = $imaginaryPart;
        } else {
            throw new InvalidArgumentException('Invalid scalar value');
        }
    }

    public function toString() {
        return $this->real . ($this->imaginary >= 0 ? '+' : '-') . abs($this->imaginary) . 'i';
    }
}


?>