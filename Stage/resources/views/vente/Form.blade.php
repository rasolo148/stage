<?php
use App\Models\FormatNumber;
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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Ajouter Vente</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  <style>
                    .product {
                      border: 1px solid #ccc;
                      padding: 10px;
                      margin-bottom: 10px;
                    }
                  
                    .product label {
                      display: block;
                      margin-bottom: 5px;
                    }
                  
                    .product input,
                    .product select {
                      width: 100%;
                      box-sizing: border-box;
                    }
                  
                    .quantity-buttons {
                      display: flex;
                      align-items: center;
                    }
                  
                    .quantity-buttons button {
                      width: 30px;
                      height: 30px;
                      border-radius: 50%;
                      border: none;
                      background-color: #e78e45;
                      color: white;
                      font-size: 20px;
                      line-height: 0;
                      margin-right: 5px;
                      cursor:pointer;
                    }
                  
                    .quantity-buttons input {
                      width: 50px;
                      text-align:center;
                    }
                  </style>
                  
                  <form action="{{ url('/ajoutervente') }}" method="POST">
                  @csrf
                  <div class="border rounded shadow-sm" style="width:80%;height:auto;background-color:#ffffff;margin:auto;padding:49px;">
                  <div>
                  <div>
                  <label style="margin:0;width:77px;font-size:17px;">Client:</label>
                  </div>
                  <div style="width:100%;">

                    <input list="clients" class="bg-light border rounded" style="width: 90%; height: 35px;" id="client" />
                    <datalist id="clients">
                  @foreach ($listeClient as $rows)
                  <option data-idclient="{{ $rows->idclient }}" value="{{ $rows->nom }} {{ $rows->pseudo }}"></option>
                  @endforeach
                    </datalist>
                  <button class="add-button" data-toggle="modal" data-target="#exampleModal" type="button"><i class="fas fa-plus"></i></button>
                  </div>
                  </div>
                  <input type="hidden" name="idclient">
                  <script>
                    // Get references to the input and datalist elements
                    const input = document.querySelector('#client');
                    const datalist = document.querySelector('#clients');
                    
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

                <br>
                  <button type="button" onclick="addProduct()" style="margin-bottom:10px;">Ajouter un produit</button>
                  
                  <div id="products">
                  <div class="product">
                  <div>
                  <label>Logistique:</label>
                  <input list="idlogistique" name="idlogistique[]">
                  <datalist id="idlogistique">
                  @foreach ($listeLogistique as $rows)
                  <option data-idlogistique="{{ $rows->idlogistique }},{{ $rows->idfournisseur }},{{ $rows->prix_unitaire }}" value="{{ $rows->libelle }} Prix Unitaire:{{ FormatNumber::formatter($rows->prix_unitaire) }} Ar  quantité restante: {{  $rows->quantite_restante }}"></option>
                  @endforeach
                  </datalist>
                  <input type="hidden" name="idlogistique_value[]">
                  </div>
                  <script>
          
const inputs = document.querySelectorAll('input[name="idlogistique[]"]');

inputs.forEach(input3 => {
input3.addEventListener('change', () => {
  const datalist3 = input3.nextElementSibling;
  const option3 = datalist3.querySelector(`option[value="${input3.value}"]`);
        if (option3) {
  
        input3.parentElement.querySelector('input[name="idlogistique_value[]"]').value = option3.dataset.idlogistique;
        }
    });
});

</script>
                  <div>
                  <label>Prix unitaire:</label>
                  <input type="number" name="prix_unitaire[]">
                  </div>
                  
                  <div>
                  <label>Quantité:</label>
                  <div class="quantity-buttons">
                  <button type="button" onclick="decrementQuantity(this)">-</button>
                  <input type="number" name="quantite[]" value= "1">
                  <button type= "button"onclick= "incrementQuantity(this)">+</button >
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
                  
                  <button type= "button"onclick= "removeProduct(this)"style= "margin-top :10px;">Supprimer</button>
                  </div>
                  </div>
                  
                  <div>
                  <label>Date:</label>
                  <input type= "date"name= "date">
                  </div>
                  
                  <button class= "btn btn-primary"type= "submit"style= "margin :0px;background-color:#e78e45;width :100px;height:auto;margin-top :20px;">Enregistrer</button>
                  </div>
                  </form>
                  
                  <script>
             var productTemplate = document.querySelector('.product').cloneNode(true);

function addProduct() {
    var products = document.getElementById('products');
    var product = productTemplate.cloneNode(true);
    products.insertBefore(product, products.firstChild);

    
    const input4 = product.querySelector('input[name="idlogistique[]"]');
  
  // Ajoutez un écouteur d'événements pour cet élément d'entrée
  input4.addEventListener('change', () => {
    // Sélectionnez l'option dans la liste déroulante associée à cet élément d'entrée
    const datalist4 = input4.nextElementSibling;
    const option4 = datalist4.querySelector(`option[value="${input4.value}"]`);
    if (option4) {
      // Mettez à jour la valeur du champ caché avec l'idlogistique de l'option sélectionnée
      const hiddenInput4 = input4.parentElement.querySelector('input[name="idlogistique_value[]"]');
      hiddenInput4.value = option4.dataset.idlogistique;
    }
  });
}        

                  function removeProduct(button) {
                  var product = button.closest('.product');
                  product.remove();
                  }
                  
                  function incrementQuantity(button) {
                  var quantityInput = button.previousElementSibling;
                  quantityInput.value = parseInt(quantityInput.value) +1;
                  }
                  
                  function decrementQuantity(button) {
                  var quantityInput = button.nextElementSibling;
                  if (quantityInput.value >1) {
                  quantityInput.value = parseInt(quantityInput.value) -1;
                  }
                  }
                  </script>
                  
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
        <script>
          function updatePrixUnitaire(selectElement) {
            var selectedOption = selectElement.options[selectElement.selectedIndex];
            var prixUnitaire = selectedOption.value.split(",")[2];
            document.getElementById("prix_unitaire_input").value = prixUnitaire;
          }
                 </script>
    </div>
    </div>
    </div>
    @include('template.Footer')
</body>

</html>