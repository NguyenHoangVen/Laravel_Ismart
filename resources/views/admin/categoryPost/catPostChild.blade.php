@foreach ($catPostChild as $item)
    <tr>
        <th scope="row">{{ $t }}</th>
        <td>{{ $item->name }}</td>
        <td>{{ $item->slug }}</td>
        @if ($item->parent_id == 0)
            <td>None</td>
        @else
            <td>{{ $item->catPostParent->name }}</td>
        @endif
        <td>
            <a href="" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                data-placement="top" title="Edit"><i class="fa fa-edit"></i></a>
            <a href="" onclick="return confirm('Bạn chắc chắn xóa bản ghi này')"
                class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                data-placement="top" title="Delete"><i class="fa fa-trash"></i></a>
        </td>
    </tr>
    @include('admin.categoryPost.catPostChild', ['catPostChild' => $item->catPostChild])
@endforeach
