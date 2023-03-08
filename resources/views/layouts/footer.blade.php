<footer class="main-footer sp-two">
    <div class="auto-container">
        <!--Widgets Section-->
        <div class="widgets-section">
            <div class="row clearfix">
                
                        <div class="col-md-12">
                            <div class="footer-widget logo-widget">
                                <div class="widget-content">
                                    <div class="footer-logo text-center">
                                        <a target="_blank" href="{{ url('/') }}"><img class="lazy-image" src="{{asset('/assets_front/images/resource/image-spacer-for-validation.png')}}" data-src="{{asset('/assets_front/img/logo.png')}}" alt="" /></a>
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
                    <li><a href="{{URL::to('/terms-conditions')}}" target="_blank">Terms & Conditions</a></li>
                </ul>
                <!--Scroll to top Two-->
                <div class="copyright d-flex"><span>© 2022</span> <a href="#" class="text-light px-1">Asaser</a> <span>All Rights Reserved.</span></div>
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
    function select_package(package,vat_per,total_member_added,months_label,currency,member) {
        var package = $.parseJSON(package);
        var price = package.price;
        var member_cost = package.member_cost;

        $('.pricing-block').show()
        $('#package_id').val(package.id)

        @if(App::getlocale()=='ar')
            $('#summary_package_name').html(package.name_ar)
            $('#summary_package_desc').html(package.description_ar)
            $('#summary_package_duration').html(package.duration + months_label)
            $('#summary_package_type').html(package.account_type.name_ar)
        @else
            $('#summary_package_name').html(package.name)
            $('#summary_package_desc').html(package.description)
            $('#summary_package_duration').html(package.duration + months_label)
            $('#summary_package_type').html(package.account_type.name)
        @endif

       
        $('#summary_package_price').html(package.price + currency)
        $('#summary_package_amount').html(package.sub_total + currency)

        $('#member_cost').val(member_cost)
        $('#package_cost').val(package.sub_total)
        $('#vat_per').val(vat_per)
        $('#vat_amt').html(package.vat_amt + currency)
        $('#total_pay_amount').html(package.total_amt + currency)
        
        if(total_member_added == 0) {
            $('.sel_member_text').html('1 (Free)')
            $('#select_member_addon')
                .find('option')
                .remove()
                .end()
                .append('<option value="1">1 (Free)</option>')
                .val('1')
            ;
            $('#select_member_addon').append($("<option></option>").attr("value", '2').text('2 (1X' + member_cost + ') ' + currency)); 
            $('#select_member_addon').append($("<option></option>").attr("value", '3').text('3 (2X' + member_cost + ') ' + currency)); 
            $('#select_member_addon').append($("<option></option>").attr("value", '4').text('4 (3X' + member_cost + ') ' + currency)); 
            
        } else {
            $('.sel_member_text').html(total_member_added + member)
        }
       
        
        
    }

   
    
    $('#select_member_addon').on('change', function() {
        //alert( $(this).find("option:selected").text() );
        
        $('#member_no').val($(this).val())
        var package_cost = $('#package_cost').val();
        var member_cost = $('#member_cost').val();
        var vat_per = $('#vat_per').val();
        $('.sel_member_text').html($(this).find("option:selected").text())
        var total_member_addon_cost = 0;
        if($(this).val() > 1) {

          total_member_addon_cost = (($(this).val() - 1) * member_cost);
        }
        var sub_total = +total_member_addon_cost + +package_cost;
        var vat_amt = '--';
        if(vat_per > 0) {
            vat_amt = ((sub_total/100)*vat_per).toFixed(2)
            $('#vat_amt').html(vat_amt + 'SAR')
        } else {
            $('#vat_amt').html('--')
        }
        $('#summary_package_amount').html(sub_total + 'SAR')
        var total_payable_cost;
        if(vat_amt>0) {
            total_payable_cost = +sub_total + +vat_amt;
        } else {
            total_payable_cost = sub_total;
        }
       
        $('#total_pay_amount').html(total_payable_cost + 'SAR')
        
    });

    function select_member_addon(member_add_on,package,currency) {
        
        $('.pricing-block').show()
        var sub_total = package.member_cost * member_add_on;
        $('#summary_member_add_on').html(member_add_on)
        $('#summary_sub_amount').html(sub_total + currency)
        var vat_amt = package.vat_amt * member_add_on;
        $('#vat_amt').html(vat_amt + currency)
        total_pay_amt = +sub_total + +vat_amt;
        $('#summary_total_pay_amount').html(total_pay_amt + currency)
        $('#member_cost').val(package.member_cost)
        $('#member_add_on').val(member_add_on)
    }
</script>