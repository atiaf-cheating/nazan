
<!-- FOOTER -->
<footer  class="section" id="footer">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <!-- footer logo -->
                    <div class="footer-logo">
                        <a class="logo" href="index.php">
                            <img src="{{asset('img/logo.png')}}" alt="">
                        </a>
                    </div>
                    <!-- /footer logo -->
                    <!-- footer social -->
{{--                    @php dd($about_info) @endphp--}}
                    <ul class="footer-social">
                        <li><a href="{{$about_info->facebook_url}}"><i class="fa fa-facebook"></i></a></li>
                        <li><a href="{{$about_info->twitter_url}}"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="{{$about_info->instagram_url}}"><i class="fa fa-instagram"></i></a></li>
                        <li><a href="{{$about_info->email}}"><i class="fa fa-google-plus"></i></a></li>
                        <li><a href="#"><i class="fa fa-youtube"></i></a></li>
                    </ul>
                    <!-- /footer social -->
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">@lang('messages.Main Menu')</h3>
                    <ul class="list-links">
                        <li><a href="{{url('customer/home')}}">@lang('messages.Home')</a></li>
                        <li><a href="{{url('customer/aboutus')}}">@lang('messages.about us')</a></li>
                        <li><a href="{{url('customer/policy')}}">@lang('messages.policy')</a></li>
                        <li><a href="{{url('customer/blog')}}">@lang('messages.blog')</a></li>
                        <li><a href="{{url('customer/promotions')}}">@lang('messages.offers')</a></li>
                        <li><a href="{{url('customer/contact_us')}}">@lang('messages.Contact us')</a></li>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

            <div class="clearfix visible-sm visible-xs"></div>

            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">Departments</h3>
                    <ul class="list-links">
                        <li><a href="{{url('customer/products')}}">MAkeUp</a></li>
                        <li><a href="{{url('customer/products')}}">Bags</a></li>
                        <li><a href="{{url('customer/products')}}">Shoes</a></li>
                        <li><a href="{{url('customer/products')}}">clothes</a></li>
                        <li><a href="{{url('customer/products')}}">Dresses</a></li>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

            <!-- footer widget -->
            <div class="col-md-3 col-sm-6 col-xs-6">
                <div class="footer">
                    <h3 class="footer-header">@lang('messages.Keep in touch')</h3>
                    <ul class="list-links keep">
                        <li><i class="fa fa-home"></i> Egypt, cairo</li>
                        <li><i class="fa fa-phone"></i>{{$about_info->phone}}</li>
                        <li><i class="fa fa-envelope"></i> {{$about_info->email}}</li>
                    </ul>
                </div>
            </div>
            <!-- /footer widget -->

        </div>
        <!-- /row -->
        <hr>
        <!-- row -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2 text-center">
                <!-- footer copyright -->
                <div class="footer-copyright">
                    <p>@lang('messages.© Copyright 2019 Nazan - Designed and Developed by') <a href="http://www.atiafco.com/" target="_blank"> Atiaf For Completely Solutions‏</a></p>
                </div>
                <!-- /footer copyright -->
            </div>
        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</footer>
<!-- /FOOTER -->

<!-- jQuery Plugins -->
<script src="{{asset('js/jquery.min.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/slick.min.js')}}"></script>
<script src="{{asset('js/nouislider.min.js')}}"></script>
<script src="{{asset('js/jquery.zoom.min.js')}}"></script>
<script src="{{asset('js/main.js')}}"></script>

</body>

</html>
