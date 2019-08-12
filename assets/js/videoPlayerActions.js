function likeVideo(button, videoId) {
    $.post("ajax/likeVideo.php", {videoId: videoId})
    .done(function(data) {

        var likeButton = $(button);
        var dislikeButton = $(button).siblings(".dislikeButton");

        likeButton.addClass("active");
        dislikeButton.removeClass("active");

        var result = JSON.parse(data);  //take a json string, and pass it to a json object
        updateLikesValue(likeButton.find(".text"), result.likes);
        updateDislikesValue(dislikeButton.find(".text"), result.dislikes);
    });  
}

function updateLikesValue(element, num) {
    var likesCountVal = element.text() || 0; //if it doesn't find text, default is zero
    element.text(parseInt(likesCountVal) + parseInt(num));
}