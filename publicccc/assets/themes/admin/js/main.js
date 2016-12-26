var $ic, Loading, fields_count, message, uploadStart;

window.select2Options = {
  minimumResultsForSearch: 10
};

window.initToggles = function() {
  $(".status-toggler:visible").each(function() {
    var $switcher;
    $switcher = $(this);
    return $switcher.bootstrapSwitch({
      size: "small"
    });
  });
  $(".status-toggler").fieldChanger({
    event: "switchChange.bootstrapSwitch",
    callback: function(response) {
      if (response["message"]) {
        return message.show(response["message"], response["type"]);
      }
    }
  });
  return $(".ajax-field-changer").fieldChanger({
    event: "change",
    callback: function(response) {
      if (response["message"]) {
        return message.show(response["message"], response["type"]);
      }
    }
  });
};

window.fixCustomInputs = function($area) {
  initInputMask();
  initDateTimePickers();
  $area.find('span.select2').remove();
  return $area.find("select.select2").each(function() {
    return $(this).select2(select2Options);
  });
};

window.slugGenerate = function($name) {
  var $i, $opts, $result, $str, regExp;
  if ($name.length > 1) {
    $opts = $.extend({}, $.fn.syncTranslit.defaults, {});
    $str = $name;
    $result = "";
    $i = 0;
    while ($i < $str.length) {
      $result += $.fn.syncTranslit.transliterate($str.charAt($i), $opts);
      $i++;
    }
    regExp = new RegExp("[" + $opts.urlSeparator + "]{2,}", "g");
    $result = $result.replace(regExp, $opts.urlSeparator);
    return $result;
  } else {
    message.show(lang_errorEmptyNameField, 'warning');
  }
  return "";
};

$(document).on("click", ".front-home-link", function(e) {
  e.preventDefault();
  return window.open($(this).data('href'), '_blank');
});

$(document).ready(function() {
  initToggles();
  $('select.select2').each(function() {
    return $(this).select2(select2Options);
  });
  $(document).on("select2:select", function(e) {
    var $row, input, _class;
    $row = $(e.target).closest('.field-row');
    if ($row.length) {
      input = $row.find('.input-mask');
      input.inputmask('remove');
      _class = input.attr('class').replace(/inputmask-\d/i, '');
      input.attr('class', _class);
      input.addClass('inputmask-' + e.params.data.id);
      return initInputMask();
    }
  });
  initCheckboxes();
  $(document).on("click", ".close-me", function() {
    return $(this).parent().removeClass('active').fadeOut(100);
  });
  $(document).on("click", ".slug-generate", function(e) {
    var from, target;
    e.preventDefault();
    from = $(this).data('from_id') || ".name_" + lang;
    target = $(this).data('target_id') || '#slug';
    $(target).val(slugGenerate($(from).val()));
    return false;
  });
  $(document).on("click", ".sidebar-menu .create-label", function(e) {
    e.preventDefault();
    return document.location = $(this).data('href');
  });
  $('.with-loading').on("click", function() {
    if (!$(this).find('loading').length) {
      new Loading($(this));
    }
    return setTimeout((function(_this) {
      return function() {
        var $form;
        $form = $(_this).closest('form');
        if ($form.length) {
          return $form.submit();
        }
      };
    })(this), 200);
  });
  $('.translations-table textarea').on("change", function() {
    return $(this).addClass('text-bold');
  });
  return console.log("init");
});

window.dataTablaReload = function($datatable) {
  return $datatable.DataTable().ajax.reload(null, false);
};

$(document).ready(function() {
  return $('table.dataTable').on('draw.dt', function() {
    return initCheckboxes();
  });
});

window.initDateTimePickers = function() {
  return $('.datepicker-birthday').datepicker({
    autoclose: true,
    language: window.lang,
    todayHighlight: true,
    format: birthday_format,
    todayBtn: true
  });
};

$(document).on("ready", function() {
  return initDateTimePickers();
});

(function($) {
  var fieldChanger;
  fieldChanger = function() {};
  fieldChanger.busy = false;
  fieldChanger.options = {};
  fieldChanger.init = function(element, params) {
    var defaults;
    defaults = {
      callback: false,
      event: "change"
    };
    fieldChanger.options = $.extend({}, defaults, fieldChanger.options, params);
    fieldChanger.self = element;
    return fieldChanger.self.on(fieldChanger.options.event, function(e) {
      var field, id, token, url, value;
      e.preventDefault();
      id = $(this).data("id");
      url = $(this).data("url");
      token = $(this).data("token");
      field = $(this).data("field");
      value = $(this).val() || $(this).data('value');
      value = ($(this).is(":checked") ? 1 : value);
      if (value !== void 0) {
        return $.post(url, {
          value: value,
          field: field,
          _token: token
        }, function(response) {
          if (typeof fieldChanger.options.callback === "function") {
            return fieldChanger.options.callback(response);
          }
        });
      }
    });
  };
  return $.fn.fieldChanger = function(params) {
    return $(this).each(function() {
      if (!$(this).data("fieldChanger")) {
        fieldChanger.init($(this), params);
        return $(this).data("fieldChanger", true);
      }
    });
  };
})(jQuery);

fields_count = 1;

window.addUserField = function($button) {
  var $field_row;
  $field_row = $button.find(".duplicate").clone(true);
  $ic++;
  $field_row[0].innerHTML = $field_row[0].innerHTML.replace(/replaceme/g, $ic);
  $field_row.removeClass('duplicate').insertBefore('.add-field-button-block');
  return fixCustomInputs($field_row);
};

$(document).ready(function() {
  fields_count = $('.field-row').length || fields_count;
  $(document).on("click", ".add-field-button", function() {
    return addUserField($(this));
  });
  $(document).on("click", ".remove-field-button", function() {
    var id, name;
    id = $(this).data("id");
    if (id) {
      name = $(this).data("name");
      $(this).closest("form").append("<input type=\"hidden\" name=\"" + name + "\" value=\"" + id + "\" />");
    }
    return $(this).closest(".field-row").fadeOut(function() {
      return $(this).remove();
    });
  });
});

$ic = 1;

uploadStart = function($fileinput) {
  var $block, $form, $tmpFrame, blockId, frameId, iframeError, originAction;
  $form = $fileinput.closest("form");
  originAction = $form.attr('action');
  if ($fileinput.is('[data-url]')) {
    $form.attr('action', $fileinput.data('url'));
  }
  blockId = $fileinput.attr("data-block-id");
  $block = $("#" + blockId);
  frameId = "uploadframe" + new Date().getTime();
  $tmpFrame = $("<iframe name='" + frameId + "' id='" + frameId + "' frameborder='none' width='0' height='0' style='margin:0; padding: 0;position:absolute;'></iframe>");
  $("#page-wrapper").prepend($tmpFrame);
  $block.find(".progress").show();
  $block.find(".progress").find(".progress-bar").css({
    width: "0%"
  }).delay(500).animate({
    width: "100%"
  }, 2500);
  $block.find("img.thumbnail").attr("src", "http://www.placehold.it/100x100/EFEFEF/AAAAAA&text=no+image");
  $form.attr("target", frameId);
  $form.attr("target", frameId).submit();
  $form.attr('action', originAction);
  $form.removeAttr("target");
  iframeError = setInterval("load_error('" + blockId + "')", 10000);
  $tmpFrame.on("load", function(data) {
    $(this).remove();
    clearInterval(iframeError);
  });
  $fileinput.val("");
};

window.uploaded = function(img, thumbnail, target) {
  var $block;
  $block = $("#" + target);
  if (img) {
    $block.find("input[type=\"hidden\"]").val(img);
    $block.find(".product_value_image").val(img);
    $block.find("img.thumbnail").attr("src", thumbnail);
  } else {
    alert("Cannot save photo");
  }
  $block.find(".progress").hide();
};

window.load_error = function(blockId, callback) {
  $("#" + blockId).find(".progress").find(".progress-bar").removeClass('progress-bar-success').addClass('progress-bar-danger');
  callback();
};

$(document).ready(function() {
  $("body").on("click", ".upload_image", function() {
    var $block, blockId;
    $block = $(this).closest(".fileupload-canvas");
    blockId = "fileupload" + new Date().getTime();
    $block.attr("id", blockId);
    $("#gallery_image").attr("name", "gallery_image[" + blockId + "]").attr("data-block-id", blockId).click();
  });
  $("body").on("change", "input.gallery_image_uploader", function() {
    if ($(this).val() !== "") {
      uploadStart($(this));
    }
  });
});

window.getFormData = function($form) {
  var data;
  data = new Object();
  $.each($form.serializeArray(), function(i, field) {
    return data[field.name] = field.value;
  });
  return data;
};

window.clearForm = function($form) {
  return $form.find('input, textarea').each(function() {
    return $(this).val('');
  });
};

window.setErrors = function(response, $form) {
  var n, time_out;
  time_out = 500;
  n = 0;
  return $.each(response.responseJSON, (function(_this) {
    return function(i, item) {
      n++;
      i = i.replace('.', '_');
      $form.find('#' + i).closest('.form-group').addClass("has-error");
      return setTimeout(function() {
        return message.show(item, 'error');
      }, n * time_out);
    };
  })(this));
};

window.processError = function(response, $form) {
  var mess;
  $form = $form || null;
  if (response.status === 422) {
    message.show(lang_errorValidation, 'error');
    if ($form) {
      return setErrors(response, $form);
    }
  } else {
    if (response.message) {
      mess = response.message;
    } else {
      mess = lang_errorFormSubmit;
    }
    return message.show(mess, 'error');
  }
};

$(document).ready(function() {
  $('.tab-pane .has-error').each(function() {
    var $parent;
    $parent = $(this).closest('.tab-pane');
    return $('a[href=\'#' + $parent.attr('id') + '\']').closest('li').addClass('tab-with-errors');
  });
  $(document).on('click', '.tab-with-errors', function() {
    return $(this).removeClass('tab-with-errors');
  });
  return $(document).on('click', '.has-error', function() {
    var $parent;
    $(this).removeClass('has-error').find('.help-block.error').remove();
    $parent = $(this).closest('.tab-pane');
    return $('a[href=\'#' + $parent.attr('id') + '\']').closest('li').removeClass('tab-with-errors');
  });
});

window.initCheckboxes = function() {
  return $('input[type="checkbox"].square, input[type="radio"].square').iCheck({
    checkboxClass: 'icheckbox_square-blue',
    radioClass: 'iradio_square-blue'
  });
};

$(document).ready(function() {
  $(document).on('click', '.show-elfinder-button', function() {
    var button;
    button = $(this);
    return $('<div >').dialog({
      modal: true,
      width: '80%',
      title: button.data('title'),
      open: function(event, ui) {
        $('.ui-dialog').css('z-index', 9999);
        return $('.ui-widget-overlay').css('z-index', 9998);
      },
      create: function(event, ui) {
        $(this).elfinder({
          resizable: false,
          url: elfinderConnectorUrl,
          commandsOptions: {
            getfile: {
              oncomplete: 'destroy'
            }
          },
          getFileCallback: function(file) {
            $(button.data('target')).val('/' + file.path).trigger("change");
            $('button.ui-dialog-titlebar-close').click();
          }
        }).elfinder('instance');
      }
    });
  });
  $(document).find('.image_input_thumbnail').on('error', function() {
    return $(this).attr('src', $(this).data('default'));
  });
  $(document).on('change', 'input[data-related-image]', function() {
    var $image, $this, _src;
    $this = $(this);
    $image = $($this.data('related-image'));
    _src = $(this).val();
    $image.html('');
    $image.attr('src', _src || $image.data('default'));
    return $image.on('error', function() {
      return $image.attr('src', $image.data('default'));
    });
  });
  return $(document).on('click', '.clear-image-button', function() {
    var $image, $input, $this;
    $this = $(this);
    $image = $($this.data('target-image'));
    $input = $($this.data('target-input'));
    console.log($image);
    $image.attr('src', $image.data('default'));
    return $input.val('');
  });
});

window.loadImagePreview = function(img, preview_id) {
  var ext, isIE, path, reader;
  isIE = navigator.appName === "Microsoft Internet Explorer";
  path = img.value;
  ext = path.substring(path.lastIndexOf('.') + 1).toLowerCase();
  if (ext === "jpeg" || ext === "jpg" || ext === "png") {
    if (isIE) {
      $('#' + preview_id + ' img').attr('src', path);
      return $(img).closest('.image-block').find('.remove-image').removeClass('hidden');
    } else {
      if (img.files[0]) {
        if (img.files[0].size < upload_max_filesize) {
          reader = new FileReader();
          reader.onload = function(e) {
            return $('#' + preview_id + ' img').attr('src', e.target.result);
          };
          reader.readAsDataURL(img.files[0]);
          return $(img).closest('.image-block').find('.remove-image').removeClass('hidden');
        } else {
          $(".remove-image").click();
          return message.show(lang_errorSelectedFileIsTooLarge, 'warning');
        }
      }
    }
  } else {
    $(".remove-image").click();
    return message.show(lang_errorIncorrectFileType, 'warning');
  }
};

window.resetImagePreview = function(preview_id, image_input_id) {
  var $fileInput;
  $('#' + preview_id + ' img').attr('src', no_image);
  $fileInput = $('#' + preview_id + ' input[type=file]');
  $fileInput.replaceWith($fileInput.val('').clone(true));
  return $('#' + image_input_id).val("");
};

$(document).on("ready", function() {
  return $(document).on("click", ".remove-image", function() {
    var image_input_id, preview_id;
    preview_id = $(this).data("preview_id");
    image_input_id = $(this).data("image_input_id");
    resetImagePreview(preview_id, image_input_id);
    return $(this).addClass('hidden');
  });
});

window.initInputMask = function() {
  $(".inputmask-birthday").each(function() {
    return $(this).inputmask(birthday_format, {
      'placeholder': birthday_format
    });
  });
  $(".inputmask-2").each(function() {
    return $(this).inputmask({
      mask: "+9999999999999999",
      greedy: false,
      placeholder: ""
    });
  });
  return $(".inputmask-3").each(function() {
    return $(this).inputmask({
      mask: '999 999 999 999',
      placeholder: ' ',
      numericInput: true,
      rightAlign: false
    });
  });
};

$(document).on("ready", function() {
  return initInputMask();
});

window.processListSelect = function(href, data) {
  return $.ajax({
    url: href,
    type: 'POST',
    dataType: 'json',
    data: data,
    error: (function(_this) {
      return function(response) {
        return processError(response, null);
      };
    })(this),
    success: (function(_this) {
      return function(response) {
        return message.show(response.message, response.status);
      };
    })(this)
  });
};

window.getListSelectedData = function($block) {
  var $list, data, items;
  data = {};
  items = [];
  $list = $block.find('.list-select-item:checked');
  if (!$list.length) {
    return null;
  }
  $list.each(function() {
    return items.push($(this).val());
  });
  data.items = items;
  $block.find('.list-select-data-item').each(function() {
    return data[$(this).data('name')] = $(this).val();
  });
  return data;
};

$(document).ready(function() {
  return $('.list-select-button').on("click", function(e) {
    var $block, $option, closure, data, href;
    e.preventDefault();
    $block = $(this).closest('.list-select-block');
    $option = $block.find('.list-select-action option:selected');
    href = $option.data('href') || null;
    closure = $option.data('closure') || null;
    if (!href && !closure) {
      return false;
    }
    data = getListSelectedData($block);
    if (!data) {
      message.show(lang_errorEmptyData, 'warning');
      return false;
    }
    if (!closure) {
      processListSelect(href, data);
    } else {
      window[closure](href, data);
    }
    return false;
  });
});

Loading = (function() {
  function Loading(obj) {
    var $loader, position;
    this.obj = obj;
    $loader = $('<div id="loader" class="loading"><i class="fa fa-cog fa-spin" aria-hidden="true"></i></div>').appendTo(this.obj);
    position = this.obj.css('position');
    if (position !== 'absolute' && position !== 'fixed' && position !== 'relative') {
      this.obj.css('position', 'relative');
    }
  }

  Loading.prototype.hide = function() {
    return this.obj.find('.loading').remove();
  };

  return Loading;

})();

message = {};

message.delay = 5000;

message.closeHandler = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>";

message.containeer = ".message-container";

message.info = function(text) {
  message.show(text, "info");
};

message.success = function(text) {
  message.show(text, "success");
};

message.warning = function(text) {
  message.show(text, "warning");
};

message.error = function(text) {
  message.show(text, "error");
};

message.show = function(text, type) {
  switch (type) {
    case "info":
      type = "alert alert-info alert-dismissable";
      break;
    case "success":
      type = "alert alert-success alert-dismissable";
      break;
    case "warning":
      type = "alert alert-warning alert-dismissable";
      break;
    case "error":
      type = "alert alert-danger alert-dismissable";
      break;
    default:
      type = "alert alert-info alert-dismissable";
  }
  $("<div/>").html(text + message.closeHandler).addClass(type).appendTo(message.containeer).delay(message.delay).fadeOut(500, function() {
    $(this).remove();
  });
};

window.$modal = $('#modal');

window.dModal = function(content, clone) {
  var $__modals, $_modal;
  clone = clone || false;
  $__modals = $('.modal-clone');
  $('.modal-backdrop').each(function() {
    if (!$(this).hasClass('in')) {
      return $(this).remove();
    }
  });
  if ($__modals.length > 0) {
    $__modals.each(function() {
      if (!$(this).hasClass('in')) {
        return $(this).remove();
      }
    });
  }
  if (clone) {
    $_modal = $modal.clone(false);
    $_modal.addClass('modal-clone').modal('show');
    $_modal.html(content);
  } else {
    $modal.modal('show');
    $modal.html(content);
  }
  fixCustomInputs($modal);
  return $('#modal').each(function() {
    return $(this).removeAttr('tabindex');
  });
};

window.dModalHide = function($_modal) {
  $_modal = $_modal || false;
  if ($_modal) {
    $_modal.modal('hide');
    return $_modal.remove();
  } else {
    return $modal.modal('hide');
  }
};

$(document).ready(function() {
  $(document).ajaxStart(function() {
    return Pace.restart();
  });
  return $(document).ajaxStop(function() {
    return Pace.stop();
  });
});

window.ic = 1;

window.duplicate_row = function($this) {
  var $nrow, $parent;
  if (!$this.hasClass('duplication')) {
    $parent = $this.closest('.duplication');
  } else {
    $parent = $this;
  }
  $nrow = $parent.find(".duplicate").clone(true);
  if ($nrow.length === 0) {
    return;
  }
  window.ic++;
  $nrow[0].innerHTML = $nrow[0].innerHTML.replace(/replaseme/g, window.ic);
  $nrow.removeClass('duplicate').insertBefore($parent.find('.duplication-button'));
  $nrow.find('.form-control').each(function() {
    $(this).attr('name', $(this).data('name'));
    if ($(this).data('required')) {
      return $(this).attr('required', $(this).data('required'));
    }
  });
  return fixCustomInputs($nrow);
};

$(document).ready(function() {
  window.ic = $('.duplication-row').length;
  $(".duplication.duplicate-on-start").each(function() {
    return duplicate_row($(this));
  });
  $(document).on("click", ".duplication .create", function() {
    return duplicate_row($(this));
  });
  return $(document).on("click", ".duplication .destroy", function() {
    var $this, id, name;
    $this = $(this);
    if ($this.hasClass('exist')) {
      id = $this.data("id");
      if (id) {
        name = $(this).data("name");
        $(this).closest("form").append("<input type=\"hidden\" name=\"" + name + "\" value=\"" + id + "\" />");
      }
    }
    return $(this).closest(".duplication-row").remove();
  });
});

$(document).ready(function() {
  return $('.slim-scroll').each(function() {
    return $(this).slimScroll({
      height: parseInt($(this).data('height')) + 'px'
    });
  });
});

$(document).ready(function() {
  return $('form').each(function() {
    if (!$(this).hasClass('without-js-validation')) {
      return $(this).validator().on('submit', function(e) {
        if (e.isDefaultPrevented()) {
          return message.show(lang_errorValidation, 'error');
        }
      });
    }
  });
});

$(document).ready(function() {
  return $('.save-variable-value').on("click", function(e) {
    var $form, data, instance, value;
    e.preventDefault();
    $form = $(this).closest('form');
    for (instance in CKEDITOR.instances) {
      value = CKEDITOR.instances[instance].getData();
      value.replace('\r\n', '');
      $('#' + instance).val(value);
    }
    data = getFormData($form);
    $.ajax({
      url: $form.attr('action'),
      type: 'POST',
      dataType: 'json',
      data: data,
      error: (function(_this) {
        return function(response) {
          return processError(response, $form);
        };
      })(this),
      success: (function(_this) {
        return function(response) {
          return message.show(response.message, response.status);
        };
      })(this)
    });
    return false;
  });
});

window.dialog = function(title, message, $form, closure) {
  return bootbox.dialog({
    title: title,
    message: message,
    buttons: {
      main: {
        label: lang_cancel,
        className: "btn-default btn-flat btn-sm"
      },
      success: {
        label: lang_yes,
        className: "btn-success btn-flat btn-sm",
        callback: function() {
          if (typeof closure === 'function') {
            return closure($form);
          } else if (closure === "link") {
            return window.location.href = $form;
          } else {
            return $form.submit();
          }
        }
      }
    }
  });
};

$(document).ready(function() {
  return $(document).on("click", '.simple-link-dialog', function(e) {
    e.preventDefault();
    dialog($(this).data('title'), $(this).data('message'), null, (function(_this) {
      return function() {
        return window.location.href = $(_this).attr('href');
      };
    })(this));
    return false;
  });
});
