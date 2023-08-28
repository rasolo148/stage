<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
  <style>
    @page {
      margin: 10mm;
    }
    body {
        font-family: Arial, sans-serif;
    }
    .info {
        float: left;
        width: 45%;
    }
    .info1 {
        float: right;
        width: 25%;
        position:absolute;
        top:185px;
        left:1000px;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 8px;
    }
    th {
        background-color: #ec712a;
        color: white;
    }
    .facture-box {
        border: 0px solid; /* Couleur de la bordure */
        border-top: 1px solid;
        border-right: 1px solid;
        border-left: 1px solid;
        border-bottom: 1px solid;
        background-color: #f9d7d4; /* Couleur de fond rose */
        width: fit-content; /* Ajuster la largeur à son contenu */
    }
    p.email {
        text-decoration: underline;
    }
    h6 {
      font-size: 14px;
      margin: 0;
      padding: 0;
      font-weight:normal;
  }
  </style>

    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Devis  </label></header>
            @include('template.Message')
            <div class="container-fluid">
              @if ($errors->any())
              <div class="alert alert-danger">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
          
  <div class="info"> 
    <p style="font-size:12px;">Lot AZ 40 KIA Anosizato Ouest</p>
    <p style="font-size: 12px;margin-top:-20px;">Antananarivo 102</p>
    <p style="font-size: 12px;margin-top:-18px;">+261 33 64 600 31</p>
    <p class="email" style="font-size: 12px;margin-top:-18px;">rn1garages@gmail.com</p>
    <p style="font-size: 12px;margin-top:-18px;">NIF: 3004272333</p>
    <p style="font-size: 12px;margin-top:-18px;">STAT: 47521 11 2022 0 03641</p>
    
    
    </div>
  
    <div class="info1">
    <p style="font-size:12px;margin-top:-65px;"><strong>TOJONIAINA Hajarisoa</strong></p>
    <p style="font-size:12px;margin-top:-16px;"><strong>Antananarivo</strong></p>
    <p style="font-size:12px;margin-top:-16px;">REF :  123T</p>
    <p style="font-size:12px;margin-top:-16px;">m1 GOLF</p>
    <p style="font-size:12px;margin-top:-16px;">Date de début : {{ FormatDate::formatDateTime($detail->datedebut) }}</p>
    <p style="font-size:12px;margin-top:-16px;">Date fin : {{ FormatDate::formatDateTime($detail->datefin) }}</p>
    </div>
        
      <div style="clear:both;"></div>
      
      <div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ajouter Main d'œuvre</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
    
              <form action="{{ url('/devisservice') }}" method="POST">
                
                @csrf
                <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                
                  <input type="hidden" name="iddemande" value="{{ $iddemande }}">

                  <div>
                    <div>
                      <label style="margin: 0;font-size: 17px;">Main d'œuvre :</label>
                    </div>
                    <div style="width: 100%;">
                      <input list="services" class="bg-light border rounded" style="width: 90%; height: 35px;" id="service" />
                      <datalist id="services">
                        @foreach ($listeService as $rows)
                        <option data-idservice="{{ $rows->idservice }}" value="{{ $rows->libelle }} Tarif:{{ FormatNumber::formatter($rows->tarif) }} Ar"></option>
                        @endforeach
                        <!-- Ajoutez d'autres options selon vos besoins -->
                      </datalist>
                    </div>
                  </div>
                  
                  <input type="hidden" name="idservice">

                    <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                    <div></div>
                </div>
              </form>
              
            </div>
            
<script>
  const serviceInput = document.querySelector('#service');
       const serviceDatalist = document.querySelector('#services');
       
serviceInput.addEventListener('change', () => {
        
         const option = serviceDatalist.querySelector(`option[value="${serviceInput.value}"]`);
         
     
         if (option) {
           document.querySelector('input[name="idservice"]').value = option.dataset.idservice;
         }
       });

</script>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>

      <h2 style="font-size: 16px;margin-top:-10px;"><strong>Main d'œuvre:</strong></h2>
      <table style="font-size: 12px;margin-top:-7px;">
        <thead>
          <tr>
            <th style="padding: 1px;">Désignation</th>
            <th style="padding: 1px;">Tarif</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($detailService as $rows)
          <tr>
            <td style="padding: 1px;">{{ $rows->libelle }}</td>
            <td style="padding: 1px;">{{ number_format($rows->total, 2, ',', ' ') }}</td>
            <td style="padding: 1px;">
              <a href="{{ url('/suppDevisService') }}/{{ $rows->idreparation_service }}" class="btn btn-primary" style="background-color: #eb3834; padding: 1px 6px;">Supprimer</a>
            </td>
          </tr>
          @endforeach
          <tr>
            <td style="padding: 1px;"><strong>Total</strong></td>
            <td style="padding: 1px;"><strong>{{ number_format($totalService, 2, ',', ' ') }}</strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      

      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal1" style="background-color: #e78e45; padding: 4px 8px; font-size: 12px;">
        Ajouter
        <i class="fa fa-plus" style="margin: 0; margin-left: 6px;"></i>
      </button>
      

     
      <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Ajouter Pièces</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">

              <form action="{{ url('/devislogistique') }}" method="POST">
                @csrf
                <div class="border rounded shadow-sm" style="width: 80%;height: auto;background-color: #ffffff;margin: auto;padding: 49px;">
                  <input type="hidden" name="iddemande" value="{{ $iddemande }}">
        
                  <div>
                    <div>
                      <label style="margin: 0;font-size: 17px;">Pièces:</label>
                    </div>
                    <div style="width: 100%;">
                      <input list="logistiques" class="bg-light border rounded" style="width: 90%; height: 35px;" id="logistique" />
                      <datalist id="logistiques" onchange="updatePrixUnitaire(this)">
                        @foreach ($listeLogistique as $rows)
                        <option data-idlogistique="{{ $rows->idlogistique }},{{ $rows->idfournisseur }},{{ $rows->prix_unitaire }}" value="{{ $rows->libelle }} {{ $rows->type_logistique }} Prix Unitaire:{{ FormatNumber::formatter($rows->prix_unitaire) }} Ar  quantité restante: {{  $rows->quantite_restante }}"></option>
                        @endforeach
                        <!-- Ajoutez d'autres options selon vos besoins -->
                      </datalist>
                    </div>
                  </div>
        
                  <input type="hidden" name="idlogistique">
                  
                  <div>
                    <div><label style="margin: 0;font-size: 17px;">Prix Unitaire:</label></div>
                    <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="prix_unitaire" id="prix_unitaire_input" style="width: 90%;height: 35px;"></div>
                </div>
        
                   
                <div>
                  <div><label style="margin: 0;font-size: 17px;">Quantité:</label></div>
                  <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="quantite" style="width: 90%;height: 35px;"></div>
              </div>
        
        
                    <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>
                    <div></div>
                </div>
              </form>
              
            </div>
            <script>
  
  function updatePrixUnitaire(selectElement) {
  var selectedOption = selectElement.options[selectElement.selectedIndex];
  var prixUnitaire = selectedOption.value.split(",")[2];
  document.getElementById("prix_unitaire_input").value = prixUnitaire;
}
   
              const logistiqueInput = document.querySelector('#logistique');
              const logistiqueDatalist = document.querySelector('#logistiques');
              
            
              
              // Listen for changes to the logistique input element
              logistiqueInput.addEventListener('change', () => {
                // Get the selected option from the logistique datalist
                const option = logistiqueDatalist.querySelector(`option[value="${logistiqueInput.value}"]`);
                
                // If an option was selected, update the value of the hidden input element
                if (option) {
                  document.querySelector('input[name="idlogistique"]').value = option.dataset.idlogistique;
                }
              });


            
            </script>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
          </div>
        </div>
      </div>
      <br>
      <h2 style="font-size: 16px;margin-left:460px;"><strong>Pièces:</strong></h2>
      <table style="font-size: 12px;margin-top:-8px;">
        <thead>
          <tr>
            <th style="padding: 1px;">Désignation</th>
            <th style="padding: 1px;">QTE</th>
            <th style="padding: 1px;">UNITE</th>
            <th style="padding: 1px;">PU</th>
            <th style="padding: 1px;">Marge</th>
            <th style="padding: 1px;">MONTANT</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($detailLogistique as $rows)
          <tr>
            <td style="padding: 1px;">{{ $rows->libelle }}</td>
            <td style="padding: 1px;">{{ $rows->quantite }}</td>
            <td style="padding: 1px;">{{ $rows->type_logistique }}</td>
            <td style="padding: 1px;">{{ number_format($rows->prix_unitaire, 2, ',', ' ') }}</td>
            <td style="padding: 1px;">{{ $rows->marge_beneficiaire }}%</td>
            <td style="padding: 1px;">{{ number_format($rows->total, 2, ',', ' ') }}</td>
            <td style="padding: 1px;">
              <a href="{{ url('/versmodifDevisLogistique') }}/{{ $rows->idreparation_logistique }}" class="btn btn-primary" style="background-color: #eb3834; padding: 3px 6px;">Modifier</a>
              <a href="{{ url('/suppDevisLogistique') }}/{{ $rows->idreparation_logistique }}" class="btn btn-primary" style="background-color: #eb3834; padding: 3px 6px;">Supprimer</a>
            </td>
          </tr>
          @endforeach
          <tr>
            <td style="padding: 1px;"><strong>Total</strong></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="padding: 1px;"><strong>{{ number_format($totalProduit, 2, ',', ' ') }}</strong></td>
            <td></td>
          </tr>
        </tbody>
      </table>
      

      <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal2" style="background-color: #e78e45; padding: 4px 8px; font-size: 12px;">
        Ajouter
        <i class="fa fa-plus" style="margin: 0; margin-left: 6px;"></i>
      </button>
      <p style="text-align: right; margin-top: -20px; margin-right: 150px;">
        <u>Total Devis</u> : <strong>{{ number_format($total, 2, ',', ' ') }}  Ariary.</strong>
      </p>
      
      

  
  @if($total != 0)
                          
        @if($detail->etat_reparation != 0)
       
            @if($estDemandeFacture) 
           
                @if($detail->etat_reparation == 1)
                <a href="{{ url('/terminerReparation') }}/{{ $detail->iddemande }}"><button class="btn btn-primary" type="button" style="background-color:#eb8634;margin-left:900px;margin-top:-75px;">Terminer</button> </a>           
                @elseif($detail->etat_reparation == 2) 
                <p style="margin-left:900px;margin-top:-40px;"><strong>Terminée</strong></p>
                @endif

            @else
                <a href="{{ url('/exporterFacture') }}/{{ $detail->iddemande }}/{{  $detail->prix_final }}/1"><button class="btn btn-primary" type="button" style="background-color:#eb8634;margin-left:900px;margin-top:-75px;">Facturer</button> </a>   
            @endif 
       
        @else
       
        <form action="{{ url('/validerDevis') }}" method="GET">
          @csrf
          <input type="hidden" name="iddemande" value="{{ request('iddemande') }}">
          <input type="hidden" name="prix_final" value="{{ $total }}">
      
          <button class="btn btn-primary" type="submit" style="background-color:#eb8634;margin-left:900px;margin-top:-75px;">Valider</button>
        
        </form>        
       
        @endif

  @endif                                                 
            </div>
        </div>

    </div>
    </div>
    </div>
    </div>
    </div>
@include('template.Footer')

</html>