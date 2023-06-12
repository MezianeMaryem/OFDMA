<!DOCTYPE html>
<html>
<head>
  <title>Graphique OFDMA - Domaine de Fréquence par Temps</title>
  <style>
    body { margin: 0; }
    #canvas-container { width: 800px; height: 600px; margin: auto; margin-top: 100px; }
    #input-container { width: 800px; margin: auto; margin-top: 20px; text-align: center; }
    #user-container { width: 800px; margin: auto; margin-top: 20px; text-align: center; }
    .user { margin: 10px; color: red;}
    .timestamp { color: red; font-weight: bold; }
    .color-legend {
  display: flex;
  flex-wrap: wrap;
  margin-top: 10px;
}

.containersimulation {
    overflow: auto;
    height: 500px; /* Adjust this value according to your needs */
  }
.custom-image {
  width: 90%;
  height: 400px;
  text-align: center;
  margin-left:40px ;
}

.utbm{
  width: 500px;
  height: auto;
}
.color-label {
  width: 100px;
  height: 20px;
  margin-right: 10px;
  margin-bottom: 5px;
  text-align: center;
  line-height: 20px;
  font-size: 12px;
}
.cube-label{
margin-top: 5px;
  margin-right: 10px;
  margin-bottom: 5px;
  text-align: left;
  line-height: 20px;
  font-size: 12px;
}

.custom-size{
  
  font-size: 30px;
}

.cubes-container{
  font-size: 30px;

}

#navbarNav{
 width: 100%;
 height: auto;
}

  </style>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/file-saver@2.0.5/dist/FileSaver.min.js"></script> <!--File saver liberary javascript to export data to excel-->
    
    <link rel="stylesheet" type="text/css" href="css.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css">

</head>
<body>


<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                <a href="https://www.utbm.fr">  <img src="logos_UTBM.png" class="utbm"></a>
                    </li>
                   
                </ul>
            </div><br>

            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Simulator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="https://www.gta.ufrj.br/ensino/eel879/trabalhos_vf_2014_2/rafaelreis/introduction.html">Annexe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ContactUs.php">Read me</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>


    <h1 >   OFDMA Simulator  </i>
 </i></h1>

<section class="container mt-4">
<div class="row2">
    <div class="col-md-8 offset-md-2">
        <p class="text-justify">
        This OFDMA simulator allows you to simulate the transmission of downlink data from a single antenna to a set of user devices within a cell. It takes into account carrier allocation and the arrival mechanisms of new communications with different data sizes and various coding schemes. Users can customize the number of sub-carriers and sub-frames to initiate the simulation. The results include the state of radio resource allocation across the cells, represented in the form of a matrix.            </p>
    </div>
    <div id="image-container">
  <img src="graph.jpg" alt="Ma image" class="custom-image">
</div>
</div>
</section>



<div class="containersimulation">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <div class="mb-3">

         


            
                <label for="subcarriers" class="form-label">Subcarriers:</label>
                <select name="" class="form-control" id="subcarriers" required>
    <option value="72" disabled>--Please choose an option--</option>
    <option value="72">72</option>
    <option value="180">180</option>
    <option value="300">300</option>
    <option value="600">600</option>
    <option value="900">900</option>
</select>
            <br>
                <label for="subframes" class="form-label">Subframes</label>
  
                <select name="" class="form-control" id="subframes" required>

    <option value="15" disabled>-- 1 Subframes = 2 RB --</option>
    <option value="15">3</option>
    <option value="40">8</option>
    <option value="65">13</option>
    <option value="190">38</option>
    <option value="250">50</option>
</select>
                <br><br> 
                <button class="btn btn-primary" onclick="startSimulation()">Simulate</button>
 
  <button  class="btn btn-primary" onClick="window.location.href=window.location.href">Reset</button>
           
      
            </div>
        </div>

       


    </div>
    <div id="results" class="results container"><!--resultat renvoyer par php-->
    <h2>Result</h2>

</div>


</div>


  <div id="user-container" class="results container" > </div>

  
 <script>

var subcarriersInput = document.getElementById('subcarriers');
    var subframesInput = document.getElementById('subframes');



//alert(subcarriersInput);

    var simulations = [];

    // Tableau des couleurs disponibles
    var colors = [
      0xffffff,  // 
      0xff0000,  // Rouge
      0x00ff00,  // Vert
      0x0000ff,  // Bleu
      0xffff00,  // Jaune
      0xff00ff,  // Magenta
      0x00ffff,  // Cyan
      0xff8000,  // Orange
      0x008000,  // Vert foncé
      0x800080   // Violet
    ];

    function startSimulation() {
      var subcarriers = parseInt(subcarriersInput.value);
      var subframes = parseInt(subframesInput.value);
      var numUsers = 1;

      subcarriers=Math.trunc(subcarriers/10);

      var amplitudeData = [];

      for (var user = 0; user < numUsers; user++) {
        var amplitudeMatrix = [];
        for (var subcarrier = 0; subcarrier < subcarriers; subcarrier++) {
          var subcarrierData = [];
          for (var subframe = 0; subframe < subframes; subframe++) {
            subcarrierData.push(Math.floor(Math.random() * colors.length));
          }
          amplitudeMatrix.push(subcarrierData);
        }
        amplitudeData.push(amplitudeMatrix);
      }

      var timestamp = new Date().toLocaleString();

      simulations.unshift({
        timestamp: timestamp,
        subcarriers: subcarriers,
        subframes: subframes,
        numUsers: numUsers,
        amplitudeData: amplitudeData
      });

      // Affichage des informations de la simulation
      var userContainer = document.getElementById('user-container');
      userContainer.innerHTML = ''; // Supprimer le contenu précédent

      var titleElement = document.createElement('h2');
     // titleElement.innerText = 'Anciennes simulations';
      userContainer.appendChild(titleElement);

      for (var i = 0; i < simulations.length; i++) {
        var simulation = simulations[i];
        var userElement = document.createElement('div');
        userElement.classList.add('user');
        userElement.id = 'user-' + i;
        userElement.innerText ='- lines ==>  Subcarriers: ' + subcarriersInput.value + ', Columns ==> Time slots :  ' + simulation.subframes + ' - Simulation time: ' + simulation.timestamp;
        userContainer.appendChild(userElement);

        var userElement = document.createElement('div');
        userElement.classList.add('space');
        userElement.innerText = ' ';
        userContainer.appendChild(userElement);

        var userElement = document.createElement('div');
        userElement.classList.add('space');
        userElement.innerText = ' ';
        userContainer.appendChild(userElement);
        
        // Créer un conteneur pour le graphique
        var canvasContainer = document.createElement('div');
        canvasContainer.id = 'canvas-container-' + i;
        userElement.appendChild(canvasContainer);

        // Créer un conteneur pour les cubes et les étiquettes
        var cubesContainer = document.createElement('div');
        cubesContainer.classList.add('cubes-container');
        cubesContainer.setAttribute('id','labelcube');
        cubesContainer.innerText=' Display graphic informations ' ;
        cubesContainer.tabIndex = 0;  

        // Create a new i element for the Font Awesome icon
        var icon = document.createElement('i');
        icon.classList.add('fas', 'fa-caret-down','custom-size');


      
        // Append the icon to the cubesContainer
        cubesContainer.appendChild(icon);
        userElement.appendChild(cubesContainer);

        // Créer le graphique de la simulation
        createGraph(i, simulation, cubesContainer);
      }
    }

    function createGraph(index, simulation, cubesContainer) {
      var subcarriers = simulation.subcarriers;
      var subframes = simulation.subframes;
      var numUsers = simulation.numUsers;
      var amplitudeData = simulation.amplitudeData;

      var sceneWidth = 800;
      var sceneHeight = 600;
      var cubeSize = Math.min(sceneWidth / subframes, sceneHeight / (subcarriers * numUsers));

      var scene = new THREE.Scene();
      var camera = new THREE.PerspectiveCamera(75, sceneWidth / sceneHeight, 0.1, 1000);
      var renderer = new THREE.WebGLRenderer();
          
renderer.setClearColor(0xFFFFFF, 1); // Ajouter cette ligne pour définir la couleur d'arrière-plan en blanc.
renderer.setSize(sceneWidth, sceneHeight);
      renderer.setSize(sceneWidth, sceneHeight);
      var canvasContainer = document.getElementById('canvas-container-' + index);
      canvasContainer.appendChild(renderer.domElement);






      var axisLength = Math.max(sceneWidth, sceneHeight) / 2;
      var xAxis = new THREE.Vector3(axisLength, 0, 0);
      var yAxis = new THREE.Vector3(0, axisLength, 0);
      var zAxis = new THREE.Vector3(0, 0, axisLength);
      var axesHelper = new THREE.AxesHelper(axisLength);
      axesHelper.material.setValues({ color: 0xff0000 });
      axesHelper.position.set(0, -(numUsers * subcarriers * cubeSize), 0);
      scene.add(axesHelper);

      for (var user = 0; user < numUsers; user++) {
        for (var subcarrier = 0; subcarrier < subcarriers; subcarrier++) {
          for (var subframe = 0; subframe < subframes; subframe++) {
            var cube = new THREE.Mesh(new THREE.BoxGeometry(cubeSize, cubeSize, cubeSize),
              new THREE.MeshBasicMaterial({ color: colors[amplitudeData[user][subcarrier][subframe]] }));
            cube.position.set(subframe * cubeSize, -(user * subcarriers + subcarrier) * cubeSize, 0);
            scene.add(cube);

//alert(cube.material.color.getHexString());


var SNR = Math.random()*( 27- 0 + 1);
       SNR= SNR.toFixed(2);
     // console.log(SNR);

        switch(true){
            case (SNR >=0 && SNR <1.5) :
            var description = (" --Spectral Efficiency [bps/Hz] : 0.67 -- Modulation : QPSK -- Coding rate : 1/3 ");
            break;

            case (SNR >=1.5 && SNR <4) :
              var description = (" --Spectral Efficiency [bps/Hz] : 1.00 -- Modulation : QPSK -- Coding rate : 1/2 ");
              break;

            case (SNR >= 4 && SNR <5) :
              var description = (" --Spectral Efficiency [bps/Hz] : 1.30 -- Modulation : QPSK -- Coding rate : 2/3 ");
              break;
            
            case (SNR >= 5 && SNR <5.5) : 
              var description = (" --Spectral Efficiency [bps/Hz] : 1.50 -- Modulation : QPSK -- Coding rate : 3/4 ");
              break ; 

            case (SNR >=5.5 && SNR < 7.0) :
              var description = (" --Spectral Efficiency [bps/Hz] : 1.60 -- Modulation : QPSK -- Coding rate : 4/5 ");
              break;

            case (SNR >= 7.0 && SNR < 10) :
              var description = (" --Spectral Efficiency [bps/Hz] : 2.00 -- Modulation : 16QPSK -- Coding rate : 1/2 ");
              break;
            
            case (SNR >= 10 && SNR < 11.5) :
              var description = (" -- Spectral Efficiency [bps/Hz] : 2.67 -- Modulation : 16QPSK -- Coding rate : 2/3 ");
              break;

              case (SNR >= 11.5 && SNR < 13) :
              var description = (" --Spectral Efficiency [bps/Hz] : 3.00 -- Modulation : 16QPSK -- Coding rate : 3/4 ");
              break; 

              case (SNR >= 13 && SNR < 15) :
              var description = (" --Spectral Efficiency [bps/Hz] : 3.20 -- Modulation : 16QPSK -- Coding rate : 4/5 ");
              break;
 
              case (SNR >= 15 && SNR < 17) :
              var description = (" --Spectral Efficiency [bps/Hz] : 4.00 -- Modulation : 64QPSK -- Coding rate : 2/3 ");
              break; 
                
              case (SNR >= 17 && SNR < 18.5) :
              var description = (" --Spectral Efficiency [bps/Hz] : 4.50 -- Modulation : 64QPSK -- Coding rate : 3/4 ");
              break;

              case (SNR >= 18.5 && SNR < 20) :
              var description = (" --Spectral Efficiency [bps/Hz] : 4.80 -- Modulation : 64QPSK -- Coding rate : 4/5 ");
              break;

              case (SNR >= 20 && SNR < 22.0) :
              var description = (" --Spectral Efficiency [bps/Hz] : 5.33   -- Modulation : 256QPSK -- Coding rate : 2/3 ");
              break;

              case (SNR >= 22 && SNR <= 24.0) :
              var description = (" --Spectral Efficiency [bps/Hz] : 6.00   -- Modulation : 256QPSK -- Coding rate : 3/4 ");
              break;

              case (SNR >= 24 && SNR <= 27.0) :
              var description = (" --Spectral Efficiency [bps/Hz] : 6.40   -- Modulation : 256QPSK -- Coding rate : 4/5 ");
              break;

              default:
              var description = (" --Spectral Efficiency [bps/Hz] : 7.00   -- Modulation : 256QPSK -- Coding rate : 7/8 ");
             
           }










            // Ajouter une étiquette pour chaque cube
            var cubeLabel = document.createElement('div');
            cubeLabel.classList.add('cube-label');
            // add icon and text 
            cubeLabel.style.display="none";
if (cube.material.color.getHexString()!='ffffff')
            cubeLabel.innerText = 'Cube [' + subcarrier + ', ' + subframe + '] : ' +'-- SNR [dB] '+SNR +' '+ description;
else 
            cubeLabel.innerText = 'Cube [ Empty ]';



            cubesContainer.appendChild(cubeLabel);
          }
        }
      }

// Adding the event listener to cubesContainer
cubesContainer.addEventListener('click', function() {
    var labels = cubesContainer.getElementsByClassName('cube-label');
    for(var i = 0; i < labels.length; i++) {
      labels[i].style.display = (labels[i].style.display == 'none') ? 'block' : 'none';
    }
});


      camera.position.set(subframes * cubeSize / 2, -((numUsers * subcarriers) * cubeSize) / 2, subcarriers * cubeSize * 2);
      camera.lookAt(new THREE.Vector3(subframes * cubeSize / 2, -((numUsers * subcarriers) * cubeSize) / 2, 0));

      function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
      }
      animate();
    }



  </script>
<br>
<br>


<footer class="footer mt-auto py-3 bg-light mx-0">

<div class="container">
<div class="row footer-row mx-0 bg-transparent">
    <div class="col-md-4">
      <h5>Ressources</h5>
      <ul class="list-unstyled">
        <li><a href="rapport/RI53 rapport.pdf">Documentation</a></li>
        <li><a href="rapport/2023_Topic_XL.pdf">Support</a></li>
        <li><a href="https://www.example.com/faq">FAQ</a></li>
      </ul>
    </div>
    <div class="col-md-4">
      <h5>About the Authors</h5>
      <p>The engineering students in network infrastructure design and deployment.</p>
      <p>Maryem Meziane : <a href="mailto:maryem.meziane@utbm.fr">Maryem.meziane@utbm.fr</a></p>
      <p>Gokdeniz Albuzlu : <a href="mailto:gokdeniz.albuzlu@utbm.fr">Gokdeniz.albuzlu@utbm.fr</a></p>
      <p> Brice VAN AKEN : <a href="mailto:brice.van-aken@utbm.fr">brice.van-aken@utbm.fr</a></p>
      <p> Jérémy KIEFFER : <a href="mailto:jeremy.kieffer@utbm.fr">jeremy.kieffer@utbm.fr</a></p>
    </div>

    <div class="col-md-4">
      <h5>Informations about the licence</h5>
      <p>This simulator is published under the MIT license. You can freely use, modify, and redistribute this software while adhering to the terms of the license.</p>
      <p><a href="https://opensource.org/licenses/MIT">Learn more about the MIT license</a></p>
    </div>
  </div>
</div>
</footer>
</body>
</html>
