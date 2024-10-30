jQuery(document).ready(function ($) {
  $(".cf7oss-plugin-add-action").click(function (e) {
    e.preventDefault();
    var index = $(".cf7oss-plugin-action").length;
    var $newAction = $(".cf7oss-plugin-action-new")
      .clone()
      .removeClass("cf7oss-plugin-action-new")
      .addClass("cf7oss-plugin-action");
    $newAction
      .find('[name^="cf7oss_plugin_options[actions][new]"]')
      .each(function () {
        var newName = $(this).attr("name").replace("new", index);
        $(this).attr("name", newName).val("");
      });
    $(".cf7oss-plugin-actions").append($newAction);
  });

  $(document).on("click", ".cf7oss-plugin-remove-action", function (e) {
    e.preventDefault();
    $(this).closest(".cf7oss-plugin-action").remove();
  });
});