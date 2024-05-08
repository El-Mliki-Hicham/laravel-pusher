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
            @if ($message = Session::get('msg'))
            <div class="alert alert-success solid alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                <strong>  </strong>{{ $message }}.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                </button>
            </div>
        @endif
            
           
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{route("region.create")}}" class="btn btn-primary">{{__('crud.add_new')}} {{ ucfirst(__('models/region.region')) }}</a>
                    </div>
                  
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                     <th>{{ucFirst(__('models/region.label'))}}</th>

                                     <th>{{ucFirst(__("crud.action"))}}</th>
                                </thead>
                                <tbody>
                                    @foreach ($list as $value)
                                        <tr>
                                            <td>{{$value->label}}</td>

                                           <td>
                                            <div class="d-flex">
                                                <a href="{{route("region.edit",$value->id)}}" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                <form method="POST" action="{{route("region.destroy",$value->id)}}">
                                                    @csrf
                                                    @method('DELETE')
                                                <button type="submit" class="btn btn-danger shadow btn-xs sharp me-1 delete-button"><i class="fa fa-trash"></i></button>
                                                </form>
                                                <a  href="{{route("region.show",$value->id)}}" class="btn btn-success shadow btn-xs sharp"><i class="fa fa-eye"></i></a>
                                            </div>
                                           </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
@endsection



