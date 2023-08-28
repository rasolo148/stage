
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Modifier le prix unitaire pour {{ $libelle }}</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/modifierstock') }}" method="POST">
                    @csrf
                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                     
                   <input type="hidden" name="idlogistique" value="{{ $idlogistique }}">
                   <input type="hidden" name="idfournisseur" value="{{ $idfournisseur }}">

                      <div>
                        <div><label style="margin: 0;font-size: 17px;">Prix unitaire :</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="prix_unitaire" value="{{ $prix_unitaire }}" style="width: 90%;height: 35px;"></div>
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