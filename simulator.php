<?php


// to do list

//Initialiser une matrice d'allocation des ressources radio
//Gérer l'arivée de nouvelles communications (avec différentes tailles de données et schémas de codage
//allouer les ressources radio (sous porteuse) aux communications en cours
//affficher les informations sur l'arrivée de nouvelles communications et associer une couleur différente à chacune d'elles
// mettre à jour la progression dans le temps en faisant glisser les colonnes de la matrice d'allocation



class Simulator {
    private $subcarriers;
    private $subframes;
    private $allocationMatrix;

    public function __construct($subcarriers, $subframes) {
        $this->subcarriers = $subcarriers;
        $this->subframes = $subframes;
        $this->initializeMatrix();
    }

    private function initializeMatrix() {
        $this->allocationMatrix = array();
        for ($i = 0; $i < $this->subcarriers; $i++) {
            $this->allocationMatrix[$i] = array();
            for ($j = 0; $j < $this->subframes; $j++) {
                $this->allocationMatrix[$i][$j] = 0;
            }
        }
    }

    public function newCommunication($size, $codingScheme) {
        // Implement the arrival mechanisms of new communications with different data sizes and coding schemes.
    }

    public function allocateResources() {
        // Implement the carrier allocation, according to asynchronous heterogeneous traffic data.
    }

    public function displayInformation() {
        // Display all the information about the new communication arrival and associate different color to each of them.
    }

    public function updateTimeProgression() {
        // Update the allocation matrix to show the time progression.
    }
}

// Create a new simulator with a given number of sub-carriers and sub-frames.
$simulator = new Simulator(10, 10);

