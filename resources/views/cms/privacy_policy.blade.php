@extends('admin_dash.main')
@section('content')
<link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css"
    href="https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/components/bootstrap/dist/css/bootstrap-theme.min.css">
<style>
    .dropdown-menu li a,
    .btn {
        color: #000;
    }

    .dropdown-menu {
        padding-left: 5px;
    }

    .dropdown-menu li a:hover {
        color: #000;
        width: 100% !important;
        text-decoration: none;
    }

    .dropdown-menu li {
        display: inline-block !important;
        width: 120px;
    }

    .wysihtml5-toolbar {
        list-style: none;
        padding: 0px;
    }

    .wysihtml5-toolbar li {
        display: inline-block;
    }

    .bg-primary {
        background-color: #5e72e4 !important;
    }

    .text-primary {
        color: #5e72e4 !important;
    }
</style>
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">CMS</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="{{route('home')}}"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item active" aria-current="page">Privacy</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-lg-6 col-5 text-right">
                    <a class="btn btn-sm btn-neutral" href="{{route('about_us')}}">About Us</a>
                    <a class="btn btn-sm btn-neutral" href="{{route('privacy')}}"
                        style="background-color:#e8c046">Privacy &
                        Policy</a>
                    <a class="btn btn-sm btn-neutral" href="{{route('terms')}}">Terms & Condition</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt--6">
    <!-- Table -->
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="row">
                    <div class="col-md-12">



                        <!-- <div class="card-header"> <h3 class="card-title"> About Us  </h3>   </div> -->
                        <!-- /.card-header -->
                        <form action="{{route('edit_privacy')}}" method="post">
                            @csrf
                            <div class="card-body pad">
                                <div class="mb-3">

                                    <textarea class="textarea" name="privacy" placeholder="Enter text ..."
                                        style="width: 100%; height: 200px; font-size: 14px; line-height: 18px;">{{@$privacy->privacy}}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-primary" style="color:#fff">SAVE</button>
                                    </div>
                                </div>
                            </div>

                        </form>


                    </div>
                    {{-- close --}}
                </div>


            </div>
        </div>
    </div>

</div>


@endsection
@section('script')
<script
    src="https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/components/wysihtml5x/dist/wysihtml5x-toolbar.min.js">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
<script src="https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/components/handlebars/handlebars.runtime.min.js">
</script>
<script src="https://bootstrap-wysiwyg.github.io/bootstrap3-wysiwyg/dist/bootstrap3-wysihtml5.min.js"></script>
<script>
    $('.textarea').wysihtml5({
    toolbar: {
      fa: true
    }
  });
</script>


@endsection
