<div class="row">
     <div class="col-12">
         <form action="{{ route("administrator.property-change-gallery-type") }}" method="GET">
             <select name="gallery_type" class="form-control" style="width: 50%!important;" onchange="this.form.submit()">
                 <option value="1" {{ session("gallery_type") == 1 ? "selected" : "" }}>{{ __("General") }}</option>
                 <option value="2" {{ session("gallery_type") == 2 ? "selected" : "" }}>{{ __("Internal Use") }}</option>
             </select>
         </form>
     </div>
</div>
<div class="row">

    @if(!is_null($attachments))
        @foreach($attachments as $attachment)
            <div class="col-3" style="margin-top: 20px!important;">
                <div class="card card-default">
                    <div class="gallery">
                        <a href="{{ asset(config("global.property_image_path").$property->id."/".$attachment->name) }}" class="big">
                            <img src="{{ asset(config("global.property_image_path").$property->id."/".$attachment->name) }}" onerror="this.src='{{ url("none.png") }}';" width="100%">
                        </a>
                    </div>
                    @if($property->status != Constants::PROPERTY_STATUS["solved"])
                        <a href="#" class="btn btn-danger btn-sm btn-remove" data-id="{{ $attachment->id }}">{{ __("remove") }}</a>
                        <form method="post" action="{{ route("administrator.property-remove-gallery", [$property->id, $attachment->id]) }}" id="{{ $attachment->id }}">
                            @csrf
                            <input type="hidden" name="attachment_id" value="{{ $attachment->id }}">
                            <input type="hidden" name="property_id" value="{{ $property->id }}">
                        </form>

                        @endif
                </div>
            </div>
        @endforeach
    @endif
</div>

<div class="row">
    @if($property->status != Constants::PROPERTY_STATUS["solved"])
        <div class="col-12 text-right" style="margin-top: 20px!important;">
            <form action="{{ route("administrator.property-upload-gallery", $property->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="property_id" value="{{ $property->id }}"/>
                <div class="row">
                    <div class="col-12">
                        <input type='file' id="input-profile-image" multiple class="btn btn-primary" name="image[]" value="{{old("image[]")}}"/>
                        <br/>
                        <button type="submit" class="btn btn-primary btn-sm" style="margin-top: 10px;float: right">{{ __("Upload") }}</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
</div>