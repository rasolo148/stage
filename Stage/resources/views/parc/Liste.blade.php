<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
use App\Models\demande_reparation;
?>

<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
  <style>

  #form {

  }

  </style> 
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 3px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Mouvement Parc Automobile</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;position:absolute;top:-35px;left:180px;">
                        
                        <form action="{{ url('/rechercheparc') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 10px;">
                          @csrf
                         
                          <div style="display: flex; flex-direction: column; align-items: flex-start;">
                           

                            <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 5px;">
                                <label for="motcle" style="margin-right: 10px;">Numéro Place :</label>
                                <input class="shadow-sm form-control border-0 small" type="text" name="numero" placeholder="Numéro Place" style="font-size: 13px; height: 36px; width: 60%; background-color: rgb(255, 255, 255);">
                            </div>

                            <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 5px;">
                                <label for="motcle" style="margin-right: 10px;">Mot clé :</label>
                                <input class="shadow-sm form-control border-0 small" type="text" name="motcle" placeholder="mot clé" style="font-size: 13px; height: 36px; width: 60%; background-color: rgb(255, 255, 255);">
                            </div>
                        
                            <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 5px;">
                                <label for="date_entree" style="margin-right: 10px;">Date d'entrée :</label>
                                <input class="shadow-sm form-control border-0 small" type="date" name="date_entree" style="font-size: 13px; height: 36px; width: 60%; background-color: rgb(255, 255, 255);">
                            </div>
                        
                            <div style="display: flex; justify-content: flex-end; align-items: center; width: 100%; margin-bottom: 5px;">
                                <label for="etat" style="margin-right: 10px;">État :</label>
                                <select class="shadow-sm form-control border-0 small" name="etat" style="font-size: 13px; height: 36px; width: 60%; background-color: rgb(255, 255, 255);">
                                    <option value="">choisir état</option>
                                    <option value="Libre">Libre</option>
                                    <option value="Non libre">Non libre</option>
                                </select>
                            </div>
                            
                        
                            <div style="display: flex; justify-content: flex-end; width: 100%; margin-top: 1px;">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231, 142, 69);"><i class="fas fa-search"></i></button>
                            </div>

                        </div>
                                 
                        
                      </form>
           
                    </div>
                    <p>Nombre de Véhicule dans le Garage : {{ $count }}</p>
                    <p>Nombre de Place Libre : {{ 15 - $count }}</p>
                 
                    <style>
                      /* Optionnel : Style personnalisé pour éviter le wrap du texte dans les cellules */
                      .table td.text-nowrap {
                        white-space: nowrap;
                      }
                      .table th.text-nowrap {
                        white-space: nowrap;
                      }
                      .table-responsive {
      max-height: 400px; /* Ajustez cette valeur comme nécessaire */
                       }
                       #table-cell {
                         padding-bottom: 1px;
                       }

                    </style>

<div class="table-responsive" style="margin-top:103px;">
  <table class="table table-bordered">
    <thead>
      <tr>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Numéro de Place</th>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">État</th> 
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Immatriculation</th>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Propriétaire</th>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Nombre de Mécaniciens</th>                     
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Date d'entrée</th>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Date de début</th>
        <th class="text-nowrap" style="background-color: #ffffff;padding: 1px;">Date fin</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($liste as $rows)
      <tr>

        <td class="text-nowrap">{{ $rows->idnumero_place }}</td>
        <td class="text-nowrap">{{ $rows->etat }}</td>
        <td class="text-nowrap">{{ $rows->immatriculation }}</td>
      
        @if($rows->etat == 'Non libre')

        <td class="text-nowrap">{{ $rows->nom }}</td>
        <td class="text-nowrap">{{ $rows->nombre_mecaniciens }}</td>
        <td class="text-nowrap">{{ FormatDate::formatDateTime($rows->date_entree) }}</td>
        
        @else

        <td></td>
        <td></td>
        <td>...</td>
        
        @endif

        <td class="text-nowrap">{{ FormatDate::formatDateTime($rows->datedebut) }}</td>
        
        <td class="text-nowrap">{{ FormatDate::formatDateTime($rows->datefin) }}</td>

        @if($rows->date_sortie == null && $rows->iddemande != null)
        <td class="text-nowrap" style="width: 248px;padding: 1px;">    
         
          <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModall{{ $rows->iddemande }}"  type="button" style="background-color: #eb3834;">Faire Sortir</button></a>
         
          <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModall2{{ $rows->iddemande }}"  type="button" style="background-color: #eb3834;">Modifier</button></a>
        </td>
        @endif

    </tr>
      
<div class="modal fade" id="exampleModall{{ $rows->iddemande }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Sortir une Véhicule</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
                                                           
      <form action="{{ url('/sortir_voiture') }}" method="post">
          @csrf  
        
        <input type="hidden" name="iddemande" value="{{ $rows->iddemande }}">  
          
       

        <div>
          <div><label style="margin: 0;font-size: 17px;">Date de sortie:</label></div>
          <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="date_sortie" style="width: 90%;height: 35px;"></div>
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



<div class="modal fade" id="exampleModall2{{ $rows->iddemande }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="exampleModalLabel">Modification</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
                                                           
      <form action="{{ url('/modifier_demande') }}" method="post">
          @csrf  
        
        @if($rows->iddemande != null)

        <input type="hidden" name="iddemande" value="{{ $rows->iddemande }}">  

        <div>
          <div><label style="margin: 0;font-size: 17px;">Nombre de mécanicien:</label></div>
          <div style="width: 100%;"><input class="bg-light border rounded" type="number" name="nombre_mecaniciens" value="{{ demande_reparation::getDetail($rows->iddemande)->nombre_mecaniciens }}" style="width: 90%;height: 35px;"></div>
      </div>

      <div>
        <div>
          <label style="margin: 0;font-size: 17px;">Numéro de Place:</label>
        </div>
        <div style="width: 100%;">
          <select class="bg-light border rounded" style="width: 90%; height: 35px;" name="idnumero_place">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
            <option value="12">12</option>
            <option value="13">13</option>
            <option value="14">14</option>
            <option value="15">15</option>
          </select>
        </div>
      </div>

        <div>
          <div><label style="margin: 0;font-size: 17px;">Date d'entrée:</label></div>
          <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="date_entree" value="{{ demande_reparation::getDetail($rows->iddemande)->date_entree }}" style="width: 90%;height: 35px;"></div>
      </div>

        <div>
            <div><label style="margin: 0;font-size: 17px;">Date de début:</label></div>
            <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datedebut" value="{{ demande_reparation::getDetail($rows->iddemande)->datedebut }}" style="width: 90%;height: 35px;"></div>
        </div>

        <div>
          <div><label style="margin: 0;font-size: 17px;">Date fin:</label></div>
          <div style="width: 100%;"><input class="bg-light border rounded" type="datetime-local" name="datefin" value="{{ demande_reparation::getDetail($rows->iddemande)->datefin }}" style="width: 90%;height: 35px;"></div>
      </div>

      @endif

        <button class="btn btn-primary" type="submit" style="margin: 0px;background-color: #e78e45;width: 100px;height: auto;margin-top: 20px;">Modifier</button>

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
      <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationparc') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
        <span aria-hidden="true">&laquo;</span>
        <span class="sr-only">Précédent</span>
      </a>
    </li>
    @foreach($listeNumeroPage as $rows)
    <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
      <a class="page-link" href="{{ url('/paginationparc') }}/{{ $rows }}">{{ $rows }}</a>
    </li>
    @endforeach
    <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
      <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationparc') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
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