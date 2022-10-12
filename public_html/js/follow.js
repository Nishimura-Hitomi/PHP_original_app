$(function(){
  $('.follow_btn').on('click', function () {
    var origin = location.origin;
    var $myid = $('.prof-show').data('me');
    var $follow_id = $('.follow_id').data('followid');
    $.ajax({
      type: 'post',
      url: origin + '/Poa/public_html/ajax_follow.php',
      data: {
        'follow_id': $follow_id,
        'user_id': $myid,
      }
    }).done(function(data){
      location.reload();
    }).fail(function(){
      location.reload();
    });
  });
});