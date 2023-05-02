<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulateur OFDMA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css.css" />
   
    <script>
        async function startSimulation() {
            const subcarriers = document.getElementById('subcarriers').value;
            const subframes = document.getElementById('subframes').value;

            const response = await fetch('simulator.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ subcarriers, subframes })
            });

            const result = await response.json();
            displayResults(result);
        }

        function displayResults(result) {
            // Display the simulation results here, e.g., the allocation matrix, etc.
            const resultsContainer = document.getElementById('results');
            resultsContainer.innerHTML = `<pre>${JSON.stringify(result, null, 2)}</pre>`;
        }
    </script>



</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark navbar-custom">
        <div class="container">
        <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item">
                    <img src="logos_UTBM.png">
                    </li>
                   
                </ul>
            </div><br>

            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="simulatorOFDMA.php">Simulator</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="documentation.php">Annexe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Contactus.php">Contact Us</a>
                    </li>
                </ul>
            </div>

        </div>
    </nav>

    <h1>OFDMA Simulator</h1>

    <section class="container mt-4">
    <div class="row2">
        <div class="col-md-8 offset-md-2">
            <p class="text-justify">
            This OFDMA simulator allows you to simulate the transmission of downlink data from a single antenna to a set of user devices within a cell. It takes into account carrier allocation and the arrival mechanisms of new communications with different data sizes and various coding schemes. Users can customize the number of sub-carriers and sub-frames to initiate the simulation. The results include the state of radio resource allocation across the cells, represented in the form of a matrix.            </p>
        </div>
    </div>
</section>



    <div class="containersimulation">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="mb-3">
                    <label for="subcarriers" class="form-label">Subcarriers:</label>
                    <input type="number" class="form-control" id="subcarriers" name="subcarriers" min="0" required>
                </div>
                <div class="mb-3">
                    <label for="subframes" class="form-label">Subframes:</label>
                    <input type="number" class="form-control" id="subframes" name="subframes" min="0" required>
                </div>
                <button class="btn btn-custom" type="button" onclick="startSimulation()">Simulate</button>

            </div>
        </div>
    </div>
    <div id="results" class="results container"><!--resultat renvoyer par php--></div>



    <footer class="footer mt-auto py-3 bg-light mx-0">

  <div class="container">
  <div class="row footer-row mx-0 bg-transparent">
      <div class="col-md-4">
        <h5>Ressources</h5>
        <ul class="list-unstyled">
          <li><a href="https://www.example.com/documentation">Documentation</a></li>
          <li><a href="https://www.example.com/support">Support</a></li>
          <li><a href="https://www.example.com/faq">FAQ</a></li>
        </ul>
      </div>
      <div class="col-md-4">
        <h5>About the Authors</h5>
        <p>The engineering students in network infrastructure design and deployment.</p>
        <p>Maryem Meziane : <a href="mailto:maryem.meziane@utbm.fr">Maryem.meziane@utbm.fr</a></p>
        <p>Gokdeniz Albuzlu : <a href="mailto:gokdeniz.albuzlu@utbm.fr">Gokdeniz.albuzlu@utbm.fr</a></p>

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




