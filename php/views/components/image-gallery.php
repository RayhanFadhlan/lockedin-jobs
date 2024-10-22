<link rel="stylesheet" href="/public/styles/image-gallery.css">
<div class="image-gallery">
<?php if (isset($data['images'][0])): ?>
    <img src="<?= htmlspecialchars($data['images'][0]) ?>" alt="Lowongan Image" class="main-image">
<?php endif; ?>
    <div class="thumbnails">
        <?php foreach (($data['images']) as $thumbnail): ?>
            <div class="thumbnail" tabindex="0">
                <img src="<?= htmlspecialchars($thumbnail) ?>" alt="Thumbnail">
            </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="/public/scripts/image-gallery.js"></script>