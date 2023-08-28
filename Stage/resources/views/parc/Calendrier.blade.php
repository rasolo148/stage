<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
use App\Models\demande_reparation;
?>

<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <style>
        .container {
           max-width: 1000px; /* Réduire la largeur du container */
       }
   
       .calendar-container {
           display: grid;
           grid-template-columns: 80px repeat(31, 1fr);
           grid-template-rows: 30px repeat(15, 1fr);
           gap: 3px;
       }
   
       .cell {
           border: 1px solid #ccc;
           padding: 3px;
           text-align: center;
       }
   
       .cell-day {
           border: 1px solid #ccc;
           text-align: center;
           display: flex;
           flex-direction: column;
           position: relative;
       }
   
       .day-header {
           flex: 1;
           background-color: #f2f2f2;
           font-weight: bold;
           padding: 3px;
           display: flex;
           align-items: center;
           justify-content: center;
           flex-direction: column;
           font-size: 12px;
           position: sticky;
           top: 0;
           z-index: 1;
           margin-right: 3px;
       }
   
       .event {
           height: 3px;
           margin: 1px 0;
       }
   
       .sticky-cell {
           position: sticky;
           left: 0;
           background-color: #f2f2f2;
           z-index: 2;
       }
   
       .scrollable-calendar {
           max-height: 300px;
           overflow-y: auto;
           overflow-x: auto;
       }
   
       .duration {
           position: absolute;
           bottom: 0;
           left: 0;
           width: 100%;
           height: 6px;
           background-color: orange;
       }
        .normal {
            position: relative;
            border-color: orange;
            background-color: orange;
            color: rgb(0, 0, 0);
            border: 1px solid;
            padding: 1px;
            left: 720px;
            width:92px;
            top:15px;
        }
        .blanche {
            position: relative;
            border-color: white;
            background-color: white;
            color: rgb(0, 0, 0);
            border: 1px solid;
            padding: 1px;
            left: 600px;
            width:92px;
            top:42px;
        }
        .reserve {
            position: relative;
            border-color: blue;
            color:rgb(0, 0, 0);
            background-color: blue;
            border: 1px solid;
            padding: 1px;
            left: 840px;
            width:92px;
            top:-12px;
        }
        .rdv {
            position: relative;
            border-color: green;
            color:rgb(0, 0, 0);
            background-color: green;
            border: 1px solid;
            padding: 1px;
            left: 480px;
            width:92px;
            top:70px;
        }    
   </style>
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 3px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Calendrier planning dans le garage {{ $mois }} {{ $annee }}</label></header>
            @include('template.Message')
            <div class="container mt-5" >
               
                <div class="recherche" style="position: absolute;top:185px;">
                    <form action="{{ url('/recherchecalendrier') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;">
                        @csrf
                        <div class="input-group">
                            <select class="shadow-sm form-control border-0 small" name="mois" style="font-size: 13px; height: 36px; width: 20%; background-color: rgb(255,255,255);">
                                <option value="">choisir mois</option>
                                @foreach (range(1, 12) as $month)
                                    <option value="{{ $month }}">{{ \Illuminate\Support\Carbon::createFromDate(null, $month)->monthName }}</option>
                                @endforeach
                            </select>
                
                            <div class="input-group-append">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                
              {{-- ato miasa --}}

              <div class="rdv">Réservé</div>
               <div class="blanche">Date fin</div>
               <div class="normal">Non sortie</div>
               <div class="reserve">déja sortie</div>

             </div>


              <div class="scrollable-calendar">
                  <div class="calendar-container">
                    
                    <div class="sticky-cell cell">Places</div>
     
                      @foreach ($headers as $index => $header)
                          <div class="day-header" style="width:25px;">{{ $header }}</div>
                      @endforeach

                  <?php
for ($i = 1; $i <= 15; $i++) {
    // Numéros de place fixes
    echo "<div class=\"sticky-cell cell\">Place $i</div>";
    for ($j = 0; $j < 31; $j++) {
        echo "<div class=\"cell-day\">";

            $colorStyle = "width: 10px;"; // Par défaut, couleur aléatoire

        $shouldColor = false;

        foreach ($repairData as $repair) 
        {
            $dateDebut = FormatDate::formatDay($repair->datedebut);
            $dateEntree = FormatDate::formatDay($repair->date_entree);
            $dateFin = FormatDate::formatDay($repair->datefin);
            $dateNow = date('d');        
            $numeroPlace = $repair->idnumero_place;
            $typeSortie = $repair->etat_sortie;
            $typeDemande = $repair->type_demande;

            if ($dateEntree == 0) 
            {
        // Date_entree est nulle, afficher la durée de datedebut à datefin en couleur orange
                if ($i== $numeroPlace && $j >= $dateDebut - 1 && $j <= $dateFin - 1) {
                        $shouldColor = true;      
                        $barHeight = "8px";
                        $colorStyle = "width: 100%; background-color: green; border: 7px solid green;";
                }
           }
           else 
           {
                // Date_entree n'est pas nulle
            if ($i === $numeroPlace && $j >= $dateEntree - 1 && $j <= $dateFin - 1) {
            $shouldColor = true;      
            $barHeight = "8px";

                if ($j >= $dateNow && $j <= $dateFin - 1) 
                {
                // Entre date actuelle et date de fin, couleur grise
                $colorStyle = "width: 100%; border-color:black; background-color: grey;color: rgb(0,0,0);border: 7px solid grey;";
                } 
                elseif ($typeSortie == '1') {
                // Sortie = 1, couleur bleue
                $colorStyle = "width: 100%; background-color: blue; border: 7px solid blue;";
                } 
                elseif ($typeSortie == '0') 
                {
                // Sortie = 0, type_demande = 'normal', couleur orange
                $colorStyle = "width: 100%; background-color: orange; border: 7px solid orange;";
                }

            }
          } 
        }

        echo "<div class=\"event\" style=\"$colorStyle\"></div>";
        echo "</div>"; // Fermeture de la balise div pour cell-day
    
    }
}
?>

                
                  </div>

              </div>

              <br>
                                                          {{-- 
ici on met le modal rendez vous  --}}
<a href="{{ url('versrdv') }}"><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal"  type="button" style="background-color: #eb3834;">Demande de Rendez-vous</button> </a>

           
            </div>

        </div>

        </div>
    </div>
    </div>
    </div>
     @include('template.Footer')
</body>

</html>