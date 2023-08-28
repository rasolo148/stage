<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">

    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Paiement factures</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                    <h1>Facture Numéro {{ $format }}</h1>
                    <h2>Reste a payer : {{  number_format($reste,2,',',' ')  }} Ar</h2>
                  <form action="{{ url('/paiementfacture') }}" method="POST">
                    @csrf
                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                    
                        <input type="hidden" name="idfacture" value="{{ $idfacture }}">
                        <input type="hidden" name="reste" value="{{ $reste }}">
                        <input type="hidden" name="format" value="{{ $format }}">

                        <div>
                          <div>
                            <label style="margin: 0;width: 77px;font-size: 17px;">Montant :</label>
                          </div>
                          <div style="width: 100%;">
                            <input name="montant" class="form-control" type="number" id="input" placeholder="montant" style="margin: auto;margin-top: 10px;">
                          </div>
                        </div>

                        <div>
                          <div>
                            <label style="margin: 0;width: 77px;font-size: 17px;">Mode de paiement :</label>
                          </div>
                          <div style="width: 100%;">
                            <select name="type_paiement" class="form-control" id="input" style="margin: auto; margin-top: 10px;">
                              <option value="" disabled selected>Choisir le mode paiement</option>
                              <option value="Espece">Espece</option>
                              <option value="Mvola">MVola</option>
                              <option value="Banque">Banque</option>
                              <!-- Add more options if needed -->
                          </select>
                          </div>
                        </div>
           
       
                        <div>
                            <div><label style="margin: 0;width: 77px;font-size: 20px;">Date Paiement:</label></div>
                            <div style="width: 100%;"><input class="bg-light border rounded" type="date" style="width: 90%;height: 35px;" name="date">
                            </div>
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