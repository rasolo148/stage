<?php
use App\Models\FormatDate;
use Carbon\Carbon;
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
            <header class="shadow-sm" style="width: 100%;height: auto;margin-top: -30px;padding: 0px;background-color: #ffffff;padding-left: 30px;padding-top: 14px;margin-bottom: 10px;"><label style="font-family: Nunito, sans-serif;font-size: 16px;">Graphique</label></header>
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
                        <form action="{{ url('/recherchestatistiques') }}" method="POST" class="d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search" style="width: 80%;margin: 0px;margin-right: 0px;margin-left: 60%;">
                          @csrf
                          <div class="input-group" style="width: auto;margin-left: 60%;">
                            <select class="shadow-sm form-control border-0 small" name="mois" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                             <option value="">choisir mois</option>
                              @foreach (range(1, 12) as $month)
                                  <option value="{{ $month }}">{{ \Illuminate\Support\Carbon::createFromDate(null, $month)->monthName }}</option>
                              @endforeach
                          </select>

                          <input class="shadow-sm form-control border-0 small" type="text" name="annee" placeholder="entrez un année" style="font-size: 13px;height: 36px;width: 20%;background-color: rgb(255,255,255);">
                          
                          <div class="input-group-append">
                                <button class="btn btn-primary py-0" type="submit" style="background-color: rgb(231,142,69);"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                    </div>
                    <div class="table-responsive">
                       
                        <br>
                        <canvas id="myChart"></canvas>
                        <?php
                        $xValues = [];
                        $yValues = [];
                        
                        foreach ($liste as $row) {
                          $xValues[] = Carbon::create()->month($row->month)->locale('fr')->monthName;
                          $yValues[] = $row->profit;
                        }
                        ?>
                      <style>
                      
                    </style> 
    <script>
const data = {
  labels: <?php echo json_encode($xValues); ?>,
  datasets: [{
    label: 'Benefices',
    data: <?php echo json_encode($yValues); ?>,
    fill: true,
    backgroundColor: 'rgba(255,165,0, 0.2)',
    borderColor: 'rgb(255,165,0)',
    tension: 0.1
  }]
};

const config = {
  type: 'line',
  data: data,
  options: {
    responsive: true,
    plugins: {
      title: {
        display: true,
        text: 'Graphique en ligne avec Chart.js'
      },
      legend: {
        labels: {
          fontColor: 'rgb(255,255,0)'
        }
      }
    },
    interaction: {
      mode: 'index',
      intersect: false
    },
    scales: {
      x: {
        display: true,
        title: {
          display: true,
          text: 'Mois'
        }
      },
      y: {
        display: true,
        title: {
          display: true,
          text: 'Valeur'
        }
      }
    }
  }
};

const myChart = new Chart(
  document.getElementById('myChart'),
  config
);

  </script>
                    </div>
                </div>
            </div>
            </div>
        </div>
       
    </div>
    </div>
    </div>
     @include('template.Footer')
    
     <script src="<?php echo asset('assets4/Acc_Admin/bootstrap/js/bootstrap.min.js');?>"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/bs-init.js');?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/HTML-Table-to-Excel-V2.js');?>"></script>
    <script src="<?php echo asset('assets4/Acc_Admin/js/theme.js');?>"></script>
</body>

</html>