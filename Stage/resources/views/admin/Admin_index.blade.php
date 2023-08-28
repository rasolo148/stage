<!DOCTYPE html>
<html>
@include('template.Head')
<body>
    @include('template.Message')

        <form action="{{ url('/log_admin') }}" method="post" class="login-one-form" style="height: 400px;width: 100%;">
            @csrf  
            <div>
                <div class="col text-center" style="padding: auto;height: auto;">
                    <div class="login-one-ico" style="width: 100%;height: auto;"><img src="assets/img/RN1_garage_bg-removebg-preview.png" style="width: 100%;height: auto;"></div>
                    <div class="form-group">
                    <div>
                    </div><input class="form-control" type="text" name="mail" id="input" placeholder="Username" value="tojo"  style="margin: auto;"><input name="password" class="form-control" type="password" value="tojo" id="input" placeholder="Password" style="margin: auto;margin-top: 10px;">
                    
                    <input type="submit" class="btn btn-primary"
                            role="button" id="button" style="background-color: #e78e45;margin: auto;margin-top: 10px;" value="Se Connecter"></div></div>
            </div>
        </form>
      

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>