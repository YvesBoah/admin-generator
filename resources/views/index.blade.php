{{'@'}}extends('admin.layout.index')

{{'@'}}section('title')
    <h1>{{ ucfirst($objectNamePlural) }} listing</h1>

    <a class="btn btn-primary" href="{{'{{'}} url('admin/{{ $objectName }}/create') }}" role="button">Add new {{ $objectName }}</a>
{{'@'}}endsection

{{'@'}}section('head')
    <tr>
        @foreach($columns as $col)<th>{{ ucfirst($col) }}</th>
        @endforeach

        <th>Actions</th>
    </tr>
{{'@'}}endsection

{{'@'}}section('body')
    {{'@'}}foreach(${{ $objectNamePlural }} as ${{ $objectName }})
    <tr>
        @foreach($columns as $col)<td>{{'{{'}} ${{ $objectName }}->{{ $col }} }}</td>
        @endforeach

        <td>
            <a class="btn btn-info btn-xs" href="{{'{{'}} route('admin/{{ $objectName }}/edit', ['{{ $objectName }}' => ${{ $objectName }}]) }}" role="button">Edit</a>
            <form method="post" action="{{'{{'}} route('admin/{{ $objectName }}/destroy', ['{{ $objectName }}' => ${{ $objectName }}]) }}" class="form-inline">
                <input name="_method" type="hidden" value="DELETE">
                {{'{'}}!! csrf_field() !!{{'}'}}
                <button type="submit" class="btn btn-xs btn-danger">Delete</button>
            </form>
        </td>
    </tr>
    {{'@'}}endforeach
{{'@'}}endsection