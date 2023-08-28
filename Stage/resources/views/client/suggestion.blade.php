<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Suggestion rendez-vous des clients</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
              
              <div class="row">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>
                            <div></div>
                        </div>
                      
                    </div>
                    <div style="margin-top: -100px;margin-bottom: 10px;">
                        <div class="col">
                            <h1>Problème : {{ $demande->description }}</h1>
                            <h2>Date demande : {{ FormatDate::FormatDateTime($demande->date) }}</h2>
                            <h2>Heure éstimée : {{ $diffHours }} Heures</h2>
                            <h2>Nombre de mécaniciens requis : {{ $countWorks }}</h2>
                            <h1 style="text-align:center"><b>Suggestion:</b></h1>
                            <div class="row" style="width: 90%;margin: auto;">
                               @foreach ($nextClosestDates as $rows)
                                   
                              
                                <div class="col-sm-4 col-md-4" data-bs-hover-animate="pulse" style="background-color: #ffffff;margin-top: 10px;">
                                    <div class="text-center shadow serviceBox yellow" style="background-color: rgb(255,255,255);height: 400px;">
                                        <div class="text-center service-content">
                                         
                                            <p class="text-left">Date début: {{ FormatDate::FormatDateTime( $rows['datedebut']) }}</p>

                                            <p class="text-left">Date fin: {{ FormatDate::FormatDateTime( $rows['datefin']) }}</p>

                                            <p>{{ $rows['message'] }}</p>

                                            @if ($rows['message'] == 'Mécanicien disponible et place disponible')
                                            <a href="{{ url('/reserve') }}/{{ $demande->iddemande }}/{{ $rows['datedebut'] }}/{{ $rows['datefin'] }}">
                                                <button class="btn btn-primary" type="button" style="background-color: #e78e45;">Réservé</button>
                                            </a>
                                            @endif

                                        </div>
                                    </div>
                                 
                                </div>

                                @endforeach
                           
                           </div>
                </div>

    
    </div>
              
           </div>
       </div>
    </div>
     @include('template.Footer')
</body>

</html>