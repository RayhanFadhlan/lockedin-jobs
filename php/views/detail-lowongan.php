<div>
    <div class="job-card">
        <div class="company-info">
            <img src="../public/images/company-logo-placeholder.svg" alt="<?php echo $nama_company?> logo" class="company-logo">
            <span class="company-name"><?php echo $nama_company?></span>
        </div>
        <h1 class="job-title"><?php echo $posisi?></h1>
        <p class="company-location"><?php echo $lokasi?></p>
        <div class="job-type">
            <img src="../public/images/job-icon.svg" alt="job-icon" class="icon">
            <span><?php echo $jenis_pekerjaan.' · '.$jenis_lokasi?></span>
        </div>
        <p class="job-details"><?php echo $deskripsi?></p>

        <?php if ($lamaran_id != null): ?>
            <div class="status">
                <img src="../public/images/<?php echo $status?>.svg" alt="status-icon" class="icon">
                <p><b><?php echo strtoupper($status) ?></b></p>
            </div>
            <?php if ($status_reason != null) : ?>
                <p class="alasan"><?php echo $status_reason ?></p>
            <?php endif; ?>
            <div class="actions">
                <a title="Lihat CV terlampir" href="<?php echo '../'.$cv_path ?>" class="btn btn-primary">Lihat CV</a>
                <?php if ($video_path != null) : ?>
                    <a title="Lihat video perkenalan terlampir" href="../<?php echo $video_path ?>" class="btn btn-secondary">Lihat Video</a>
                <?php endif; ?>
            </div>
            <p class="job-details">Submitted At: <?php echo $created_at?></p>
        <?php elseif (!$is_open) : ?>
            <div class="actions">
                <p class="btn btn-disable">Lowongan Ditutup</p>
            </div>
        <?php else: ?>
            <div <?php if (!$is_login) {echo 'title = "Login terlebih dahulu untuk apply"';}?> class="actions">
                <a href="/lamaran/<?php echo $lowongan_id?>" class="btn btn-primary <?php if (!$is_login) {echo 'disabled';}?>">Easy Apply</a>
            </div>
        <?php endif; ?>
    </div>
    <?php if ($attachments != null) : ?>
        <div class="image-card collapsed" id="imageCard">
            <h2>Image Lowongan</h2>
            <?php foreach ($attachments as $attachment): ?>
                <a href="../<?php echo $attachment['file_path'] ?>">
                    <img src="../<?php echo $attachment['file_path'] ?>" alt="Gambar <?php echo $attachment['attachment_id'] ?>">
                </a>
            <?php endforeach; ?>            
            
            <div class="overlay visible" id="overlay"></div>
            <div class="show-more visible" id="showMoreBtn">Lihat lebih banyak</div>
            <div class="show-less hidden" id="showLessBtn">Lihat lebih sedikit</div>
        </div>
    <?php endif; ?>
    <div class="job-card">
        <h2>About <?php echo $nama_company ?></h2>
        <p class="job-details"><?php echo $about ?></p>
    </div>
</div>

<?php if ($attachments != null) : ?>
    <script>
        const card = document.getElementById('imageCard');
        const showMoreBtn = document.getElementById('showMoreBtn');
        const showLessBtn = document.getElementById('showLessBtn');
        const overlay = document.getElementById('overlay');

        if (card.scrollHeight <= card.clientHeight) {
            showMoreBtn.classList.remove('visible');
            showMoreBtn.classList.add('hidden');
            showLessBtn.classList.remove('visible');
            showLessBtn.classList.add('hidden');
            overlay.classList.remove('visible');
            overlay.classList.add('hidden');
        }

        showMoreBtn.addEventListener('click', function () {
            card.classList.remove('collapsed');
            card.classList.add('expanded');
            showMoreBtn.classList.remove('visible');
            showMoreBtn.classList.add('hidden');
            showLessBtn.classList.remove('hidden');
            showLessBtn.classList.add('visible');
            overlay.classList.remove('visible');
            overlay.classList.add('hidden');
        });

        showLessBtn.addEventListener('click', function () {
            card.classList.remove('expanded');
            card.classList.add('collapsed');
            showMoreBtn.classList.remove('hidden');
            showMoreBtn.classList.add('visible');
            showLessBtn.classList.remove('visible');
            showLessBtn.classList.add('hidden');
            overlay.classList.remove('hidden');
            overlay.classList.add('visible');
        });
    </script>
<?php endif; ?>