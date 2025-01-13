jQuery(document).ready(function ($) {
    // Ouvrir la lightbox
    $(".lightbox").on("click", function () {
        const imageUrl = $(this).data("image");
        const reference = $(this).data("reference");
        const category = $(this).data("category");

        if (imageUrl) {
            $("#lightbox-image").attr("src", imageUrl);
            $("#photo-reference").text(reference || "Référence non définie");
            $("#photo-category").text(category || "Catégorie non définie");
            $("#lightbox").fadeIn(); // Afficher la lightbox
        }
    });

    // Fermer la lightbox
    $("#close-lightbox").on("click", function () {
        $("#lightbox").fadeOut(); // Masquer la lightbox
    });

    // Navigation dans la lightbox
    $(".lightbox-prev, .lightbox-next").on("click", function () {
        const isNext = $(this).hasClass("lightbox-next");
        const currentPhoto = $(".photo-thumbnail img[src='" + $("#lightbox-image").attr("src") + "']").closest(".photo-item");
        const newPhoto = isNext ? currentPhoto.next(".photo-item") : currentPhoto.prev(".photo-item");

        if (newPhoto.length > 0) {
            const newImage = newPhoto.find(".lightbox").data("image");
            const newReference = newPhoto.find(".lightbox").data("reference");
            const newCategory = newPhoto.find(".lightbox").data("category");

            if (newImage) {
                $("#lightbox-image").attr("src", newImage);
                $("#photo-reference").text(newReference || "Référence non définie");
                $("#photo-category").text(newCategory || "Catégorie non définie");
            }
        }
    });
});
