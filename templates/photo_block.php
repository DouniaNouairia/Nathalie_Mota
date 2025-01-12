<div class="photo-item">
    <div class="photo-thumbnail">
        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('full'); // Assurez-vous d'utiliser la taille appropriée
        }
        ?>
    </div>
</div>
