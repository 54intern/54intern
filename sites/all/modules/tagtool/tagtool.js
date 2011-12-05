if (Drupal.jsEnabled) {
  $(document).ready(function () {
    var tagtool = Drupal.settings.tagtool;
    $(".tag-item").click(function(){
      var tag = $(this).text() + ", ";
      var id = "#edit-taxonomy-" + $(this).parent().attr("id");
      if($(id).val() == $(id).parents(".form-item").find("label").text()){
        $(id).val("");
      }
      $(id).val( $(id).val() + tag );
    });
    $(".form-autocomplete")
      .keydown(function(){ $(this.popup).hide(); })
      .blur(function () { $(this.popup).fadeOut('fast'); })
     
    $(".form-autocomplete").click(function(){
      var auto_input = this;
      if (this.popup) {
        $(this.popup).remove();
      }
      var id = $(this).attr("id").substr(19);
      this.popup = document.createElement('div');
      $(this.popup).addClass('tagtool');
      $(this.popup).css({
        width: (this.offsetWidth - 4) +'px',
        display: 'none',
        border: '1px solid #AAA',
        position: 'absolute',
        background: '#FFF'
      });
      $(this).after(this.popup);
      $(this.popup).empty();
      for (key in tagtool[id]) {
        var div = document.createElement('span');
        var tag = tagtool[id][key];
        $(div).html(tagtool[id][key])
          .addClass('tag-item')
          .mouseover(function () { $(this).addClass('hover');})
          .mouseout(function () { $(this).removeClass('hover'); });
        $(this.popup).append(div);
      }
      $(this.popup).fadeIn('fast');
      $('.tag-item').click(function () {
        var now_value = $(auto_input).val();
        $(auto_input).val(now_value + $(this).html() + ', ');
      });
    });
  });
}

