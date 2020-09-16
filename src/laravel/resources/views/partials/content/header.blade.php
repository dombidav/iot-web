<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ $title ?? '' }}</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    @foreach(($breadcrumb ?? []) as $key => $route)
                        <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $key }}</a></li>
                    @endforeach
                    <li class="breadcrumb-item active">{{ $title ?? '' }}</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
