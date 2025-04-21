@extends('admin.layout.main')
@section('title')
    Setting  Create
@stop
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card ">
                    <div class="card-body">
                        <h3 class="text-22 text-midnight text-bold mb-4"> Create Setting</h3>
                        <div class="row    mt-4 mb-4 ">
                            <div class="col-12 text-right">
                                <a href="{!! route('admin.settings.index',$settings->id) !!}"
                                   class="btn btn-primary btn-sm "> Back </a>
                            </div>
                        </div>
                        {{--                        @dd($roles)--}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="w-100">
                            <form action="{!! route('admin.settings.update',$settings->id) !!}"
                                  enctype="multipart/form-data"
                                  id="form_validation" autocomplete="off" method="post">
                                @csrf
                                @method('put')
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label>Tittle</label>
                                            </div>
                                            <input type="text" required class="form-control"
                                                   value="{!! $settings ->title !!} " name="title">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label> Type</label>
                                            </div>
                                            <select required id="type" name="type"
                                                    class="form-control select">
                                                <option value="">Select Option</option>
                                                <option value="Logo">Logo</option>
                                                <option value="footer_Logo">Footer Logo</option>
                                                <option value="mail">Mail</option>
                                                <option value="mobile_number">Mobile Number</option>
                                                <option value="google_play_store_link">Google play store link</option>
                                                <option value="apple_store_link">Apple store link</option>
                                                <option value="Simple">Simple</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label> Icons </label>
                                            </div>
                                            <input type="file" class="form-control" value="" name="icons">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label> Image </label>
                                            </div>
                                            <input type="file" required class="form-control" value="" name="image">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label> Long Description</label>
                                            </div>
                                            <textarea id="summernote" type="text" required
                                                      class="form-control summernote" value=""
                                                      name="long_description">{!! $settings->long_description !!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="input-label">
                                                <label> Text </label>
                                            </div>
                                            <textarea id="summernote1" type="text" required
                                                      class="form-control summernote" value=""
                                                      name="text">{!! $settings->text !!}</textarea>
                                        </div>
                                    </div>

                                </div>


                                <div class="row mt-5 mb-3">
                                    <div class="col-12">
                                        <div class="form-group text-right">
                                            <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                            <a href="{!! route('admin.settings.index') !!}"
                                               class=" btn btn-sm btn-danger">Cancel </a>
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
@stop

@section('js')

    <script src="{{asset('admin/assets/plugins/summernote-editor/summernote1.js')}}"></script>
    <script src="{{asset('admin/assets/js/summernote.js')}}"></script>
    <script>
        jQuery(function (e) {
            'use strict';
            $(document).ready(function () {
                $('.summernote').summernote();
            });
        });
    </script>
@endsection


