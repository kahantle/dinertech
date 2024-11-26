<!-- Core Scripts - Include with every page -->
<script src="{{asset('assets/admin/js/jquery-1.10.2.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/jquery-ui.custom.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/modernizr-custom-3.3.1.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/LAB.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/bemat-admin-common.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/d3.min.js')}}" charset="utf-8" type="text/javascript"></script>
<script src="{{asset('assets/admin/js/nv.d3.js')}}" type="text/javascript"></script>
<script>
    function toggleFullScreen(elem) {
        if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
            if (elem.requestFullScreen) {
            elem.requestFullScreen();
            } else if (elem.mozRequestFullScreen) {
            elem.mozRequestFullScreen();
            } else if (elem.webkitRequestFullScreen) {
            elem.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
            } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
            }
        } else {
            if (document.cancelFullScreen) {
            document.cancelFullScreen();
            } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
            } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
            } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
            }
        }
    }
</script>
@yield('script')
