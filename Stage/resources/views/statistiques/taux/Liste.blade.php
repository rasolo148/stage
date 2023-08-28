<!DOCTYPE html>
<html>
@include('template.Head')
<body id="page-top">
    <div id="wrapper">
      @include('template.SideBar')
        <div class="d-flex flex-column" id="content-wrapper">
            @include('template.Header')
            </nav>
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Analyse de l'efficacité des différentes mains-d'œuvre</label></header>
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
                
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                  <th style="background-color: #ffffff;">Main d'œuvre</th>
                                  <th style="background-color: #ffffff;">Taux d'utilisation</th> 
                                   
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($taux as $service => $taux)
                              <tr>
                                <td>{{ $service }}</td>
                                <td>{{ $taux !== 0 ? number_format($taux, 2) : '0.00' }}%</td>
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