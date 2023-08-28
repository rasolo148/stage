<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Faire un Achat</label></header>
             @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                
                <div class="col" style="height: auto;">

                  <form action="{{ url('/ajouterachat') }}" method="POST">
                    @csrf
                    <div class="border rounded shadow-sm" style="width: 80%; background-color: #ffffff; margin: auto; padding:10px;margin-top:-9px;">
                        
                        <div>
                          <div>
                            <label style="margin: 0;font-size: 15px;">Désignation:</label>
                          </div>
                          <div style="width: 100%;">
                            <input list="cars" class="bg-light border rounded" style="width: 90%; height: 25px;" id="car" />
                            <datalist id="cars">
                              @foreach ($listeLogistique as $rows)
                              <option data-idlogistique="{{ $rows->idlogistique  }}" value="{{ $rows->libelle }}  {{ $rows->type_logistique }}"></option>
                              @endforeach          
                            </datalist>
                          </div>
                        </div>
                        <input type="hidden" name="idlogistique" />
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
                              document.querySelector('input[name="idlogistique"]').value = option.dataset.idlogistique;
                            }
                          });
                        </script>

                        <div>
                          <div>
                            <label style="margin: 0;font-size: 15px;">Fournisseur:</label>
                          </div>
                          <div style="width: 100%;">
                            <input list="cars2" class="bg-light border rounded" style="width: 90%; height: 25px;" id="car2" />
                            <datalist id="cars2">
                              @foreach ($listeFournisseur as $rows)
                              <option data-idfournisseur="{{ $rows->idfournisseur  }}" value="{{ $rows->nomfournisseur }} {{ $rows->lieu }}"></option>
                              @endforeach 
                            </datalist>
                            <button class="add-button" data-toggle="modal" data-target="#exampleModal" type="button"><i class="fas fa-plus"></i></button>
                          </div>
                        </div>
               <input type="hidden" name="idfournisseur">
                        <script>
                          // Get references to the input and datalist elements
                          const input2 = document.querySelector('#car2');
                          const datalist2 = document.querySelector('#cars2');
                          
                          // Listen for changes to the input element
                          input2.addEventListener('change', () => {
                            // Get the selected option from the datalist
                            const option2 = datalist2.querySelector(`option[value="${input2.value}"]`);
                            
                            // If an option was selected, update the value of the hidden input element
                            if (option2) 
                            {
                              document.querySelector('input[name="idfournisseur"]').value = option2.dataset.idfournisseur;
                            }
                          });
                        </script>
                       
                       <div>
                        <div><label style="margin: 0;font-size:15px;">Quantité:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="number" style="width: 90%; height: 25px;" name="quantiter">
                        </div>
                    </div>
    
                    <div>
                        <div><label style="margin: 0;font-size: 15px;">Marque:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="text" style="width: 90%; height: 25px;" name="marque">
                        </div>
                    </div>
                    
                    <div>
                        <div><label style="margin: 0;font-size:15px;">Modèle:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="text" style="width: 90%; height: 25px;" name="modele">
                        </div>
                    </div>
                    
                    <div>
                        <div><label style="margin: 0;font-size: 15px;">Référence:</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="text" style="width: 90%; height: 25px;" name="reference">
                        </div>
                    </div>
                    
                    <div>
                        <div><label style="margin: 0; font-size: 15px;">Prix unitaire :</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="text" style="width: 90%; height: 25px;" name="prix_unitaire">
                        </div>
                    </div>
                    
                    <div>
                        <div>
                            <label style="margin: 0; font-size: 15px;">Mode de paiement :</label>
                        </div>
                        <div style="width: 100%;">
                            <select name="type_paiement" class="form-control" id="input" style="margin: auto; margin-top: 1px;">
                                <option value="" disabled selected>Choisir le mode de paiement</option>
                                <option value="Espece">Espèce</option>
                                <option value="MVola">MVola</option>
                                <option value="Banque">Banque</option>
                                <!-- Ajoutez plus d'options si nécessaire -->
                            </select>
                        </div>
                    </div>
                    
                    <div>
                        <div><label style="margin: 0; font-size: 15px;">Date d'Achat :</label></div>
                        <div style="width: 100%;"><input class="bg-light border rounded" type="date" style="width: 90%; height: 25px;" name="date_achat">
                        </div>
                    </div>
                    
                      

                        <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                        <div></div>
                    </div>
                  </form>
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau Fournisseur</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">                                     
                                            <form action="{{ url('/ajouterfournisseur') }}" method="post">
                                              @csrf  
                                         
                                              <div>
                                                <div><label style="margin: 0;font-size: 17px;">Nom:</label></div>
                                                <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="nomfournisseur" style="width: 90%;height: 35px;"></div>
                                            </div>

                                            <div>
                                              <div><label style="margin: 0;font-size: 17px;">Lieu:</label></div>
                                              <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="lieu" style="width: 90%;height: 35px;"></div>
                                          </div>
                                              
                                                <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                                                <div></div>
                                          </form>
                                        
              
                                              <div><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-gray);border-style: none;">ok</button></div>
                                              @if (session('error'))
                                              <div class="alert alert-danger" style="margin-top: 10px;">
                                                  {{ session('error') }}
                                              </div>
                                              @endif            
                        </div>
                      
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                      </div>
                    </div>
                  </div>


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