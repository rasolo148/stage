<!DOCTYPE html>
<html>
@include('template.Head')  
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Ajouter l'inventaire des Pièces et Consommables</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/ajouterlogistique') }}" method="POST">
                    @csrf
                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                     
                      <div>
                        <div><label style="margin: 0;width: 77px;font-size: 20px;">Désignation:</label></div>
                        <div style="width: 100%;"><textarea class="bg-light border rounded" style="width: 90%;height: 35px;" name="libelle"></textarea></div>
                      </div>  

                      <div>
                        <div>
                          <label style="margin: 0;width: 77px;font-size: 17px;">Type:</label>
                        </div>
                        <div style="width: 100%;">
                          <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="type_logistique">
                        
                            <option value="Pièces détachées">Pièces détachées</option>
                            <option value="Consommables">Consommables</option>
                        
                          </select>
                        </div>
                      </div>
                      
                      <div>
                        <div><label style="margin: 0;font-size: 17px;">Marge bénéficiaire:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="number" value="15" name="marge_beneficiaire" style="width: 90%;height: 35px;"></div>
                     </div>

              
                        <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                        <div></div>
                    </div>
                  </form>
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