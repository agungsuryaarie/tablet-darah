
function alertDanger(message) {
    $("#alerts").html(
        '<div class="alert alert-danger alert-dismissible fade show ml-2 mr-2 mt-2">' +
            '<button type="button" class="close" data-dismiss="alert">' +
            "&times;</button><strong>Success! </strong>" +
            message +
            "</div>"
    );
    $(window).scrollTop(0);
    setTimeout(function () {
        $(".alert").alert("close");
    }, 5000);
}

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    })
})

function DataTable(ajaxUrl, columns) {
    var table = $(".data-table").DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        pageLength: 10,
        lengthMenu: [10, 50, 100, 200, 500],
        lengthChange: true,
        autoWidth: false,
        ajax: ajaxUrl,
        columns: columns,
    });

    return table;
}

function createModel(createHeading) {
    $("#create").click(function () {
        $("#hidden_id").val("");
        $("#saveBtn").val("create");
        $("#modelHeading").html(createHeading);
        $("#ajaxModel").modal("show"); 
        $("#delete").modal("show"); 
        $("#ajaxForm").trigger("reset");
    });
}

function editModel(editUrl, editHeading, field) {
    $("body").on("click", ".edit", function () {
        var editId = $(this).data("id");
        $.get(editUrl + "/" + editId + "/edit", function(data) {
            $("#saveBtn").val("edit");
            $("#ajaxModel").modal("show");
            $("#hidden_id").val(data.id);
            $("#modelHeading").html(editHeading);
            $.each(field, function(index, value) {
                $("#" + value).val(data[value]);
            });   
        });
    });
}

function saveBtn(urlStore, table) {
    $("#saveBtn").click(function(e) {
        e.preventDefault();
        $(this).html(
            "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
        );

        $.ajax({
            data: $("#ajaxForm").serialize(),
            url: urlStore,
            type: "POST",
            dataType: "json",
            success: function(data) {
                if (data.errors) {
                    $('.alert-danger').html('');
                    $.each(data.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' +
                            value +
                            '</li></strong>');
                        $(".alert-danger").fadeOut(5000);
                        $("#saveBtn").html("Simpan");
                    });
                } else {
                    table.draw();
                    toastr.success(data.success)
                    $("#saveBtn").html("Simpan");
                    $('#ajaxModel').modal('hide');
                }
            },
        });
    });
}

function saveImage(urlStore, table) {
    $("#saveBtn").click(function(e) {
        e.preventDefault();
        $(this).html(
            "<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menyimpan...</i></span>"
        );

        var form = $("#ajaxForm")[0]; // Ambil form element secara langsung
        var data = new FormData(form); // Gunakan FormData untuk mengirim data termasuk file

        $.ajax({
            data: data,
            url: urlStore,
            type: "POST",
            dataType: "json",
            contentType: false, // Set contentType ke false agar FormData dapat bekerja dengan benar
            processData: false, // Set processData ke false agar FormData dapat bekerja dengan benar
            success: function(data) {
                
                if (data.errors) {
                    $('.alert-danger').html('');
                    $.each(data.errors, function(key, value) {
                        $('.alert-danger').show();
                        $('.alert-danger').append('<strong><li>' +
                            value +
                            '</li></strong>');
                        $(".alert-danger").fadeOut(5000);
                        $("#saveBtn").html("Simpan");
                    });
                } else {
                    table.draw();
                    toastr.success(data.success)
                    $("#saveBtn").html("Simpan");
                    $('#ajaxModel').modal('hide');
                }
            },
        });
    });
}


function Delete(fitur, editUrl, deleteUrl, table) {
    $("body").on("click", ".delete", function () {
        var deleteId = $(this).data("id");
        $("#modelHeadingHps").html("Hapus");
        $("#fitur").html(fitur);
        $("#ajaxModelHps").modal("show");
        $.get(editUrl + "/" + deleteId + "/edit", function(data) {
            $("#field").html(data.name);
        });
        $("#hapusBtn").click(function(e) {
            e.preventDefault();
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            
            $(this).html("<span class='spinner-border spinner-border-sm'></span><span class='visually-hidden'><i> menghapus...</i></span>");
            $.ajax({
                type: "DELETE",
                url: deleteUrl + "/" + deleteId,
                data: {
                    _token: csrfToken,
                },
                success: function(data) {
                    if (data.errors) {
                        $('.alert-danger').html('');
                        $.each(data.errors, function(key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<strong><li>' + value + '</li></strong>');
                            $(".alert-danger").fadeOut(5000);
                            $("#hapusBtn").html("<i class='fa fa-trash'></i>Hapus");
                        });
                    } else {
                        if (table) {
                            table.draw();
                        }
                        toastr.success(data.success)
                        $("#hapusBtn").html("<i class='fa fa-trash'></i>Hapus");
                        $('#ajaxModelHps').modal('hide');
                    }
                },
            });
        }); 
    });
}





