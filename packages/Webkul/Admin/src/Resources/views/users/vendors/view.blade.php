@extends('admin::layouts.content')

@section('page_title')
    {{$vendor->name}}
@stop

@section('content')
    <div class="content">
            <div class="page-header">
                <div class="page-action">
                    <a  class="btn btn-lg btn-primary" href="{{route('admin.vendors.approve', $vendor->id)}}">
                        Approve
                    </a>
                    <a  class="btn btn-lg btn-danger" style="color:white !important;" href="{{route('admin.vendors.delete.view', $vendor->id)}}">
                        Delete
                    </a>
                </div>
            </div>
            <div class="page-content">
                <div class="form-container">
                    @csrf()
                    <input name="_method" type="hidden" value="PUT">
                    <accordian title="Store Details" :active="true">
                        <div slot="body">
                            <div class="control-group">
                                <label style="text-transform:capitalize;">name</label>
                                <input type="text" class="control" readonly value="{{ $vendor->name }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">email</label>
                                <input type="email" class="control" readonly value="{{ $vendor->email }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">phone</label>
                                <input type="text" class="control" readonly value="{{ $vendor->phone }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">address</label>
                                <input type="text" class="control" readonly value="{{ $vendor->address }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">city</label>
                                <input type="text" class="control" readonly value="{{ $vendor->city }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">Country</label>
                                <input type="text" class="control" readonly value="{{ $vendor->country }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">State</label>
                                <input type="text" class="control" readonly value="{{ $vendor->state }}">
                            </div>

                            <div class="control-group">
                                <label style="text-transform:capitalize;">pincode</label>
                                <input type="text" class="control" readonly value="{{ $vendor->pincode }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">display name</label>
                                <input type="text" class="control" readonly value="{{ $vendor->display_name }}">
                            </div>

                            <div class="control-group">
                                <label style="text-transform:capitalize;">GSTIN</label>
                                <input type="text" class="control" readonly value="{{ $vendor->gstin }}">
                            </div>

                            <div class="control-group col-12">
                                <label style="text-transform:capitalize;">Store description</label>
                                <input type="text" class="control" readonly value="{{ $vendor->description }}">
                            </div>
                        
                            <div class="control-group col-12">
                                <label style="text-transform:capitalize;">additional notes</label>
                                <input type="text" class="control" readonly value="{{ $vendor->additional_notes }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">facebook link</label>
                                <input type="text" class="control" readonly value="{{ $vendor->facebook_link }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">instagram link</label>
                                <input type="text" class="control" readonly value="{{ $vendor->instagram_link }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">twitter link</label>
                                <input type="text" class="control" readonly value="{{ $vendor->twitter_link }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">youtube link</label>
                                <input type="text" class="control" readonly value="{{ $vendor->youtube_link }}">
                            </div>
                        </div>
                    </accordian>
                    <accordian title="Owner Details" :active="false">
                        <div slot="body">
                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner name</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_name }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner email</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_email }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner phone</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_phone }}">
                            </div>
                        
                            <div class="control-group col-12">
                                <label style="text-transform:capitalize;">owner address</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_address }}">
                            </div>
                            
                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner pincode</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_pincode }}">
                            </div>
                        
                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner city</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_city }}">
                            </div>

                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner country</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_country }}">
                            </div>

                            <div class="control-group">
                                <label style="text-transform:capitalize;">owner state</label>
                                <input type="text" class="control" readonly value="{{ $vendor->owner_state }}">
                            </div>
                        </div>
                    </accordian>
                    <accordian title="Certificate and Images Section" :active="false">
                        <div slot="body">
                            <div class="row" style="flex-wrap:wrap;">
                                @if (!is_null($vendor->mca_certificate))
                                    <div style="width:20%;padding:0 15px;">
                                        <label>MCA Certificate</label>
                                        <a href="{{ asset($vendor->mca_certificate) }}" target="_blank">
                                            <div style="margin:10px 0"><button class="btn btn-primary btn-lg"> Download File</button></div>
                                        </a>
                                    </div>
                                @endif
                                @if (!is_null($vendor->gst_certificate))
                                    <div style="width:20%;padding:0 15px;">
                                        <label>GST Certificate</label>
                                        <a href="{{ asset($vendor->gst_certificate) }}" target="_blank">
                                            <div style="margin:10px 0"><button class="btn btn-primary btn-lg"> Download File</button></div>
                                        </a>
                                    </div>
                                @endif
                                @if (!is_null($vendor->other_certificate))
                                    <div style="width:20%;padding:0 15px;">
                                        <label>Other Certificate</label>
                                        <a href="{{ asset($vendor->other_certificate) }}" target="_blank">
                                            <div style="margin:10px 0"><button class="btn btn-primary btn-lg"> Download File</button></div>
                                        </a>
                                    </div>
                                @endif
                                @if (!is_null($vendor->profile_image))
                                    <div style="width:20%;padding:0 15px;">
                                        <label>Profile Image</label>
                                        <a href="{{ asset($vendor->profile_image) }}" target="_blank">
                                            <div style="margin:10px 0"><button class="btn btn-primary btn-lg"> Download File</button></div>
                                        </a>
                                    </div>
                                @endif
                                @if (!is_null($vendor->store_images))
                                    <div style="width:20%;padding:0 15px;">
                                        <label>Store Images</label>
                                        @foreach (explode(',',$vendor->store_images) as $item)
                                            <a href="{{ asset($item) }}" target="_blank">
                                                <div style="margin:10px 0"><button class="btn btn-primary btn-lg"> Download File</button></div>
                                            </a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </accordian>                    
                </div>
            </div>
    </div>
@stop