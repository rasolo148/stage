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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Modifier Caisse</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">

                  <form action="{{ url('/modifiercaisse') }}" method="POST">
                    @csrf
                    <input type="hidden" name="idcaisse" value="{{ $valeur->idcaisse }}">

                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
    
                        <input list="cars" placeholder="choisir affectation" value="{{ $valeur->affectation }}" class="bg-light border rounded" style="width: 90%; height: 35px;" id="car" />
                        <datalist id="cars">
                          @foreach ($listeAffectation as $rows)
                          <option data-idaffectation="{{ $rows->idaffectation }}" value="{{ $rows->libelle }} {{ $rows->categorie }}"></option>
                          @endforeach          
                        </datalist>

                        <input type="hidden" name="idaffectation" value="{{ $valeur->idaffectation }}" />
<script>
// Get references to the input and datalist elements
const input = document.querySelector('#car');
const datalist = document.querySelector('#cars');

// Listen for changes to the input element
input.addEventListener('change', () => {
// Get the selected option from the datalist
const option = datalist.querySelector(`option[value="${input.value}"]`);

// If an option was selected, update the value of the hidden input element
if (option) {
document.querySelector('input[name="idaffectation"]').value = option.dataset.idaffectation;
}
});
</script>
                                <input name="reference" value="{{ $valeur->reference }}" class="form-control" type="text" id="input" placeholder="Reference" style="margin: auto;margin-top: 10px;">
                                
                                <input name="libelle" value="{{ $valeur->libelle }}" class="form-control" type="text" id="input" placeholder="libelle" style="margin: auto;margin-top: 10px;">

                            <select name="type_mouvement" class="form-control" id="input" style="margin: auto; margin-top: 10px;">
                                  <option value="{{ $valeur->type_mouvement }}">{{ $valeur->type_mouvement }}</option>
                                  <option value="entree">Entrée</option>
                                  <option value="sortie">Sortie</option>
                                  
                                  <!-- Add more options if needed -->
                              </select>
                              
                              <input name="montant" value="{{ $valeur->montant }}" class="form-control" type="text" id="input" placeholder="montant" style="margin: auto;margin-top: 10px;">

                              <input name="date" value="{{ $valeur->date }}" class="form-control" type="date" id="input" placeholder="date" style="margin: auto;margin-top: 10px;">                   
                        
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