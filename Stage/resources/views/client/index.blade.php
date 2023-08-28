<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
?>

<!DOCTYPE html>
<html>
@include('template.Head')
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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Demande de réparation</label></header>
            @include('template.Message')
            <div class="container-fluid">
              {{-- ato miasa --}}
              <div class="row">
              
                <div class="col" style="height: auto;">
                  
                  <a href="{{ url('/formdemande') }}"><button class="btn btn-primary"   type="button" style="background-color: #eb3834;">Ajouter une demande de réparation</button></a>
                  
                                 </div>
            </div> 


            <div class="row" style="margin-top:-80px;">
              <div class="col" style="margin-top: 100px;">
                  <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                      <div>
                       
                          
                      </div>
                
                      <div class="input-group-append">
                      </div>
                      <form action="{{ url('/recherchedemande') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                        @csrf
                        <div class="input-group" style="width: auto;margin-left: 60%;"><input class="shadow-sm form-control border-0 small" type="text" name="motcle" placeholder="recherche" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                            <div class="input-group-append">
                              <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                  </div>
                  <div class="table-responsive">
                      <table class="table table-bordered">
                          <thead>
                              <tr>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">ID</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Déscripion</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Véhicule</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Client</th>         
                              </tr>
                          </thead>
                          <tbody>
                            @foreach ($listeDemande as $rows)
                            <tr>
                              <td class="text-nowrap" >{{ $rows->iddemande }}</td>
                              <td class="text-nowrap" >{{ $rows->description }}</td>
                              <td class="text-nowrap" >{{ $rows->marque }} {{ $rows->modele }} {{ $rows->immatriculation }}</td>
                              <td class="text-nowrap" >{{ $rows->nom }}</td>
                              <td class="text-nowrap"  style="width: 248px;">
                                  
                                <a href="{{ url('/formdevis') }}/{{ $rows->iddemande }}"><button class="btn btn-primary" type="button" style="background-color: #eb3834;">Détails sur le Devis</button> </a>
                                  
                                @if($rows->etat_sortie == '0')
                                
                                <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $rows->iddemande }}{{ $rows->idvoiture }}" type="button" style="background-color: #eb3834;">Faire Entrée le Véhicule</button></a>


                                @endif  
                                  
                              </td>
                            </tr>

                            <div class="modal fade" id="exampleModal{{ $rows->iddemande }}{{ $rows->idvoiture }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Entrée un Véhicule</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                                                                         
                                    <form action="{{ url('/ajoutermouvement_voiture') }}" method="post">
                                        @csrf  
                                    
                                                   
                                  <input type="hidden" name="type" value="normal">  
                                                 
                                    <input type="hidden" name="iddemande" value="{{ $rows->iddemande }}">
                                  
                                    <input type="hidden" name="idvoiture" value="{{ $rows->idvoiture }}">
                                    
                                    <div>
                                      <div><label style="margin: 0;font-size: 17px;">Nombre de mécanicien:</label></div>
                                      <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="nombre_mecaniciens" style="width: 90%;height: 35px;"></div>
                                  </div>

                                  <div>
                                    <div>
                                      <label style="margin: 0;font-size: 17px;">Numéro de Place Libre:</label>
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
                                      <div><label style="margin: 0;font-size: 17px;">Date d'entrée:</label></div>
                                      <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="date_entree" style="width: 90%;height: 35px;"></div>
                                  </div>

                                    <div>
                                        <div><label style="margin: 0;font-size: 17px;">Date de début:</label></div>
                                        <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datedebut" style="width: 90%;height: 35px;"></div>
                                    </div>

                                    <div>
                                      <div><label style="margin: 0;font-size: 17px;">Date fin:</label></div>
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
                        <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationdemande') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
                          <span aria-hidden="true">&laquo;</span>
                          <span class="sr-only">Précédent</span>
                        </a>
                      </li>
                      @foreach($listeNumeroPage as $rows)
                      <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                        <a class="page-link" href="{{ url('/paginationdemande') }}/{{ $rows }}">{{ $rows }}</a>
                      </li>
                      @endforeach
                      <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationdemande') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
                          <span aria-hidden="true">&raquo;</span>
                          <span class="sr-only">Suivant</span>
                        </a>
                      </li>
                    </ul>
                  </nav>       
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