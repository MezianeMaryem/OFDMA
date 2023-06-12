<?php
require 'complex.php';

$subcarriers = $_POST['subcarriers'];
$subframes = $_POST['subframes'];

class Simulator {
    private $subCarriers;
    private $subframes;
    private $userDevices;
    private $channels;
    private $modulationScheme;
    private $codingScheme;
    private  $fsploss;
    private $distance;
    private $modulationSchemes = [
        4 => "QPSK",
        8 => "8QAM",
        16 => "16QAM",
        64 => "64QAM",
        128 => "128QAM"
    ];
    private $codingSchemes = [
        1 => "Rate 1/2",
        2 => "Rate 2/3",
        3 => "Rate 3/4",
        4 => "Rate 5/6"
    ];
  private $fading_amplitude;
 private $received_power_with_shadowing;
private $channel_gain;

 public function __construct($subCarriers, $subFrames){
        $this -> subCarriers= $subCarriers;
        $this -> subframes= $subFrames;
        $this -> userDevices = array();
        $this -> channels = new Channel();

    }
    
    public function initializeSystem(){
        // step 1 : create user devices and set modulating and coding scheme
        $this ->createUserDevices();
        $this -> initializeModulationAndCodingSchemes();
        // calculate the loss
         $this -> calculate_fspl();
        
          $this ->simulate_rayleigh_fading();

        $this ->  simulate_shadowing();

       $this-> calculate_channel_gain();
        // step 2 display parameters
        $this -> displaySystemParameters();

   
        
    }

    private function CreateUserDevices(){
        // create user devices and set their parametrs en fonction des subframes et subcarriers
        for ($i=0; $i<$this->subframes; $i++)
        {
            $userDevices= new userDevice();
            $userDevices->setSubCarriers($this->subCarriers);
            $this -> userDevices[] = $userDevices;

        }
    } 

       // Méthode pour initialiser les schémas de modulation et de codage
       private function initializeModulationAndCodingSchemes() {
        // Initialiser les schémas en fonction des subframes et subcarriers
        if ($this->subframes >= 4 && $this->subCarriers >= 64) {
            $this->modulationScheme = $this->modulationSchemes[64];
            $this->codingScheme = $this->codingSchemes[4];
        } elseif ($this->subframes >= 2 && $this->subCarriers >= 16) {
            $this->modulationScheme = $this->modulationSchemes[16];
            $this->codingScheme = $this->codingSchemes[3];
        } elseif ($this->subframes >= 1 && $this->subCarriers >= 8) {
            $this->modulationScheme = $this->modulationSchemes[8];
            $this->codingScheme = $this->codingSchemes[2];
        } elseif ($this->subframes >= 1 && $this->subCarriers >= 4) {
            $this->modulationScheme = $this->modulationSchemes[128];
            $this->codingScheme = $this->codingSchemes[1];
        } else {
            $this->modulationScheme = $this->modulationSchemes[4];
            $this->codingScheme = $this->codingSchemes[1];
        }
    }

    function calculate_fspl(){
        $distance = 100;
        $frequency = 2.4e9;
        $c = 3e8; // Speed of light in meters per second
        $wavelength = $c/$frequency;
        $fspl = (4 * M_PI * $distance * $frequency) / ($c ** 2);
        $this-> fsploss =$fspl;
        
        return $fspl;   

    }
    
    function simulate_rayleigh_fading() {
        $real = rand(0, 1);
        $imaginary = rand(0, 1);
        $amplitude = new Complex($real, $imaginary);
        $amplitude->multiply(sqrt(0.5)); // Apply scaling factor
        $this -> fading_amplitude = $amplitude;
        return $amplitude;
    }
    
    function simulate_shadowing() {
        $received_power = 20; // Initial received power in dBm
        $shadowing_std_deviation = 3; // Standard deviation of shadowing in dB
        $shadowing_offset = rand(-$shadowing_std_deviation, $shadowing_std_deviation);
        $received_power += $shadowing_offset;
       $this -> received_power_with_shadowing =$received_power;
        return $received_power;
    }

    function calculate_channel_gain() {
        $this -> distance = 1;
       $this -> channel_gain = pow(10, (- $this->fsploss ) / 10) / pow($this->distance, 2);
      //  return $this -> channel_gain;

    // $this -> channel_gain = pow(10, (- $this->fsploss  + $this->fading_amplitude + $this -> received_power_with_shadowing) / 10) / pow($this->distance, 2);
    }
    
 
    private function displaySystemParameters(){
      //  header("location: simulatorOFDMA.php");
        echo "Subcarriers: " .$this->subCarriers . "<br>";
        echo "Subframes: " . $this->subframes . "<br>";
        echo "Number of User Devices: " . count($this->userDevices) . "<br>";
        echo "modulationScheme :" . $this -> modulationScheme . "<br>";
        echo "codingScheme :" . $this->codingScheme . "<br>";
        echo "Fspl :" . $this->fsploss . "<br>";
        echo "Fading Amplitude: " . $this->fading_amplitude->toString()."<br>";
        echo "Received Power with Shadowing: " . $this -> received_power_with_shadowing . " dBm <br>";
        echo "Channel Gain: " . $this ->channel_gain . " (linear scale) <br>";
        

    }



  
    
    //OFDMA use models as Free Space Path Loss (FSPL) , Two-Ray Ground Reflection Or Okumura-Hata. 
  
    
   
}

class UserDevice{

    private $subCarriers;
   
    public function setSubCarriers($subCarriers){
        $this->subCarriers=$subCarriers;   
    }

    public function getSubCarriers(){

        return $this->subCarriers;
    }
    
}

Class Channel {
    // representation du canal de la communication

}



$simulator = new Simulator($subcarriers, $subframes);
$simulator -> initializeSystem();


?>




