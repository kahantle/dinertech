$('#password').change(function(){
  var password = $('#password').val().length;

  if (password >= 6) {
    $('.confirm_password').show();
  }
  if (password <= 0) {
    $('.confirm_password').hide();
  }
});