$(".list-group-item").click(function() {
  $("#vehicle").load($(this).attr("href"));

  return false;
});
