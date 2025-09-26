<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sagitta et Arcus</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>

  <!-- HEADER -->
  <header>
    <div class="container">
      <div class="logo">
        <img src="Media/SetA-Logo.jpg" alt="Sagitta et Arcus Logo" height="600" />
      </div>
      <nav>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Agenda</a></li>
          <li><a href="#">Nieuws</a></li>
          <li><a href="lidworden.html#">Lid worden</a></li>
          <li><a href="#">Over ons</a></li>
          <li><a href="index.php">Contact</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <!-- BANNER 
    /*<section class="banner">
    <div class="container">
    </div>
  </section> -->


  <!-- NIEUWS -->
  <section class="nieuws">
    <div class="container nieuws-grid">
      <div class="nieuws-item" id="nieuws1"></div>
      <div class="nieuws-item" id="nieuws2"></div>
      <div class="nieuws-item" id="nieuws3"></div>
    </div>
  </section>


  <!-- OVER ONS -->
  <section class="about">
    <div class="container">
      <h2>Over Sagitta et Arcus</h2><hr>
      <p>
        Sagitta et Arcus is eind jaren 80 opgericht in Nijverdal. 
        De vereniging heeft als doelstelling om de handboogsport in al zijn aspecten te bevorderen. 
        De vereniging is aangesloten bij de Nederlandse Handboog Bond (NHB) wat ons de mogelijkheid biedt om aan landelijke wedstrijden deel te nemen.
      </p>
      <div class="image-box">
        <img src="Untxdfghnitled.png" alt="Over ons afbeelding" />
      </div>
    </div>
  </section>

  <!-- AGENDA -->
  <section class="agenda">
  <h2 class="container agenda-grid">Agenda</h2>
  <br> 
    <div class="container agenda-grid">
      <div id="agenda1" class="agenda-item"></div>
      <div id="agenda2" class="agenda-item"></div>
      <div id="agenda3" class="agenda-item"></div>
      <div id="agenda4" class="agenda-item"></div>
    </div>
  </section>



  <!-- SPONSOREN -->
  <section class="sponsoren">
    <div class="container">
      <h2>Sponsoren</h2>
      <!-- Logo’s of blokken voor sponsoren -->
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="footer-logo">
        <img src="Media/SetA-Logo.jpg" alt="Sagitta et Arcus Logo" height="600" />
      </div>
      <div class="footer-links">
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Nieuws</a></li>
          <li><a href="#">Agenda</a></li>
          <li><a href="#">Over ons</a></li>
          <li><a href="lidworden.html">Lid worden</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="footer-socials">
        <p>Socials</p>
        <a href="https://www.facebook.com/sagittaetarcus.nijverdal" target="_blank"><img src="Media/SetA-PictoFB.jpg" alt="FaceBook" height="28" /></a>
        <!-- Social media icons of links hier -->
      </div>
      <div class="copyright">
        <p>Copyright © 2025 Sagitta et Arcus</p>
      </div>
    </div>
  </footer>


<?php
  echo "<script>\n";
  echo "async function DisplayNews() {\n";
  $spreadsheet_url="SetA_NieuwsCSV.csv";
  if(!ini_set('default_socket_timeout', 15)) echo "<!-- unable to change socket timeout -->";
  if (($handle = fopen($spreadsheet_url, "r")) !== FALSE) 
      {
      $teller = 0;  
      while (($regel = fgetcsv($handle, 1000, ";")) !== FALSE) 
          {
          $spreadsheet_data[] = $regel;
          if ($teller > 0) 
            {
            echo "  document.getElementById('nieuws",$teller,"').innerHTML = '<h3>", $regel[0], "</h3><p>", $regel[1], "</p>';\n";
            }
            $teller++;
          };
      fclose($handle);
      }
  else
      die("Problem reading csv");
echo "  };\n";
echo "</script>"
?>


  <script>
    async function LaadNieuws() {
      let url = "https://docs.google.com/spreadsheets/d/e/2PACX-1vTVxjCCPTognHnuuX9xZAJFBSDl4NtPNHC51MRDaL3pdG0pMzC_y9qLllIxyQeRidh28evRzIsBUjJ3/pub?gid=0&single=true&output=csv"; 
      let response = await fetch(url);
      let data = await response.text();

      let rows = data.split("\n").slice(1); 
      rows.forEach((row, i) => {
        let [titel, tekst] = row.split(",");
        if (titel && tekst && i < 3) {
          document.getElementById(`nieuws${i+1}`).innerHTML = `<h3>${titel}</h3><p>${tekst}</p>`;
        }
      });
    }




async function laadAgendaJSON() {
  let url = "https://www.googleapis.com/calendar/v3/calendars/william17maas10@gmail.com/events?key=AIzaSyAjU7CiPIs4hRtM9p5uJDXJunghk7SASbg";
  let response = await fetch(url);
  let data = await response.json();

  let events = data.items;

  // Filter: alleen events vanaf vandaag
  let vandaag = new Date();
  vandaag.setHours(0,0,0,0); // Zet tijd op 00:00 voor correcte vergelijking
  events = events.filter(e => {
    let eventDate = new Date(e.start.dateTime || e.start.date);
    return eventDate >= vandaag;
  });

  // Sorteer op startdatum
  events.sort((a, b) => {
    let dateA = new Date(a.start.dateTime || a.start.date);
    let dateB = new Date(b.start.dateTime || b.start.date);
    return dateA - dateB;
  });

  // Pak de eerste 4 aankomende events
  let upcoming = events.slice(0, 4);

  upcoming.forEach((event, i) => 
    { 
    let dateRaw = event.start.dateTime || event.start.date;
    let dateObj = new Date(dateRaw);
    let dateFormatted = `${String(dateObj.getDate()).padStart(2,'0')}-${String(dateObj.getMonth()+1).padStart(2,'0')}-${dateObj.getFullYear()}`;

    let timeFormatted = '';
    if (event.start.dateTime) {
    let hours = String(dateObj.getHours()).padStart(2, '0');
    console.log(hours);
    let minutes = String(dateObj.getMinutes()).padStart(2, '0');
    console.log(minutes);
    timeFormatted = `${hours}:${minutes}`;
    console.log(timeFormatted);
    }

     let location = event.location ? `<p>Locatie: ${event.location}</p>` : "";
    // Vul HTML element
    let elem = document.getElementById(`agenda${i+1}`);
    if (elem) {
      elem.innerHTML = `
        <h3>${dateFormatted} ${timeFormatted}</h3>
        <p>${event.summary}</p>
        ${location}
      `;
    }
  });
}




    // Benodigde functies aanroepen
    DisplayNews(); //PHP
    // laadNieuws(); //JavaScript
    laadAgendaJSON();  //JavaScript
    

function scaleBody() {
  const vw = window.innerWidth; // breedte van het actieve browservenster
  let scale = 1;

  if (vw < 600) scale = 0.7;        // klein mobiel
  else if (vw < 900) scale = 0.75;  // groot mobiel / klein tablet
  else if (vw < 1200) scale = 0.8;  // tablet / kleine desktop
  else if (vw < 1920) scale = 0.80; // groot scherm (inclusief 1920x1080 venster)
  else if (vw < 2560) scale = 0.95; // extra groot scherm (>1920 venster)
  else scale = 1;                   // ultra groot venster

  document.body.style.transform = `scale(${scale})`;
  document.body.style.transformOrigin = 'top left';
  document.body.style.width = `${100 / scale}%`;
  document.body.style.overflowX = 'hidden';
}

// Voer uit bij laden en bij venster-resize
window.addEventListener('load', scaleBody);
window.addEventListener('resize', scaleBody);
  </script>


</body>
</html>

