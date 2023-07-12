<div class="panel-heading"><p class="h3">List of user entered URL's to be checked</p></div>
<table class="table table-hover table-striped">
    <thead>
    <tr>
        <th>URL</th>
        <th>Added</th>
        <th>Checked</th>
        <th colspan="3">Actions</th>
    </tr>
    </thead>

    <tbody>
    @forelse($links as $link)
        <tr>
            <td>{{ $link->url }}</td>
            <td>{{ $link->created_at->format('Y-m-d H:i:s') }}</td>
            <td>{{ $link->checked_at->format('Y-m-d H:i:s') }}</td>
            @isset($link->redirects)
            <td><a href="{{ url('links/' .$link->id) }}">Results</a></td>
            @else
            <td><span class="badge badge-danger">Link is broken</span></td>
            @endif
            <td><a href="{{ url('links/' .$link->id. '/edit') }}">Edit</a></td>
            <td>
                <form action="/links/{{ $link->id }}" method="post">
                    {{ method_field('delete') }}
                    {!! csrf_field() !!}
                    <a href="{{ url('links/' .$link->id. '/destroy') }}" onclick="this.closest('form').submit();return false;">Delete</a></td>
                </form>
        </tr>
    @empty
        <tr>
            <td>No URL entered</td>
        </tr>
    @endforelse
    </tbody>
</table>
