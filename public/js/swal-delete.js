$('.show_confirm').click(function (event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: 'Apakah Anda Yakin?',
        text: 'Data akan dihapus permanen jika Anda melanjutkan proses',
        icon: 'warning',
        buttons: ["Batal", "Hapus"],
        dangerMode: true,
        timer: false,
    })
        .then((willDelete) => {
            if (willDelete) {
                form.submit();
                swal("Data Berhasil Dihapus", {
                    icon: "success",
                });
            }
            else {
                swal("Anda Membatalkan Proses", {
                    icon: "error",
                });
            }
        });
});


// $('.delete').click(function (e) {
//     e.preventDefault();

//     var deleteID = $(this).closest("tr").find(".delete_id").val();
//     var name = $(this).closest("tr").find(".name").val();

//     swal({
//         title: "Apakah Anda Yakin?",
//         text: "Data akan dihapus permanen jika Anda melanjutkan proses",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     })
//         .then((willDelete) => {
//             if (willDelete) {
//                 swal("Data Berhasil Dihapus", {
//                     icon: "success",
//                 });
//             } else {
//                 swal("Anda Membatalkan Proses", {
//                     icon: "warning",
//                 });
//             }
//         });
// });

// function confirmation(ev) {
//     ev.preventDefault();
//     var urlToRedirect = ev.currentTarget.getAttribute('href');
//     console.log(urlToRedirect);
//     swal({
//         title: "Apakah Anda Yakin?",
//         text: "Data akan dihapus permanen jika Anda melanjutkan proses",
//         icon: "warning",
//         buttons: true,
//         dangerMode: true,
//     })
//         .then((willDelete) => {
//             if (willDelete) {
//                 swal("Data Berhasil Dihapus", {
//                     icon: "success",
//                 });
//             } else {
//                 swal("Anda Membatalkan Proses", {
//                     icon: "warning",
//                 });
//             }
//         });
// }

// function deleteConfirmation(id) {
//     swal({
//         title: "Apakah Anda Yakin?",
//         text: "Data akan dihapus permanen jika Anda melanjutkan proses",
//         type: "warning",
//         showCancelButton: !0,
//         confirmButtonText: "Hapus",
//         cancelButtonText: "Batal",
//         reverseButtons: !0
//     }).then(function (e) {

//         if (e.value === true) {
//             var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

//             $.ajax({
//                 type: 'POST',
//                 url: "{{url('/car')}}/" + id,
//                 data: { _token: CSRF_TOKEN },
//                 dataType: 'JSON',
//                 success: function (results) {

//                     if (results.success === true) {
//                         swal("Data Terhapus!", results.message, "success");
//                     } else {
//                         swal("Error!", results.message, "error");
//                     }
//                 }
//             });

//         } else {
//             e.dismiss;
//         }

//     }, function (dismiss) {
//         return false;
//     })
// }

// $('.delete-confirm').on('click', function (e) {
//     e.preventDefault();
//     const url = $(this).attr('href');
//     swal({
//         title: 'Apakah Anda Yakin?',
//         text: 'Data akan dihapus permanen jika Anda melanjutkan proses',
//         icon: 'warning',
//         buttons: ["Cancel", "Yes!"],
//     }).then(function (value) {
//         if (value) {
//             window.location.href = url;
//         }
//     });
// });