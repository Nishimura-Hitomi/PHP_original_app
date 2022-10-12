$(function () {
  $('#admin').submit(function() {
    if (!$("input[type=radio]:checked").val()) {
      alert('ユーザーを選択してください！');
      return false;
    }
  });
});