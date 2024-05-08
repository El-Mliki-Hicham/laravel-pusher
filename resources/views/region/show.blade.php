@extends('master')
@section('content')
    <div class="content-body">
        <div class="container-fluid">
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">{{ ucfirst(__('models/region.region')) }}</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ ucfirst(__('models/region.region')) }}</a></li>
                </ol>
            </div>


            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-3 col-lg-6  col-md-6 col-xxl-5 ">
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane fade show active" id="first">
                                            <img class="img-fluid" src="" alt="">
                                        </div>

                                    </div>

                                </div>
                                <!--Tab slider End-->
                                <div class="col-xl-9 col-lg-6  col-md-6 col-xxl-7 col-sm-12">
                                    <div class="product-detail-content">
                                        <!--Product details-->
                                        <div class="new-arrival-content pr">
                                            <h4>{{ ucfirst(__('models/region.region')) }}</h4>
                                            <div class="comment-review star-rating">
                                                <ul>
                                                    <li><i class="fa fa-info"></i></li>

                                                </ul>
                                            </div>
                                            

            <p> {{ucFirst(__('models/region.label'))}}: <span class='item'>{{$region->label}}</span>
            </p>
            
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- review -->
        </div>
    </div>
@endsection
