$(function () {
    $("#image").on("change", function (ev) {
        const reader = new FileReader();

        reader.onload = function (ev) {
            $("#preview")
                .attr("src", ev.target.result)
                .css("width", "300px")
                .css("height", "300px")
                .css("color", "black");
        };
        reader.readAsDataURL(this.files[0]);
    });
});
//ファイル名を取得
$(function () {
    $("#music_path").on("change", function () {
        var file = $(this).prop("files")[0];
        $(".file-name").text(file.name);
    });
});
