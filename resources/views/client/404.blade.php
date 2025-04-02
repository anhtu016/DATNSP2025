@extends('client.layout.default')
@section('content')
    
<main class="bg_gray">
    <div id="error_page">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-xl-7 col-lg-9">
                    <img src="client/img/404.svg" alt="" class="img-fluid" width="400" height="212">
                    <p>The page you're looking is not founded!</p>
                    <form>
                        <div class="search_bar">
                            <input type="text" class="form-control" placeholder="What are you looking for?">
                            <input type="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /error_page -->
</main>

     <!--Css-->
@push('css')
  
	<!-- SPECIFIC CSS -->
    <link href="{{asset('client/css/error_track.css')}}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{asset('client/css/custom.css')}}" rel="stylesheet">
@endpush
     <!--ENd Css-->

     <!--JS-->
@push('js')
  

@endpush
     <!--ENd JS-->
@endsection