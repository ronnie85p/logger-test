@extends('layouts.default')

@section('content')

    <div class="row mb-4">
        <div class="col">
            <a class="btn btn-light" href="{{ route('method.create') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                </svg>

                Add Method
            </a>
        </div>
    </div>

    <form onchange="this.submit()">
        <div class="row">
            <div class="col-4">
                <label class="mb-2 fw-bold" for="{{ $form->sortby['name'] }}">Сортировать по:</label>
                <select class="form-control form-select" name="{{ $form->sortby['name'] }}">
                    <option value="">По умолчанию</option>
                    @foreach ($form->sortby['options'] as $k => $v)
                        <option value="{{ $k }}"@if (request()->get($form->sortby['name']) == $k) selected @endif>{{ $v }}</option> 
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label class="mb-2 fw-bold" for="{{ $form->sortdir['name'] }}">В порядке:</label>
                <select class="form-control form-select" name="{{ $form->sortdir['name'] }}">
                    @foreach ($form->sortdir['options'] as $k => $v)
                        <option value="{{ $k }}"@if (request()->get($form->sortdir['name']) == $k) selected @endif>{{ $v }}</option> 
                    @endforeach
                </select>
            </div>
        </div>
    </form>
    <hr class="mb-4" />

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>URI</th>
                <th>Last query</th>
                <th class="text-end"></th>
            </tr>
        </thead>

        <tbody>
            @forelse ($paginator as $item)
                <tr>
                    <td>
                        {{ $item->name }}
                    </td>
                    <td>{{ $item->endpoint }}</td>
                    <td>
                        @if ($lastQuery = $item->lastQueryLog())
                            <div>{{ $lastQuery->created_at }}</div>
                        @else 
                            <div>-</div>
                        @endif
                        {{-- <pre>{{ print_r($item, true)}}</pre> --}}
                    </td>
                    <td class="text-end">
                        <form class="d-inline" action="{{ route('api.method.exec', $item) }}" method="get" data-ajax="1">
                            @csrf

                            <button class="btn btn-sm btn-primary" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-play-fill" viewBox="0 0 16 16">
                                    <path d="m11.596 8.697-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                </svg>

                                Run
                            </button>
                        </form>

                        <form class="d-inline" action="{{ route('api.method.delete', $item) }}" method="delete" title="Delete entry &laquo;{{ $item->name }}&raquo;?" data-ajax="1">
                            @csrf

                            <button class="btn btn-sm btn-outline-danger" type="submit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5Zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6Z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1ZM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118ZM2.5 3h11V2h-11v1Z"/>
                                </svg>

                                Delete
                            </button>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td class="text-secondary" colspan="4">
                        @if (count($logs = $item->queryLogs()))
                            <div class="fw-bold mb-2">Queries:</div>

                            @foreach ($logs as $log)
                                <div>{{ $log->created_at }} - {{ $log->time_exec }} - {{ $log->data }}</div>
                            @endforeach
                            <hr />
                            <div class="">
                                MIN: {{ $item->min_time_exec }}; MAX: {{ $item->max_time_exec }}; MID: {{ $item->avg_time_exec }}; 
                            </div>
                        @else
                            <div class="fst-italic">No queries yet</div>
                        @endif
                    </td>
                </tr>
            @empty
                <tr> 
                    <td class="text-center text-muted" colspan="4">No data</td>
                </tr>
            @endforelse
        </tbody>

        @if (count($paginator))
        <tfoot>
            <tr>
                <td colspan="2">

                </td>
                <td class="text-end text-muted" colspan="2">
                    {{ $paginator->onFirstPage() ? $paginator->count() : $paginator->perPage() + $paginator->count() }} из {{ $paginator->total() }} записей
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    {{ $paginator->links('logger.pages.item', ['pages' => $pages]) }}
@stop