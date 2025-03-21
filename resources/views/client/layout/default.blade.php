<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from www.ansonika.com/allaia/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Mar 2025 05:23:37 GMT -->

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Allaia Bootstrap eCommerce Template - ThemeForest">
	<meta name="author" content="Ansonika">
	<title>Allaia | Bootstrap eCommerce Template - ThemeForest</title>

	@stack('css')

</head>

<body>

	<div id="page">
		<!-- Header -->

		<!--Navbar-->
            @include('client.layout.navbar')
		<!--END Navbar-->
        
		<!--End Header -->
        
        <!-- Main -->
		    @yield('content')
		<!--End Main -->

		<!--Footer-->
            @include('client.layout.footer')
		<!--End Footer-->
	</div>
	<!-- page -->

	<div id="toTop"></div><!-- Back to top button -->

	@include('client.layout.partials.js')

</body>

<!-- Mirrored from www.ansonika.com/allaia/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 Mar 2025 05:24:02 GMT -->

</html>