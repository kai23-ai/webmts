{{-- Script tambahan untuk memastikan status pengisian nilai muncul saat halaman pertama kali dibuka --}}
<script>
  // Script ini harus ditambahkan di bagian bawah halaman, sebelum tag penutup </body>
  $(document).ready(function() {
    // Tunggu sebentar untuk memastikan Select2 sudah diinisialisasi
    setTimeout(function() {
      // Pastikan dropdown mata pelajaran tidak disabled
      $('#mata_pelajaran').prop('disabled', false);
      
      // Perbarui tampilan dropdown
      if ($('#mata_pelajaran').data('select2')) {
        $('#mata_pelajaran').trigger('change.select2');
      }
    }, 500);
  });
</script>