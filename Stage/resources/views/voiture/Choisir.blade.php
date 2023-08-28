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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Liste Véhicule</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>
                        
                        </div>
                  
                        <div class="input-group-append">
                        </div>
                        <form action="{{ url('/recherchevoiture') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;"><input class="shadow-sm form-control border-0 small" type="text" name="motcle" placeholder="recherche" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                              <div class="input-group-append">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                  <th style="background-color: #ffffff;">Immatriculation</th>
                                  <th style="background-color: #ffffff;">Marque</th> 
                                  <th style="background-color: #ffffff;">Modèle</th>
                                  <th style="background-color: #ffffff;">Énergie</th>
                                  <th style="background-color: #ffffff;">Propriétaire</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @foreach ($liste as $rows)
                              <tr id="carRow_{{ $rows->idvoiture }}" class="car-row" onclick="openForm('{{ $rows->immatriculation }}','{{ $rows->marque }}', '{{ $rows->modele }}', '{{ $rows->energie }}', '{{ $rows->nom }}', '{{ $rows->idvoiture }}')">
                                <td>{{ $rows->immatriculation }}</td>
                                <td>{{ $rows->marque }}</td>
                                <td>{{ $rows->modele }}</td>
                                <td>{{ $rows->energie }}</td>
                                <td>{{ $rows->nom }}</td>
                            </tr>
                            <script>
                                function openForm(immatriculation, marque, modele, energie, proprietaire, rowId) {
                                    const allRows = document.querySelectorAll('.car-row');
                                    allRows.forEach(row => {
                                        row.classList.remove('selected');
                                    });
                        
                                    const selectedRow = document.getElementById('carRow_' + rowId);
                                    selectedRow.classList.add('selected');
                                   
                                    document.getElementById('carForm').style.display = 'block';
                                    document.getElementById('idvoiture').value = rowId;
                                    document.getElementById('immatriculation').value = immatriculation;
                                    document.getElementById('marque').value = marque;
                                    document.getElementById('modele').value = modele;
                                    document.getElementById('energie').value = energie;
                                    document.getElementById('proprietaire').value = proprietaire;
                                }
                            </script>
                            @endforeach
                           
                            </tbody>
                        </table>
                    </div>
                

                    <div id="carForm" style="display: none;">
                        <form action="{{ url('/selectionner') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" value="{{ $id }}"> 
                            <input type="hidden" name="idvoiture" id="idvoiture">
                            <input type="hidden" name="immatriculation" id="immatriculation">
                            <input type="hidden" name="marque" id="marque">
                            <input type="hidden" name="modele" id="modele">
                            <input type="hidden" name="energie" id="energie">
                            <input type="hidden" name="proprietaire" id="proprietaire">
                            <button type="submit">Choisir</button>
                        </form>
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

                      .car-row.selected {
            background-color: #3498db;
            color: white;
        }

        
                      
                    </style>
                    <nav aria-label="Page navigation example">
                      <ul class="pagination">
                        <li class="page-item {{ $currentPage == 1 ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationvoiture') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Précédent</span>
                          </a>
                        </li>
                        @foreach($listeNumeroPage as $rows)
                        <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                          <a class="page-link" href="{{ url('/paginationvoiture') }}/{{ $rows }}">{{ $rows }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationvoiture') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
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