<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Ajouter Véhicule</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <form action="{{ url('/ajoutervoiture') }}" method="POST">
                    @csrf
                    <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                      <div>
                        <label style="margin: 0;width: 77px;font-size: 17px;">Client:</label>
                      </div>
                        <div style="width: 100%;">
                          <input list="cars" class="bg-light border rounded" style="width: 90%; height: 35px;" id="car" />
                            <datalist id="cars">
                              @foreach ($listeClient as $rows)
                              <option  data-idclient="{{ $rows->idclient }}" value="{{ $rows->nom }} {{ $rows->pseudo }}"></option>                  
                              @endforeach         
                            </datalist>
                            <input type="hidden" name="idclient" />
                            <button class="add-button" data-toggle="modal" data-target="#exampleModal"  type="button" ><i class="fas fa-plus"></i></button>
                          </div>
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
                                document.querySelector('input[name="idclient"]').value = option.dataset.idclient;
                              }
                            });
                          </script>
                          
                          
                          <div>
                            <div><label style="margin: 0;width: 77px;font-size: 17px;">Immatriculation:</label></div>
                            <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="immatriculation" style="width: 90%;height: 35px;"></div>
                          </div>
    
                          <div>
                            <div><label style="margin: 0;width: 77px;font-size: 17px;">Marque :</label></div>
                            <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="marque" style="width: 90%;height: 35px;"></div>
                          </div>
    
                          <div>
                            <div><label style="margin: 0;width: 77px;font-size: 17px;">Modele  :</label></div>
                            <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="modele" style="width: 90%;height: 35px;"></div>
                          </div>
  
                          <div>
                            <div><label style="margin: 0;width: 77px;font-size: 17px;">Energie  :</label></div>
                            <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="energie" style="width: 90%;height: 35px;"></div>
                          </div>
    
    
                        <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                        <div></div>
                    </div>
                  </form>
                  
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau client</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                                                                               
                                            <form action="{{ url('/ajouterclient') }}" method="post">
                                              @csrf  
                                              <div>
                                                <div><label style="margin: 0;width: 77px;font-size: 17px;">Nom:</label></div>
                                                <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="nom" style="width: 90%;height: 35px;"></div>
                                            </div>
                                              
                                              <div>
                                                <div><label style="margin: 0;width: 77px;font-size: 17px;">Contact :</label></div>
                                                <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="contact" style="width: 90%;height: 35px;"></div>
                                            </div>

                                            <div>
                                              <div><label style="margin: 0;width: 77px;font-size: 17px;">Adresse :</label></div>
                                              <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="adresse" style="width: 90%;height: 35px;"></div>
                                          </div>

                                          <div>
                                            <div><label style="margin: 0;width: 77px;font-size: 17px;">Pseudo :</label></div>
                                            <div style="width: 100%;"><input class="bg-light border rounded" type="text" name="pseudo" style="width: 90%;height: 35px;"></div>
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