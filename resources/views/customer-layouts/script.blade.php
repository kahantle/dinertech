<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="{{asset('assets/customer/js/jquery-1.12.4.min.js')}}"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<!-- <script src="{{asset('assets/customer/js/jquery.min.js')}}"></script> -->
<script src="{{asset('assets/customer/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/customer/js/toastr.min.js')}}"></script>
<script src="{{asset('assets/customer/js/sweetalert.min.js')}}"></script>
@yield('scripts')
<script src="{{asset('assets/customer/js/setting/setting.js')}}"></script>
<script>
    function openLogin() {
        document.getElementById("LoginSidebar").style.display = "block";
    }

    function closeLogin() {
        document.getElementById("LoginSidebar").style.display = "none";
    }

    function openSignup() {
        document.getElementById("SignupSidebar").style.display = "block";
    }

    function closeSignup() {
        document.getElementById("SignupSidebar").style.display = "none";
    }

    function openForgotPassword() {
        document.getElementById("LoginSidebar").style.display = "none";
        document.getElementById("forgotPassword").style.display = "block";
    }

    function closeForgotPassword() {
        document.getElementById("forgotPassword").style.display = "none";
    }
    function openForgotPasswordForm(){
        $("#verification-success").modal("hide");
        document.getElementById("forgotPasswordForm").style.display = "block";   
    }

    function openVerification() {
        document.getElementById("verification").style.display = "block";
        $('.modal-backdrop').remove()
            /*$(document.body).removeClass("modal-open");*/
        document.getElementById("forgotPassword").style.display = "none";
        document.getElementById("verification-btn").style.display = "none";
    }

    function closeVerification() {
        document.getElementById("verification").style.display = "none";
    }

    function openMenu() {
        document.getElementById("menu-icon-menu").style.display = "block";
        document.getElementsByTagName("html")[0].style.overflow = "hidden";
    }

    function closeMenu() {
        document.getElementById("menu-icon-menu").style.display = "none";
        document.getElementsByTagName("html")[0].style.overflow = "scroll";
    }

    function openModifierRepeat() {
        $('.modal-backdrop').remove();
        document.getElementById("modifier").style.display = "none";
    }

    function openSettingMenu() {
        document.getElementById("menu-icon-menu").style.display = "none";
        document.getElementById("settingmenu").style.display = "block";
    }

    function closeSettingMenu() {
        document.getElementById("menu-icon-menu").style.display = "block";
        document.getElementById("settingmenu").style.display = "none";
    }

    var header = document.getElementById("myDIV");
    var btns = header.getElementsByClassName("btn");
    for (var i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
            var current = document.getElementsByClassName("active");
            if (current.length > 0) {
                current[0].className = current[0].className.replace(" active", "");
            }
            this.className += " active";
        });
    }

    
</script>
