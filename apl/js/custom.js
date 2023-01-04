$( document ).ready(function() { // Handler for .ready() called.
  // sebagai action ketika row diklik
  $('.header1').click(function(){
       $(this).toggleClass('expand').nextUntil('tr.header1').slideToggle(100);
  });

  $('.header1').click();


  $('.detail').click(function(){
       $(this).toggleClass('buka').nextUntil('detail').slideToggle(100);
  });

  $('.detail').click();




// romove alert
window.setTimeout(function () {
	$("#alert").fadeTo(500,0).slideUp(500,function () {
		$(this).remove();
	});
}, 1500);

 $('#pilih').select2();




});

//  // Modal Balas Pesan
// function modalBalasPesan(){
// $(document).on('click','#select', function() {
// $('#modalReply').modal('show', {backdrop: 'static'});
// var id      = $(this).data('id');
// var judul = $(this).data('judul');
// var topik = $(this).data('topik');
// var subyek = $(this).data('subyek');
// var pengirim = $(this).data('pengirim');
// var penerima = $(this).data('penerima');
// var pembing = $(this).data('pembing');
// var jenis_pemb = $(this).data('jenis_pemb');

// $('#id').val(id);
// $('#judul').val(judul);
// $('#topik').val(topik);
// $('#subyek').val(subyek);
// $('#pengirim').val(pengirim);
// $('#penerima').val(penerima);
// $('#pembing').val(pembing);
// $('#jenis_pemb').val(jenis_pemb);
// })
// }
