<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Modifier Affectation</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/modifieraffectation') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idaffectation" value="{{ $valeur->idaffectation }}">

                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
    
                    <div>
                        <div><label style="margin: 0;width: 77px;font-size: 17px;">Affectation:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="libelle" value="{{ $valeur->libelle }}" style="width: 90%;height: 35px;"></div>
                    </div>

                    
                    <div>
                      <div>
                        <label style="margin: 0;font-size: 17px;">Catégorie:</label>
                      </div>
                      <div style="width: 100%;">
                        <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="idcategorie_depense">
             
                          @foreach ($listeDepense as $rows)
                          <option value="{{ $rows->idcategorie_depense  }}">{{ $rows->categorie }}</option>
                   
                          @endforeach
                      
                        </select>
                      </div>
                    </div>
                    
            
                    <div>
                      <div>
                        <label style="margin: 0;font-size: 17px;">Type Mouvement:</label>
                      </div>
                      <div style="width: 100%;">
                        <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="type_mouvement">
                          <option value="{{ $valeur->type_mouvement }}">{{ $valeur->type_mouvement }}</option>
                          <option value="entree">Entrée</option>
                          <option value="sortie">Sortie</option>
                        </select>
                      </div>
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