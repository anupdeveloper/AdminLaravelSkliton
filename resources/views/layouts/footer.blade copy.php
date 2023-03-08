<footer class="main-footer sp-two">
    <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="row clearfix">
                
                        <div class="col-md-12">
                            <div class="footer-widget logo-widget">
                                <div class="widget-content">
                                    <div class="footer-logo text-center">
                                        <a href="index.html"><img class="lazy-image" src="{{asset('/assets_front/images/resource/image-spacer-for-validation.png')}}" data-src="{{asset('/assets_front/img/logo.png')}}" alt="" /></a>
                                    <h3>Awaser</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
            
                
                <!--Column-->
        
                
            </div>
            
        </div>
    </div>        
    <!-- Footer Bottom -->
    <div class="auto-container">
        <div class="footer-bottom">
            <div class="row m-0 justify-content-between">
                <ul class="menu">
                    <li><a href="#">Privacy Policy </a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                </ul>
                <!--Scroll to top Two-->
                <div class="copyright">© 2022 <a href="#">Asaser</a> All Rights Reserved.</div>
            </div>                
        </div>
    </div>
</footer>


<script src="{{asset('/assets_front/js/jquery.js')}}"></script>
<script src="{{asset('/assets_front/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/assets_front/js/bootstrap-select.min.js')}}"></script>
<script src="{{asset('/assets_front/js/wow.js')}}"></script>
<script src="{{asset('/assets_front/js/lazyload.js')}}"></script>
<script src="{{asset('/assets_front/js/scrollbar.js')}}"></script>
<script src="{{asset('/assets_front/js/TweenMax.min.js')}}"></script>
<script src="{{asset('/assets_front/js/swiper.min.js')}}"></script>
<script src="{{asset('/assets_front/js/script.js')}}"></script>

<!--Google Map APi Key-->
<script src="http://maps.google.com/maps/api/js?key=AIzaSyCJRG4KqGVNvAPY4UcVDLcLNXMXk2ktNfY"></script>
<script src="{{asset('/assets_front/js/gmaps.js')}}"></script>
<script src="{{asset('/assets_front/js/map-script.js')}}"></script>

<script>
    function select_package(package_id,token) {

        // ajax call
        $('#user_token').val(token);
        $('#package_id').val(package_id);
        $('#select-sub').submit();    

        
    }
</script>