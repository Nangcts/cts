<table  style="width:100%;border: 1px dotted #f9f9f9;" class="table tbl-cart table-hover table-striped table-responsive">
    <thead style="background: #f5f5f5;">
        <tr>
          <th>(Tên)</th>
          <th>(điện thoại)</th>
          <th>(Email)</th>
          <th>(Địa chỉ)</th>
          <th>(Nội dung)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data->ho_ten }}</td>
            <td>{{$data->phone}}</td>
            <td>{{ $data->email }}</td>
            <td>{{ $data->adress }}</td>
            <td><{{ $data->messages }}</td>
        </tr>
    </tbody>
</table>


