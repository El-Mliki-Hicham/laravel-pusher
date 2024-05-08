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
           
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="">{{__('crud.add_new')}} {{ ucfirst(__('models/region.region')) }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                             <form class="needs-validation" novalidate="" action="{{route("region.store")}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-xl-6">
                                       
                                           
                <div class='mb-3 row'>
                <label class='col-lg-4 col-form-label' for='validationCustom01'>
                {{ucFirst(__('models/region.label'))}}
                </label>
                <div class='col-lg-6'>
                    <input type='text' class='form-control' name='label' id='validationCustom01' value='label' placeholder='{{ucFirst(__('models/region.label'))}}' required=''>
                    <div class='invalid-feedback'>
                    </div>
                </div>
            </div>
            
                                           @if ($errors->any())
                                           <div class="alert alert-danger">
                                               <ul>
                                                   @foreach ($errors->all() as $error)
                                                       <li>{{ $error }}</li>
                                                   @endforeach
                                               </ul>
                                           </div>
                                       @endif
                                        <div class="mb-3 row">
                                            <div class="col-lg-8 ms-auto">
                                                <button type="submit" class="btn btn-primary">Ajouter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection





