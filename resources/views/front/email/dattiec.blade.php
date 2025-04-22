<table  style="width:100%;border: 1px dotted #ccc;" class="table tbl-cart table-hover table-striped table-responsive">
    <thead style="background: #f5f5f5;">
        <tr>
          <th>(Dịch vụ)</th>
          <th>(Tên)</th>
          <th>(điện thoại)</th>
          <th>(Email)</th>
          <th>(Địa chỉ)</th>
          <th>(Nội dung)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>{{ $data->iptVisa }}</td>
            <td>{{ $data->iptHoten }}</td>
            <td>{{$data->iptPhone}}</td>
            <td>{{ $data->iptEmail }}</td>
            <td>{{ $data->iptAdress }}</td>
            <td><{{ $data->txtMessage }}</td>
        </tr>
    </tbody>
</table>


