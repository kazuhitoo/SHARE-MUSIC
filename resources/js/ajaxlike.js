$(function () {
    var like = $(".like-toggle");
    var likeMusicid;

    like.on("click", function () {
        var $this = $(this);
        likeMusicid = $this.data("music-id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
            url: '/like',
            method: 'POST',
            data: {
                music_id: likeMusicid,
            },
        })
            .done(function (data) {
                $this.toggleClass('liked');
                $this.next('.like-counter').html(data.music_likes_count);
            })
            .fail(function () {
                console.log("fail");
            });
    });
});
