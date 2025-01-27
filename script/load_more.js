jQuery(document).ready(function ($) {
  let loading = false;
  const $loadMoreButton = $("#load-more-btn");
  const $container = $(".photo-gallery");
  let page = parseInt($('input[name="page"]').val(), 10) || 1;

  function resetLightboxAndHover() {
    $(".lightbox")
      .off("click")
      .on("click", function (e) {
        e.preventDefault();

        const filteredLightboxElements = $(".lightbox");
        const index = filteredLightboxElements.index(this);
        openLightbox(index, filteredLightboxElements);
      });

    $(".photo-gallery")
      .on("mouseenter", ".photo-thumbnail", function () {
        $(this).find(".photo-hover-overlay").fadeIn(200);
      })
      .on("mouseleave", ".photo-thumbnail", function () {
        $(this).find(".photo-hover-overlay").fadeOut(200);
      });
  }

  $loadMoreButton.on("click", function () {
    if (!loading) {
      loading = true;
      $loadMoreButton.text("Chargement en cours...");

      page++;

      $.ajax({
        url: filtres_ajax_params.ajax_url,
        type: "GET",
        data: {
          action: "load_more_posts",
          page: page,
          category: $("#category-filter .selected-option").data("value"),
          format: $("#format-filter .selected-option").data("value"),
          dateSort: $("#date-filter .selected-option").data("value"),
        },
        success: function (response) {
          if (response && response.posts) {
            $.each(response.posts, function (index, post) {
              if ($(`[data-image="${post.image}"]`).length === 0) {
                $container.append(`
                  <div class="photo-item">
                      <div class="photo-thumbnail">
                          <img src="${post.image}" alt="${post.title}" />
                          <div class="photo-hover-overlay">
                              <a href="${post.link}" class="photo-icon-center">
                                  <img src="${
                                    wp_data.template_url
                                  }/assets/images/Icon_eye.png" alt="icône oeil">
                              </a>
                              <a href="javascript:void(0);" class="lightbox photo-icon-top-right"
                                               data-image="${post.image}"
                                               data-reference="${
                                                 post.reference ||
                                                 "Référence non définie"
                                               }"
                                               data-category="${
                                                 post.category ||
                                                 "Sans catégorie"
                                               }">
                                                <img src="${
                                                  wp_data.template_url
                                                }/assets/images/Fullscreen.png" alt="plein écran">
                                            </a>
                              <div class="photo-info-hover">
                                  <span class="photo-title">${
                                    post.title || "Titre non défini"
                                  }</span>
                                  <span class="photo-category">${
                                    post.category || "Sans catégorie"
                                  }</span>
                              </div>
                          </div>
                      </div>
                  </div>
                `);
              }
            });

            if (response.posts.length < 8) {
              $loadMoreButton
                .text("Fin des publications")
                .prop("disabled", true);
            } else {
              $loadMoreButton.text("Charger plus");
            }

            resetLightboxAndHover();
          } else {
            $loadMoreButton.text("Fin des publications").prop("disabled", true);
          }
          loading = false;
        },
        error: function () {
          $loadMoreButton
            .text("Erreur, essayez de nouveau")
            .prop("disabled", false);
          loading = false;
        },
      });
    }
  });

  resetLightboxAndHover();
});
