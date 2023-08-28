<?php 
use App\Models\FormatDate;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
  <style>
    /* Optionnel : Style personnalisé pour éviter le wrap du texte dans les cellules */
    .table td.text-nowrap {
      white-space: nowrap;
    }
    .table th.text-nowrap {
      white-space: nowrap;
    }
  </style>
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Demande de Rendez-vous</label></header>
            @include('template.Message')
            <div class="container-fluid">
              
              <br>
              <br>
              <br>

              <a>
                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#exampleModal" style="background-color: #e78e45;">
                  Ajouter un rendez-vous
                  <i class="fa fa-plus" style="margin: 0px;margin-left: 10px;"></i>
                </button>
              </a>
                
              {{-- ato miasa --}}
              <div class="row">
                <div class="col" style="height: auto;">
                  
                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Ajouter un nouveau Client</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                                                                               
                          <form action="{{ url('/ajout_rdv') }}" method="post">
                            @csrf  
                            
                            <div>
                              
                              <div>
                                <label style="margin: 0;font-size: 17px;">Véhicule:</label>
                              </div>
                              
                              <div style="width: 100%;">
                                <input type="text" class="car-input" placeholder="Choisir une voiture" value="{{ session('immatriculation') ?? '' }}  {{ session('marque') ?? '' }} {{ session('modele') ?? 'Choisir une voiture' }}" onclick="window.location.href='{{ url('/choisir') }}/2';" style="cursor: pointer;">
                                <input type="hidden" name="idvoiture" value="{{ session('idvoiture') ?? '' }}">
                              </div>
             
                            </div>
                         
                            
                              <div>
                                  <div><label style="margin: 0;font-size: 20px;">Déscription du problème:</label></div>
                                  <div style="width: 100%;"><textarea class="bg-light border rounded" style="width: 90%;height: 35px;" name="description"></textarea></div>
                              </div>
    
                              
                              <div>
                                  <div><label style="margin: 0;font-size: 17px;">Date de Début:</label></div>
                                  <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datedebut" style="width: 90%;height: 35px;"></div>
                              </div>
    
    
                              <div>
                                  <div><label style="margin: 0;font-size: 17px;">Date fin:</label></div>
                                  <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datefin" style="width: 90%;height: 35px;"></div>
                              </div>
                              
                              
                                  
                              <div>
                                    <label style="margin: 0;font-size: 17px;">Numéro Place:</label>
                                  </div>
                                  <div style="width: 100%;">
                                    <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="idnumero_place">
                                      @foreach ($listePlace as $rows)
                                       <option value="{{ $rows->idnumero_place }}">{{ $rows->idnumero_place }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                              </div>
                              
                                    <input type="submit" class="btn btn-primary"
                                            role="button" id="button" style="background-color: #e78e45;margin: auto;margin-top: 10px;" value="Valider">
                            
                        </form>

                        
                        </div>
                        <div class="modal-footer">
                       
                        </div>
                      </div>
                    </div>
                  </div>

<br>
                    <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                <th class="text-nowrap" style="background-color: #ffffff;">Déscription</th>
                                <th class="text-nowrap" style="background-color: #ffffff;">Client</th> 
                                <th class="text-nowrap" style="background-color: #ffffff;">Véhicule</th>
                                <th class="text-nowrap" style="background-color: #ffffff;">Numéro Place</th>
                                <th class="text-nowrap" style="background-color: #ffffff;">Date de début</th>
                                <th class="text-nowrap" style="background-color: #ffffff;">Date fin</th>
                              </tr>
                          </thead>
                          <tbody>
                          
                          @foreach ($listeDemande as $rows)
                            <tr>
                              <td class="text-nowrap">{{ $rows->description }}</td>
                              <td class="text-nowrap">{{ $rows->nom }}</td>
                              <td class="text-nowrap">{{ $rows->marque }} {{ $rows->immatriculation }}</td>
                              <td class="text-nowrap">{{ $rows->idnumero_place }}</td>
                              <td class="text-nowrap">{{ FormatDate::format($rows->datedebut) }}</td>
                              <td class="text-nowrap">{{ FormatDate::format($rows->datefin) }}</td>
                              <td class="text-nowrap" style="width: 248px;">    
                              
                                <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $rows->iddemande }}" type="button" style="background-color: #e78e45;">Modifier</button></a>
                                  
                                  <a href="{{ url('/annuler') }}/{{ $rows->iddemande }}"><button class="btn btn-primary" type="button" style="background-color: #eb3834;">Annuler</button> </a>
                                  
                                </td>
                          </tr>
                          <div class="modal fade" id="exampleModal{{ $rows->iddemande }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLabel">Modifier Rendez-vous</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                                                                       
                                  <form action="{{ url('/ajoutermouvement_voiture') }}" method="post">
                                      @csrf  
                                  
                                  <input type="hidden" name="type" value="rdv">             

                                  <input type="hidden" name="iddemande" value="{{ $rows->iddemande }}">
                          
                                <div>
                                  <div>
                                    <label style="margin: 0;width: 77px;font-size: 17px;">Numéro Place Libre:</label>
                                  </div>
                                  <div style="width: 100%;">
                                    <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="idnumero_place">
                                      @foreach ($listePlace as $rows)
                                       <option value="{{ $rows->idnumero_place }}">{{ $rows->idnumero_place }}</option>
                                      @endforeach
                                    </select>
                                  </div>
                                </div>
                              


                                  <div>
                                      <div><label style="margin: 0;width: 77px;font-size: 17px;">Date de début:</label></div>
                                      <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datedebut" style="width: 90%;height: 35px;"></div>
                                  </div>


                                <div>
                                    <div><label style="margin: 0;width: 77px;font-size: 17px;">Date fin:</label></div>
                                    <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datefin" style="width: 90%;height: 35px;"></div>
                                </div>
  
    
                
                                  <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Enregistrer</button>


                                        <div></div>
                                  </form>   
                                                      <div><button class="btn btn-primary d-block w-100" type="submit" style="background: var(--bs-gray);border-style: none;">ok</button></div>
                                                             
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                              </div>
                            </div>
                          </div>
                          @endforeach
                         
                          </tbody>
                      </table>
                  </div>
                  <style>
                    .pagination .page-link,
                    .pagination .page-item.active .page-link {
                      background:#e78e45;
                      border-color: orange;
                      color: white;
                    }
                  
                    .pagination .page-link:hover {
                      background: #e78e45;
                      border-color: darkorange;
                    }
                  </style>
                  <nav aria-label="Page navigation example">
                    <ul class="pagination">
                      <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationclient') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Précédent</span>
                        </a>
                      </li>
                      @foreach($listeNumeroPage as $rows)
                      <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ url('/paginationclient') }}/{{ $rows }}">{{ $rows }}</a>
                      </li>
                      @endforeach
                      <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationclient') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Suivant</span>
                        </a>
                      </li>
                    </ul>
                  </nav>

                      <style>
                                      .car-input {
        background-color: #f2f2f2; /* Couleur de fond grise */
        border: 1px solid #ccc; /* Bordure grise */
        width: 100%;
        padding: 5px;
        box-sizing: border-box;
        cursor: pointer;
    }
                      </style>  
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