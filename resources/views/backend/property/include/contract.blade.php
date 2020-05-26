<style>
	.list-contract ul {
		list-style: none;
		font-size: 15px;
	}

	.list-contract ul li:before {
		content: '✓';
		font-weight: bold;
		font-size: 20px;
		color: blue;
		margin-right: 20px;
	}

</style>

<div class="row">
	<div class="col-12 text-right">
		<a href="{{ route("administrator.property-view", $property->id) }}?action=contract&method=add" class="btn btn-primary btn-sm">
			<i class="fa fa-plus"></i>
			{{ __("Add New") }}
		</a>
	</div>
</div>
<table class="table table-hover">
	<thead>
		<th>#</th>
		<th>{{ __("Title") }}</th>
		<th>{{ __("Attachment") }}</th>
		<th>{{ __("Furniture") }}</th>
		<th>{{ __("Deposit") }}</th>
		<th>{{ __("Commission") }}</th>
		<th></th>
	</thead>
	<tbody>
		@if(!empty($contract_list))
			<?php $i = 0; ?>
			@foreach($contract_list as $value)
                <?php
					$i = $i + 1;
					$object = json_decode($value->data);

					?>
				<tr>
					<td>{{ $i }}</td>
					<td>{{ @$object->title }}</td>
					<td>
						<a target="_blank" href="{{  asset(config("global.owner_contract_path"). @$object->owner_contract) }}">
							{{ @$object->owner_contract }}
						</a>
					</td>
					<td>{{ !empty(@$object->furniture)? furniture(@$object->furniture) : "" }}</td>
					<td>
						@if(!empty(@$object->deposit))
							@if(@$object->deposit_type == 1)
								{{ @$object->deposit ." month(s)" }}
							@else
								{{ "$ " .number_format(@$object->deposit,  2) }}
							@endif
						@else
							{{ __("N/A") }}
						@endif
					</td>
					<td>
						@if(!empty(@$object->commission))
							@if(@$object->commission_type == 1)
								{{ "$ ". @$object->commission }}
							@else
								{{ @$object->commission ." %" }}
							@endif
						@else
							{{ __("N/A") }}
						@endif
					</td>
					<td>
						<span style="overflow: visible; position: relative; width: 110px;">
							<a href="{{ route("administrator.property-view", $property->id) }}?action=contract&method=edit&contract-id={{ $value->id }}" title="{{ trans("Edit") }}" class="btn btn-sm btn-clean btn-icon btn-icon-md">
								<i class="la la-edit"></i>
							</a>
							<a href="#" title="{{ trans("Delete") }}"
							   class="btn btn-sm btn-clean btn-icon btn-icon-md btn-contract-remove"
							   data-contract_id="{{ $value->id }}">
								<i class="la la-trash text-danger"></i>
							</a>
							 <form method="post" action="{{ route("administrator.remove-contract", [$value->id, $property->id]) }}" id="{{ $value->id }}">
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
							</form>
						</span>
					</td>

				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="6">{{ __("Not Found!") }}</td>
				</tr>
			@endif
	</tbody>
</table>
{{--
@if(!empty(@$data["owner_contract"]))
	<iframe width="100%" height="540px" src="{{  asset(config("global.owner_contract_path"). @$data["owner_contract"]) }}"></iframe>
@endif
--}}
{{--<div class="list-contract">--}}
	{{--<ul>--}}
		{{--<li>--}}
			{{--<a target="_blank" href="{{ url('kh/administrator/property/view/'.$property->id.'?export=contract-owner') }}">--}}
				{{--{{ __("Contract Between Owner and Company") }}--}}
			{{--</a>--}}
		{{--</li>--}}
		{{--<li>--}}
			{{--<a target="_blank" href="{{ url('kh/administrator/property/view/'.$property->id.'?export=contract-customer') }}">--}}
				{{--{{ __("Contract Between Company with Customer") }}--}}
			{{--</a>--}}
		{{--</li>--}}
	{{--</ul>--}}
{{--</div>--}}