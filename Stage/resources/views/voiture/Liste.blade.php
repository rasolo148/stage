<?php
use App\Models\FormatNumber;
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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Liste Véhicule</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>

                        <a href="{{ url('/formvoiture') }}">
                            <button class="btn btn-primary" type="button" style="background-color: #e78e45;">
                              Ajouter une nouvelle Véhicule
                              <i class="fa fa-plus" style="margin: 0px;margin-left: 10px;"></i>
                            </button>
                        </a>
                            
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
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Immatriculation</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Marque</th> 
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Modele</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Energie</th>
                                  <th class="text-nowrap"  style="background-color: #ffffff;">Propriétaire</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                            @foreach ($liste as $rows)
                              <tr>
                                <td class="text-nowrap" >{{ $rows->immatriculation }}</td>
                                <td class="text-nowrap" >{{ $rows->marque }}</td>
                                <td class="text-nowrap" >{{ $rows->modele }}</td>
                                <td class="text-nowrap" >{{ $rows->energie }}</td>
                                <td class="text-nowrap" >{{ $rows->nom }}</td>
                            </tr>
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