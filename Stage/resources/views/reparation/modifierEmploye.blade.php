<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Modifier Devis Employé</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/modifierDevisEmploye') }}" method="POST">
                    @csrf

<input type="hidden" name="idreparation_employe" value="{{ $valeur->idreparation_employe }}">
<input type="hidden" name="iddemande" value="{{ $valeur->iddemande }}">
<input type="hidden" name="idemploye" value="{{ $valeur->idemploye }}">
                                    
<div>
    <div><label style="margin: 0;width: 77px;font-size: 17px;">Heure estimée:</label></div>
    <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="temps_estime"  placeholder="en heures" style="width: 90%;height: 35px;"></div>
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