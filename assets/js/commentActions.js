function postComment(button, postedBy, videoId, replayTo, containerClass) {
    var textarea = $(button).siblings("textarea");
    var commentText = textarea.val();
    textarea.val("");

    if (commentText) {

        $.post("ajax/postComment.php", {
                commentText: commentText,
                postedBy: postedBy,
                videoId: videoId,
                responseTo: replayTo
            })
            .done(function (data) {
                alert(data);
            });

    } else {
        alert("You can't post an empty comment");
    }
}