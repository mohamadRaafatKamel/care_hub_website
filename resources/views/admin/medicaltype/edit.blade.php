@extends('layouts.admin')
@section('title','تعديل')
@section('medicaltype_view','')
@section('content')
<?php 
if(! $permissoin = \App\Models\Role::havePremission(['medicaltype_idt']))
    $readonly="readonly";
else 
    $readonly="";
?>
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ __('Home') }} </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.medicaltype')}}">  {{ __('Medical Type') }} </a>
                                </li>
                                <li class="breadcrumb-item active">تعديل
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">تعديل</h4>
                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.include.alerts.success')
                                @include('admin.include.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">
                                        @if ($permissoin)
                                        <form class="form form-horizontal" action="{{route('admin.medicaltype.update',$datas -> id)}}" method="POST"
                                              enctype="multipart/form-data">
                                            @csrf
                                        @endif
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-home"></i> البيانات  </h4>


                                                <div class="form-group row">
                                                    <label class="col-md-2 label-control" for="name_ar">الاسم بالعربي</label>
                                                    <div class="col-md-6">
                                                        <input type="text" value="{{$datas -> name_ar}}" id="name_ar"
                                                                class="form-control" required {{ $readonly }}
                                                                placeholder="الاسم بالعربي"
                                                                name="name_ar">
                                                        @error('name_ar')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-2 label-control" for="name_en">الاسم بالانجليزي</label>
                                                    <div class="col-md-6">
                                                        <input type="text" value="{{$datas -> name_en}}" id="name_en"
                                                                class="form-control" required {{ $readonly }}
                                                                placeholder="الاسم بالانجليزي  "
                                                                name="name_en">
                                                        @error('name_en')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-2 label-control" for="price_list_id">{{ __('Price List') }}</label>
                                                    <div class="col-md-6">
                                                        <select class="select2 form-control" name="price_list_id">
                                                            <option value="">-- {{ __('Price List') }} --</option>
                                                            @foreach($priceLists as $priceList)
                                                                <option value="{{ $priceList->id }}" 
                                                                    @if ($datas ->price_list_id == $priceList->id) selected @endif>
                                                                        {{ $priceList->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        @error('price_list_id')
                                                        <span class="text-danger">{{$message}}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <label class="col-md-2 label-control" for="disabled">الحالة</label>
                                                    <div class="col-md-6">
                                                        <input type="checkbox"  value="0" name="disabled" {{ $readonly }}
                                                        id="switcheryColor4"
                                                        class="switchery" data-color="success"
                                                        @if($datas -> disabled  == 0 ) checked @endif />
                                                    @error('disabled')
                                                    <span class="text-danger">{{$message}}</span>
                                                    @enderror
                                                    </div>
                                                </div>



                                            </div>

                                            @if ($permissoin)
                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i> تراجع
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i>  تحديث
                                                    </button>
                                                </div>
                                            @endif
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection
