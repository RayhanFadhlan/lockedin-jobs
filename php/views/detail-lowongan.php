<div class="main-container">
    <div class="main-box">
        <div class="company-info">
            <img src="/public/images/company-placeholder.svg" alt="Company Logo" class="company-logo">
            <span class="company-name"><?= htmlspecialchars($data['nama_company']) ?></span>
        </div>
        <h1 class="job-title"><?= htmlspecialchars($data['posisi']) ?></h1>
        <p class="company-location">
            <span>
                <?= htmlspecialchars($lokasi) ?>
            </span>
            ·
            <span>
                Posted at : <?= htmlspecialchars($data['created_at']) ?>
            </span>
        </p>
        <div class="job-metadata">
            <span class="metadata-pill"><?= htmlspecialchars($jenis_pekerjaan) ?></span>
            <span class="metadata-pill"><?= htmlspecialchars($jenis_lokasi) ?></span>
        </div>
        <?php if ($data['is_lamaran']): ?>
            <button class="primary-btn disabled">Applied</button>
        <?php else: ?>
            <?php if ($data['is_login'] && $data['is_open']): ?>
                <a href="/lamaran/<?= $data['lowongan_id'] ?>" class="primary-btn">Apply</a>
                <?php elseif (!$data['is_login']): ?>
                    <a href="/login" class="primary-btn">Login</a>
                <?php else: ?>
                    <button class="primary-btn disabled">Closed</button>
                <?php endif; ?>
           
        <?php endif; ?>

    </div>
    <?php if($data['is_lamaran']) : ?>               
    <div class="main-box">
        <div class="application-title">
            <h2>Your Application : </h2>
            <div class="download-links">
                <a href="<?= '/' . $data['cv_path']?>" class="download-btn" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#0073b1" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-file-user">
                        <path d="M14 2v4a2 2 0 0 0 2 2h4" />
                        <path d="M15 18a3 3 0 1 0-6 0" />
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7z" />
                        <circle cx="12" cy="13" r="2" />
                    </svg>
                </a>
                <a href="<?= '/' . $data['video_path']?>" class="download-btn" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="#0073b1" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-video">
                        <path d="m16 13 5.223 3.482a.5.5 0 0 0 .777-.416V7.87a.5.5 0 0 0-.752-.432L16 10.5" />
                        <rect x="2" y="6" width="14" height="12" rx="2" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="feedback-reason-<?= ($data['status']) ?>">
            <h3>Application Feedback</h3>
            <p class="status"><strong>Status:&nbsp; </strong> <?= ($data['status']) ?></p>
            <?= ($data['status_reason']) ?>
        </div>
    </div>
    <?php endif; ?>

    <div class="main-box job-company-box">
        <div class="company-about">
            <h2>About <?= htmlspecialchars($nama_company) ?></h2>
            <p class="job-details"><?= htmlspecialchars($about) ?></p>
           
        </div>
        <div class="job-description">
            <h2>Job Description</h2>
            <?= ($deskripsi) ?>
        </div>
    </div>
    <div class="main-box">

        <?php include __DIR__ . '/components/image-gallery.php'; ?>
    </div>
</div>