@extends('admin.layout.default')
@section('content')

<ul>
      @foreach ($categories as $category)
          <li>
              <a href="{{ $category->slug }}">{{ $category->name }}</a>
              @if ($category->children->isNotEmpty())
                  <ul>
                      @foreach ($category->children as $child)
                          <li>
                              <a href="{{ $child->slug }}">{{ $child->name }}</a>
                              @if ($child->children->isNotEmpty())
                                  <ul>
                                      @foreach ($child->children as $grandchild)
                                          <li>
                                              <a href="{{ $grandchild->slug }}">{{ $grandchild->name }}</a>
                                          </li>
                                      @endforeach
                                  </ul>
                              @endif
                          </li>
                      @endforeach
                  </ul>
              @endif
          </li>
      @endforeach
  </ul>
      <!-- css-->
    @push('admin_css')
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Plugins css -->
    <link href="{{asset('admin/assets/libs/dropzone/dropzone.css')}}" rel="stylesheet" type="text/css" />

    <!-- Layout config Js -->
    <script src="{{asset('admin/assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('admin/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('admin/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('admin/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('admin/assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

   @endpush
   <!--end css-->

   <!-- js-->
   @push('admin_js')
       <!-- JAVASCRIPT -->
       <script src="{{asset('admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
       <script src="{{asset('admin/assets/libs/simplebar/simplebar.min.js')}}"></script>
       <script src="{{asset('admin/assets/libs/node-waves/waves.min.js')}}"></script>
       <script src="{{asset('admin/assets/libs/feather-icons/feather.min.js')}}"></script>
       <script src="{{asset('admin/assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
       <script src="{{asset('admin/assets/js/plugins.js')}}"></script>

       <!-- ckeditor -->
       <script src="{{asset('admin/assets/libs/@ckeditor/ckeditor5-build-classic/build/ckeditor.js')}}"></script>

       <!-- dropzone js -->
       <script src="{{asset('admin/assets/libs/dropzone/dropzone-min.js')}}"></script>

       <script src="{{asset('admin/assets/js/pages/ecommerce-product-create.init.js')}}"></script>

       <!-- App js -->
       <script src="{{asset('admin/assets/js/app.js')}}"></script>
   @endpush
   <!--end js-->
@endsection