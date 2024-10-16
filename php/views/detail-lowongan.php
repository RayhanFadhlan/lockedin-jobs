<div class="job-detail-container">
    <h1><?= htmlspecialchars($lowongan['posisi']) ?></h1>
    <p><strong>Company: </strong><?= htmlspecialchars($lowongan['company_name']) ?></p>
    <p><strong>Location: </strong><?= htmlspecialchars($lowongan['jenis_lokasi']) ?></p>
    <p><strong>Job Type: </strong><?= htmlspecialchars($lowongan['jenis_pekerjaan']) ?></p>
    <p><strong>Posted on: </strong><?= htmlspecialchars($lowongan['created_at']) ?></p>

    <h2>Job Description</h2>
    <p><?= nl2br(htmlspecialchars($lowongan['deskripsi'])) ?></p>

    <?php if ($lamaran): ?>
        <h3>Your Application</h3>
        <p>Status: <?= htmlspecialchars($lamaran['status']) ?></p>
        <?php if (!empty($lamaran['alasan'])): ?>
            <p>Reason: <?= htmlspecialchars($lamaran['alasan']) ?></p>
        <?php endif; ?>
        <p>CV: <a href="/assets/cv/<?= htmlspecialchars($lamaran['cv_url']) ?>" target="_blank">View CV</a></p>
        <?php if (!empty($lamaran['video_url'])): ?>
            <p>Introduction Video: <a href="/assets/video/<?= htmlspecialchars($lamaran['video_url']) ?>" target="_blank">View Video</a></p>
        <?php endif; ?>
    <?php else: ?>
        <a href="/lamaran/apply?lowongan_id=<?= $lowongan['lowongan_id'] ?>" class="apply-btn">Apply Now</a>
    <?php endif; ?>
</div>
