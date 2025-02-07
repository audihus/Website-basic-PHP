//$ adalah tanda untuk memanggil jquery
$(document).ready(function () {
  $("#tombol-cari").hide();

  //event ketika keyword ditulis
  $("#keyword").on("keyup", function () {
    // $("#container-table").load(
    //   "ajax/mahasiswa.php?keyword=" + $("#keyword").val()
    // );

    //menampilkan icon load
    $(".loader").show();

    //$.get()
    $.get("ajax/mahasiswa.php?keyword=" + $("#keyword").val(), function (data) {
      $("#container-table").html(data);
      $(".loader").hide();
    });
  });
  //load hanya bisa menggunakan get
});
