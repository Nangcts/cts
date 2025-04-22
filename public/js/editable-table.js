var EditableTable = function () {

    return {

        //main function to initiate the module
        init: function () {
            function restoreRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);

                for (var i = 0, iLen = jqTds.length; i < iLen; i++) {
                    oTable.fnUpdate(aData[i], nRow, i, false);
                }

                oTable.fnDraw();
            }

            function editRow(oTable, nRow) {
                var aData = oTable.fnGetData(nRow);
                var jqTds = $('>td', nRow);
                jqTds[0].innerHTML = '<input type="text" class="form-control small" disabled value="' + aData[0] + '">';
                jqTds[1].innerHTML = '<input type="text" class="form-control small" value="' + aData[1] + '">';
                jqTds[2].innerHTML = '<input type="text" class="form-control small" value="' + aData[2] + '">';
                jqTds[3].innerHTML = '<input type="text" class="form-control small" value="' + aData[3] + '">';
                jqTds[4].innerHTML = '<a class="edit" href="">Save</a>';
                jqTds[5].innerHTML = '<a class="cancel" href="">Cancel</a>';
            }

            function saveRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit btn btn-primary btn-xs" href=""><i class="icon-pencil "></i> Sửa</a>', nRow, 4, false);
                oTable.fnUpdate('<a class="delete btn btn-danger btn-xs" href=""><i class="icon-trash "> Xóa</a>', nRow, 5, false);
                oTable.fnDraw();
            }

            function cancelEditRow(oTable, nRow) {
                var jqInputs = $('input', nRow);
                oTable.fnUpdate(jqInputs[0].value, nRow, 0, false);
                oTable.fnUpdate(jqInputs[1].value, nRow, 1, false);
                oTable.fnUpdate(jqInputs[2].value, nRow, 2, false);
                oTable.fnUpdate(jqInputs[3].value, nRow, 3, false);
                oTable.fnUpdate('<a class="edit btn btn-primary btn-xs" href=""><i class="icon-pencil "></i> Sửa</a>', nRow, 4, false);
                oTable.fnDraw();
            }

            var oTable = $('#editable-sample').dataTable({
                "aLengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "iDisplayLength": 10,
                "sDom": "<'row'<'col-lg-6'l><'col-lg-6'f>r>t<'row'<'col-lg-6'i><'col-lg-6'p>>",
                "sPaginationType": "bootstrap",
                "oLanguage": {
                    "sLengthMenu": "_MENU_ records per page",
                    "oPaginate": {
                        "sPrevious": "Prev",
                        "sNext": "Next"
                    }
                },
                "aoColumnDefs": [{
                        'bSortable': false,
                        'aTargets': [0]
                    }
                ]
            });

            jQuery('#editable-sample_wrapper .dataTables_filter input').addClass("form-control medium"); // modify table search input
            jQuery('#editable-sample_wrapper .dataTables_length select').addClass("form-control xsmall"); // modify table per page dropdown

            var nEditing = null;

            $('#editable-sample_new').click(function (e) {
                e.preventDefault();
                var aiNew = oTable.fnAddData(['', '', '', '',
                        '<a class="edit btn btn-primary btn-xs" href=""><i class="icon-pencil"></i> Edit</a>', '<a class="cancel btn btn-danger btn-xs" data-mode="new" href=""><i class="icon-trash "> Xóa</a>'
                ]);
                var nRow = oTable.fnGetNodes(aiNew[0]);
                editRow(oTable, nRow);
                nEditing = nRow;
            });

            $('#editable-sample a.delete').live('click', function (e) {
                e.preventDefault();

                if (confirm("Bạn chắc chắn sẽ xóa menu này ?") == false) {
                    return;
                }
                var table = $('#editable-sample').DataTable();
                var nRow = $(this).parents('tr')[0];
                var rowData = table.fnGetData(nRow);
                var delete_id = rowData[0];
                var _token = $("form[name='edit_menu'] input[name= '_token']").val();
               $.ajax({
                    url: 'http://baohiem.dev/deletemenu',
                    type: 'POST',
                    cache: false,
                    data: {"delete_id": delete_id,"_token": _token},
                    success: function (data) {
                        if (data == "xoa ok") {
                            alert("Xóa menu thành công!");
                            $('#editable-sample_new').removeAttr('disabled');
                        } else {
                            alert("Xảy ra lỗi, vui lòng liên hệ Admin")
                            $('#editable-sample_new').removeAttr('disabled');
                        }
                    }
                });    
                oTable.fnDeleteRow(nRow);
            });

            $('#editable-sample a.cancel').live('click', function (e) {
                e.preventDefault();
                if ($(this).attr("data-mode") == "new") {
                    var nRow = $(this).parents('tr')[0];
                    oTable.fnDeleteRow(nRow);
                    $('#editable-sample_new').removeAttr('disabled');
                } else {
                    restoreRow(oTable, nEditing);
                    nEditing = null;
                }
            });
            $('#editable-sample_new').click(function() {
                $(this).attr('disabled','');
            });     
            $('#editable-sample a.edit').live('click', function (e) {
                e.preventDefault();
                /* Get the row as a parent of the link that was clicked on */
                var nRow = $(this).parents('tr')[0];
                if (nEditing !== null && nEditing != nRow) {
                    /* Currently editing - but not this row - restore the old before continuing to edit mode */
                    restoreRow(oTable, nEditing);
                    editRow(oTable, nRow);
                    nEditing = nRow;
                } else if (nEditing == nRow && this.innerHTML == "Save") {
                    /* Editing this row and want to save it */
                    var table = $('#editable-sample').DataTable();
                    var nRow = $(this).parents('tr')[0];                   
                    var _token = $("form[name='edit_menu'] input[name= '_token']").val();
                    saveRow(oTable, nEditing);
                    var rowData = table.fnGetData(nRow);
                    var menu_id = rowData[0];
                    var parent_menu_id = $("input[name = 'parent_menu_id']").val();
                    if (rowData[1] == '' || rowData[2] == '') {
                        alert('bạn phải nhập đủ thông tin vào các ô trống');
                        oTable.fnDeleteRow(nRow);
                        location.reload();
                        die();
                    }
                   $.ajax({
                        url: 'http://baohiem.dev/savemenu',
                        type: 'POST',
                        cache: false,
                        data: {"rowData": rowData,"menu_id": menu_id,"_token": _token,"parent_menu_id": parent_menu_id},
                        success: function (data) {
                            if (data == "ok") {
                                alert("Cập nhật thành công!");
                            } else if (data == "edit ok"){
                                $('#editable-sample_new').removeAttr('disabled');
                                alert("Thêm mới thành công!");
                            } else {
                                $('#editable-sample_new').removeAttr('disabled');
                                alert("Xảy ra lỗi, vui lòng liên hệ Admin")
                            }
                        }
                    });                       
                    nEditing = null;
                    
                } else {
                    /* No edit in progress - let's start one */
                    editRow(oTable, nRow);
                    nEditing = nRow;
                }
                
            });
        }

    };

}();