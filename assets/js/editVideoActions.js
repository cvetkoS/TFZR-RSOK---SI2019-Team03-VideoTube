function setNewThumbnail(thumbnailId, videoId, itemElement) {
    $.post("ajax/updateThumbnail.php", { videoId: videoId, thumbnailId: thumbnailId })
    .done(function() {

    });
}