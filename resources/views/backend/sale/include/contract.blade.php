@if(!empty(@json_decode(@$sale->data)->contract))
    <div class="row">
        <div class="col-12">
            <iframe width="100%"
                    height="540px"
                    src="{{  asset(config("global.contract_path"). @json_decode(@$sale->data)->contract) }}">
            </iframe>
        </div>
    </div>

    @else

@endif