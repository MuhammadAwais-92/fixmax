@extends('front.layouts.app')
@section('content')
    @include('front.common.breadcrumb')
    <main class="portfolio spacing-y">
        <div class="container">
            <div class="row port-dt-row">
                <div class="col-md-12">
                    <div class="title-btnz-row d-flex mb-25">
                        <div class="title">
                            {!! translate($project->name) !!}
                        </div>
                    </div>
                    <p class="text-desc mb-5">
                        {!! translate($project->description) !!}
                    </p>
                </div>
                @foreach ($project->images as $image)
                    <div class="col-md-4 col-lg-3 col-sm-6 col-6-ctm ">
                        <div class="portfolio-card">
                            <img src="{!! imageUrl(url($image->file_path), 262,222, 95, 3) !!}" alt="portfolio-img"
                                 class="img-fluid portfolio-img">
                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </main>
@endsection
