<?php
use App\Models\FormatNumber;
use App\Models\FormatDate;
?>
<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
  <script>
    $(document).ready(function() {
        @if (session('error'))
            $('#exampleModal{{ session('numero') }}').modal('show');
        @endif
    });
</script>
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Liste Vente</label></header>
            @include('template.Message')
            <div class="container-fluid" >
              {{-- ato miasa --}}
                      
              <div class="row" style="margin-top:-80px;">
                <div class="col" style="margin-top: 100px;">
                    <div class="input-group" style="width: 100%;height: auto;padding: 8px;">
                        <div>
                          <a href="{{ url('/formvente') }}">
                            <button class="btn btn-primary" type="button" style="background-color: #e78e45;">
                              Ajouter
                              <i class="fa fa-plus" style="margin: 0px;margin-left: 10px;"></i>
                            </button>
                          </a>
                            
                        </div>
                  
                        <div class="input-group-append">
                        </div>
                        <form action="{{ url('/recherchevente') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
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
                                    <th style="background-color: #ffffff;">ID</th>
                                    <th style="background-color: #ffffff;">Client</th>
                                    <th style="background-color: #ffffff;">Désignation</th>
                                    <th style="background-color: #ffffff;">Prix unitaire</th>
                                    <th style="background-color: #ffffff;">quantité</th>
                                    <th style="background-color: #ffffff;">Mode de paiement</th>
                                    <th style="background-color: #ffffff;">Date</th>
                                    <th style="background-color: #ffffff;">Etat paiement</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($liste as $rows)
                              <tr>
                                <td>{{ $rows->idvente }}</td>
                                <td>{{ $rows->nom }}</td>
                                <td>{{ $rows->libelle }}</td>
                                <td>{{ FormatNumber::formatter($rows->prix_unitaire) }} Ar</td>
                                <td>{{ $rows->quantite }}</td>
                                <td>{{ $rows->type_paiement }}</td>
                                <td>{{ FormatDate::format($rows->date) }}</td>
                                @if($rows->etat_paiement == 0) 
                                <td style="width: 248px;">    
                                    <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $rows->idvente }}"  type="button" style="background-color: #eb3834;">Valider</button> </a>
                                    </td>
                                @else     
                                <td style="width: 248px;">    
                                  Validé
                                </td>
                                @endif 

                            </tr>
                            <div class="modal fade" id="exampleModal{{ $rows->idvente }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Mot de passe Super Admin</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                                                                         
                                                      <form action="{{ url('/valider_vente') }}" method="post">
                                                        @csrf  
                                                      
                                                          <input type="hidden" value="{{ $rows->idvente }}" name="idvente">
                                                        
                                                                <div class="login-one-ico" style="width: 100%;height: auto;"><img src="assets/img/RN1_garage_bg-removebg-preview.png" style="width: 100%;height: auto;"></div>
                                                             
                                                                <input name="mdp" class="form-control" type="password" value="hardi" id="input" placeholder="Password" style="margin: auto;margin-top: 10px;">
                                                                
                                                                <input type="submit" class="btn btn-primary"
                                                                        role="button" id="button" style="background-color: #e78e45;margin: auto;margin-top: 10px;" value="Valider">
                                                        
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
                          <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationvente') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Précédent</span>
                          </a>
                        </li>
                        @foreach($listeNumeroPage as $rows)
                        <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                          <a class="page-link" href="{{ url('/paginationvente') }}/{{ $rows }}">{{ $rows }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationvente') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
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