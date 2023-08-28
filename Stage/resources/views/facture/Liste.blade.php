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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Liste Facture</label></header>
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
                        <form action="{{ url('/recherchefacture') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;">
                            
                            <select class="shadow-sm form-control border-0 small" placeholder="etat" name="etat" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                              <option value="">État :</option>
                              <option value="0">Non payé</option>
                              <option value="1">Payé</option>
                          </select>
                          

                            <input class="shadow-sm form-control border-0 small" type="text" name="numero" placeholder="numero facture" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">

                            <input class="shadow-sm form-control border-0 small" type="text" name="nom" placeholder="client" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">

                            <input class="shadow-sm form-control border-0 small" type="date" name="date" placeholder="date" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">

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
                                  <th class="text-nowrap" style="background-color: #ffffff;">Numéro de Facture</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Client</th> 
                                  <th class="text-nowrap" style="background-color: #ffffff;">Total tout compte</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Total escompte</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Reste à payer</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Etat paiement</th>
                                  <th class="text-nowrap" style="background-color: #ffffff;">Date</th> 
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($liste as $rows)
                              <tr>
                                <td class="text-nowrap"><a href="{{ url('/mouvementfacture') }}/{{ $rows->idfacture }}">{{ $rows->formatted_idfacture }}</a></td>
                                <td class="text-nowrap">{{ $rows->nom }}</td>
                                <td class="text-nowrap">{{  number_format($rows->montant_total,2,',',' ')  }} Ar</td>
                                <td class="text-nowrap">{{  number_format($rows->montant_paye,2,',',' ')  }} Ar</td>
                                <td class="text-nowrap">{{  number_format($rows->reste_a_payer,2,',',' ')  }} Ar</td>
                                @if($rows->est_paye == 1)
                                <td class="text-nowrap">Payée</td>
                                @else
                                <td class="text-nowrap">Non Payée</td>
                                @endif
                                <td class="text-nowrap">{{ FormatDate::format($rows->date)  }}</td>
                                                     
                                <td class="text-nowrap">    
                                    <a href="{{ url('/exporterFacture') }}/{{ $rows->iddemande }}/0/0"><button class="btn btn-primary"  type="button" style="background-color: #eb3834;">Exporter PDF</button></a>
                                </td>
                                @if($rows->est_paye == 0)
                                <td class="text-nowrap">
                                  <a><button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal{{ $rows->idfacture }}"  type="button" style="background-color: #eb3834;">Paiement facture</button> </a>
                                  </td>  
                                @endif                           
                              </tr>

                              <div class="modal fade" id="exampleModal{{ $rows->idfacture }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Mot de passe Super Admin</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                                                                           
                                                        <form action="{{ url('/verspaiementfacture') }}" method="post">
                                                          @csrf  
                                                        
                                                         <input type="hidden" name="idfacture" value="{{ $rows->idfacture }}" >

                                                
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
                          <a class="page-link" href="{{ $currentPage == 1 ? '#' : url('/paginationfacture') }}/{{ $currentPage - 1 }}" aria-label="Précédent">
                            <span aria-hidden="true">&laquo;</span>
                            <span class="sr-only">Précédent</span>
                          </a>
                        </li>
                        @foreach($listeNumeroPage as $rows)
                        <li class="page-item {{ $rows == $currentPage ? 'active' : '' }}">
                          <a class="page-link" href="{{ url('/paginationfacture') }}/{{ $rows }}">{{ $rows }}</a>
                        </li>
                        @endforeach
                        <li class="page-item {{ $currentPage == $lastPage ? 'disabled' : '' }}">
                          <a class="page-link" href="{{ $currentPage == $lastPage ? '#' : url('/paginationfacture') }}/{{ $currentPage + 1 }}" aria-label="Suivant">
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