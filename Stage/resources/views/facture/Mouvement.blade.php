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
                        <form action="{{ url('/recherchemouvementfacture') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;">
                            <input class="shadow-sm form-control border-0 small" type="date" name="date" placeholder="date" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">

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
                                  <th style="background-color: #ffffff;">Numéro Facture</th>
                                  <th style="background-color: #ffffff;">Client</th> 
                                  <th style="background-color: #ffffff;">Montant payé</th>
                                  <th style="background-color: #ffffff;">Mode de paiement</th>
                                  <th style="background-color: #ffffff;">Date</th> 
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($liste as $rows)
                              <tr>
                                <td>{{ $rows->formatted_idfacture }}</td>
                                <td>{{ $rows->nom }}</td>
                                <td>{{  number_format($rows->montant,2,',',' ')  }} Ar</td>
                                <td>{{ $rows->type_paiement }}</td>
                                <td>{{ FormatDate::format($rows->datepaiement)  }}</td>
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