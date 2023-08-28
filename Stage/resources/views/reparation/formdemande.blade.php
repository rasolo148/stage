

<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Demande Réparation</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                    <form action="{{ url('/demande') }}" method="POST">
                        @csrf
                        <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
        
                          <div>
                            <div>
                              <label style="margin: 0;font-size: 17px;">Véhicule:</label>
                            </div>
                        
                            <div style="width: 100%;">
                              <input type="text" class="car-input" placeholder="Choisir un véhicule" value="{{ session('immatriculation') ?? '' }}  {{ session('marque') ?? '' }} {{ session('modele') ?? 'Choisir une voiture' }}" onclick="window.location.href='{{ url('/choisir') }}/1';" style="cursor: pointer;">
                              <input type="hidden" name="idvoiture" value="{{ session('idvoiture') ?? '' }}">
                            </div>
                          
                           
                          </div>
                          <br>
                           
                            <div>
                                <div><label style="margin: 0;font-size: 20px;">Déscription du problème:</label></div>
                                <div style="width: 100%;"><textarea class="bg-light border rounded" style="width: 90%;height: 35px;" name="description"></textarea></div>
                            </div>
    
                            
                            <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                            <div></div>
    
                        </div>
                      </form>
                      <style>
                                      .car-input {
        background-color: #f2f2f2; /* Couleur de fond grise */
        border: 1px solid #ccc; /* Bordure grise */
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        cursor: pointer;
    }
                      </style>  
                </div>
            </div> 
            
          </div>

        </div>
       
    </div>
    </div>
    </div>
    @include('template.Footer')
</body>

</html>