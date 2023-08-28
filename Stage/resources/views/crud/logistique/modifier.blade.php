<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Modifier l'inventaire des Pièces et Consommables</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/modifierlogistique') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idlogistique" value="{{ $valeur->idlogistique }}">

                    <div>
                      <div><label style="margin: 0;font-size: 20px;">Désignation:</label></div>
                      <div style="width: 100%;"><textarea class="bg-light border rounded" style="width: 90%;height: 35px;" name="libelle">{{ $valeur->libelle }}</textarea></div>
                    </div>  

                    <div>
                      <div>
                        <label style="margin: 0;width: 77px;font-size: 17px;">Type:</label>
                      </div>
                      <div style="width: 100%;">
                        <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="type_logistique">
                          <option value="{{ $valeur->type_logistique }}">{{ $valeur->type_logistique }}</option>            
                          <option value="Pièces détachées">Pièces détachées</option>
                            <option value="Consommables">Consommables</option>
                        
                        </select>
                      </div>
                    </div>
                    <br>
                    <div>
                      <div><label style="margin: 0;font-size: 17px;">Marge bénéficiaire:</label></div>
                      <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="marge_beneficiaire" value="{{ $valeur->marge_beneficiaire }}" style="width: 90%;height: 35px;"></div>
                   </div>

                    
                        <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Modifier</button>
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