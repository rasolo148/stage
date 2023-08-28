<div id="content" style="height: auto;">
    <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top" style="color: rgb(255,255,255);">
        <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle mr-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars" style="color: rgb(231,142,69);"></i></button>
            <form class="form-inline d-none d-sm-inline-block mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search"
                style="width: 350px;">
                <span><img class="d-xl-flex align-items-xl-center" src="<?php echo asset('assets/img/RN1_garage_bg-Just-Logo.png'); ?>" style="width: 250px;margin: auto;margin-right: 0px;margin-left: 0px;height: auto;"></span>
            </form>
            <ul class="nav navbar-nav flex-nowrap ml-auto">
             
              <p>{{ session('role') }}</p>
              <a  role="presentation" href="{{ url('/logout') }}" style="color:red;"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a>
           
        </ul>
</div>
</nav>