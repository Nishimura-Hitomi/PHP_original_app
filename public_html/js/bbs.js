$(function(){
  $('#open').on('click',function(){
    $('body').addClass('active');
  });

  $('#close,#mask').on('click',function(){
    $('body').removeClass('active');
  });
});