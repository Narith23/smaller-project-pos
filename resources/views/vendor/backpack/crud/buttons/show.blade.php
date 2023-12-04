@if ($crud->hasAccess('show'))
	@if (!$crud->model->translationEnabled())
        <a
            href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}"
            class="btn btn-sm btn-link text-primary tooltip-selector"
            title="{{ trans('backpack::crud.preview') }}"
            data-toggle="tooltip"
            data-placement="bottom"
        >
            <i class="la la-eye"></i>
        </a>
	@else
        <div class="btn-group">
            <a
                href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}"
                class="btn btn-sm btn-link pr-0 text-primary tooltip-selector"
                title="{{ trans('backpack::crud.preview') }}"
                data-toggle="tooltip"
                data-placement="bottom"
            >
                <i class="la la-eye"></i>
            </a>
            <a class="btn btn-sm btn-link dropdown-toggle text-primary pl-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">{{ trans('backpack::crud.preview') }}:</li>
                @foreach ($crud->model->getAvailableLocales() as $key => $locale)
                    <a class="dropdown-item" href="{{ url($crud->route.'/'.$entry->getKey().'/show') }}?locale={{ $key }}">{{ $locale }}</a>
                @endforeach
            </ul>
        </div>
	@endif
@endif
