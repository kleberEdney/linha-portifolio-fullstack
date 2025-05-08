var removeImg, resetAddBtn;
jQuery(document).ready(function ($) {
  const limit = 12;

  removeImg = function (event) {
    event.preventDefault();
    event.target.closest(".img-prev-content").remove();
    resetAddBtn(true);
  };

  resetAddBtn = function ($active) {
    $("#btn-galeia").prop("disabled", !$active);
  };

  calculeLimit();

  let mediaUploader;
  $("#btn-galeia").on("click", function (e) {
    e.preventDefault();
    setupUploadMedia(true, "my-galery");
    calculeLimit();
  });

  function calculeLimit($return) {
    var qt = $(".img-prev-content").length;
    if (qt >= limit) {
      resetAddBtn(false);
    }

    if ($return) {
      return qt;
    }
  }

  function setupUploadMedia(multiple, input) {
    mediaUploader = wp.media.frames.file_frame = wp.media({
      title: "Upload Image(s)",
      button: {
        text: "UPLOAD",
      },
      multiple: multiple,
    });

    mediaUploader.on("select", function () {
      $("#txt-sem-img").remove();
      var attachment = mediaUploader.state().get("selection").toJSON();
      var img_show = $("#my-galery");

      var qt = calculeLimit(true);
      var qtRestant = limit - qt;

      for (let i = 0; i < qtRestant; i++) {
        var url = "url('" + attachment[i].url + "')";
        var div = $('<div class="img-prev-content"></div>');
        var img = $('<img class="img-prev" src="' + attachment[i].url + '"/>');
        var btnLixo = $(
          '<img src="' +
            apagarBtn +
            '" class="btn trash" onclick="this.closest(\'.img-prev-content\').remove(); return false" /> '
        );
        var btnSortle = $(
          '<img src="' + apagarMove + '" class="btn sortle" /> '
        );
        var input = $(
          '<input type="hidden" value="' +
            attachment[i].id +
            '"  name="la_port_fulls_galeria_imgs[]" />'
        );
        $(div).append(img);
        $(div).append(btnLixo);
        $(div).append(btnSortle);
        $(div).append(input);
        $(img_show).append(div);

        calculeLimit();
      }
    });

    mediaUploader.open();
  }

  $("#my-galery").sortable();
});
