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
                  <form action="{{ url('/modifierDevisService') }}" method="POST">
                    @csrf

<input type="hidden" name="idreparation_logistique" value="{{ $valeur->idreparation_logistique }}">
<input type="hidden" name="iddemande" value="{{ $valeur->iddemande }}">
<input type="hidden" name="idlogistique" value="{{ $valeur->idlogistique }}">
<input type="hidden" name="idfournisseur" value="{{ $valeur->idfournisseur }}">
    
<div>
    <div><label style="margin: 0;width: 77px;font-size: 17px;">Prix unitaire:</label></div>
    <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="prix_unitaire" value="{{ $valeur->prix_unitaire }}" style="width: 90%;height: 35px;"></div>
</div>

<div>
    <div><label style="margin: 0;width: 77px;font-size: 17px;">Quantité:</label></div>
    <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="quantite" value="{{ $valeur->quantite }}" style="width: 90%;height: 35px;"></div>
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