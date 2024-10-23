@extends('layouts.master')
@section('title') Products @endsection
@section('css')

@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('routeUrl') {{url('/')}} @endslot
        @slot('li_1') Products @endslot
        @slot('title') Products @endslot
    @endcomponent


    <div class="row">
        <div class="col-lg-12">
            <form action="{{route('admin.product.store')}}" method="post" enctype="multipart/form-data" id="RolesForm">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"> {{($data['isEdit']==1)?'Edit':'Add'}} Product</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <input type="number" name="id"  style="display: none" value="{{(isset($data['product']))? $data['product']->id:0}}">

                            <div class="col-lg-4">
                                <label for="job-position-Input" class="form-label">Category<span class="text-danger">*</span></label>
                                <select name="cat_id" class="form-control" id="">
                                    <option value="">Choose One</option>
                                    @isset($data['category'])
                                        @foreach ($data['category'] as $row)
                                        <option value="{{$row->id}}" {{(isset($data['product']) AND  $data['product']->cat_id==$row->id)?"selected":''}}>{{$row->title}} </option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <label for="job-position-Input" class="form-label">Title<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="job-position-Input" placeholder="Enter Title" name="title" required value="{{(isset($data['product']))? $data['product']->title:''}}"/>
                            </div>


                            <div class="col-lg-4">
                                <label for="job-position-Input" class="form-label">Price<span class="text-danger">*</span></label>
                                <input type="number" class="form-control" id="job-position-Input" placeholder="Enter Price" name="price" value="{{(isset($data['product']))? $data['product']->price:''}}" required/>

                            </div>



                            <div class="col-lg-12">
                                    <label for="formFile" class="form-label">Description</label>
                                    <textarea name="description" cols="10" rows="3" class="form-control">{{(isset($data['product']))? $data['product']->description:''}}</textarea>

                            </div>
                            <div class="col-lg-4">
                                <div>

                                    <label for="formFile" class="form-label">Image</label>
                                    <input class="form-control" type="file" name="product_image" id="formFile"  value="{{(isset($data['product']))? $data['product']->thumbnail:''}}" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div>
                                    @isset($data['product'])
                                        <img src="{{ asset('storage/uploads/').'/'.$data['product']->thumbnail }}" class=" avatar-xl img-thumbnail user-profile-image m-2" alt="Image">
                                    @endisset<br>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-lg-12 mb-2">
                    <div class="hstack justify-content-end gap-2">
                        <a type="button" href="{{route('admin.product.index')}}" class="btn btn-primary">Back</a>
                        <button type="submit" class="btn btn-primary btn-submit">{{($data['isEdit']==1)?'Save Changes':'Save'}} </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/custom-js/product/product.js') }}"></script>

@endsection
