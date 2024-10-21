<div class="main-content">
    <div class="container-lamaran">
        <div class="header">
            <h1>Job Application Review</h1>
            <?php if($data['status'] == 'accepted'): ?>
                <span class="status-badge status-accepted">Accepted</span>
            <?php elseif($data['status'] == 'rejected'): ?>
                <span class="status-badge status-rejected">Rejected</span>
            <?php else: ?>
                <span class="status-badge status-waiting">Waiting</span>
            <?php endif; ?>
        </div>

        <div class="applicant-info">
            <div>
                <h2><?= htmlspecialchars($data['name']) ?></h2>
                <p><?= htmlspecialchars($data['email']) ?></p>
            </div>
        </div>

        <div class="attachment">
            <h3>Resume</h3>
            <iframe src="<?= htmlspecialchars($data['cv_path'])?>" title="Resume"></iframe>
        </div>

        <div class="attachment">
            <h3>Introduction Video</h3>
            <video controls>
                <source
                    src="<?= htmlspecialchars($data['video_path'])?>"
                    type="video/mp4"
                />
                Your browser does not support the video tag.
            </video>
        </div>


        <?php if($data['status']=='waiting'): ?>

        <div class="feedback-form">
            <h3>Feedback</h3>

             <div id="editor" class="quill-editor">
             </div>
            <div class="button-group">
                <button id="accept-btn" class="secondary-btn">Accept</button>
                <button id="reject-btn" class="danger-btn">Reject</button>
            </div>
        </div>
        <?php else: ?>
        <div class="feedback-reason-<?=$data['status'] ?> ">
            <h3>Application Feedback</h3>
            <p class="status"><strong>Status:</strong> <?= ($data['status']) ?></p>
            
            <?=($data['status_reason']) ?>
        </div>
        <?php endif; ?>
        <!-- <div class="feedback-reason-accepted">
            <h3>Application Feedback</h3>
            <p class="status"><strong>Status:</strong> Rejected</p>
            
            <p> While we appreciate your interest and the skills you've demonstrated, we've decided to move forward with other candidates whose experience more closely aligns with our current needs. We encourage you to apply for future positions that match your qualifications.</p>
        </div> -->
    </div>
    <aside class="job-details">
        <h3>Job Details</h3>
        <div class="job-grid">
            <p><strong>Position: </strong><?= htmlspecialchars($data['lowongan']['posisi']) ?></p>
            <p><strong>Location Type: </strong><?= htmlspecialchars($data['lowongan']['jenis_lokasi']) ?></p>
            <p><strong>Job Type: </strong><?= htmlspecialchars($data['lowongan']['jenis_pekerjaan']) ?></p>
        </div>
    </aside>
</div>
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script src="/public/scripts/company/lamaran-detail.js"></script>
