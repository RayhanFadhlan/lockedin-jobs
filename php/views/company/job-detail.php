<div class="content">
    <div class="main-container">
        <section class="job-details">
            <h1><?= htmlspecialchars($data['position'])?></h1>
            <div class="job-meta">
                <span><?= htmlspecialchars($data['company_name'])?></span> •
                <span><?= htmlspecialchars($data['locationType'])?></span><br />
                <span><?= htmlspecialchars($data['jobType'])?></span> • <span>Listing <?php 
                    if($data['is_open'] == 0) {
                        echo "closed";
                    } else {
                        echo "open";
                    }
                ?></span><br />
                <span>Created at : <?= htmlspecialchars($data['created_at'])?>
            </div>
            <div class="job-description">
                <?= ($data['description'])?>
            </div>
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
        </section>

        <section class="applicants">
            <h2>Applicants</h2>
            <!-- <div class="applicant">
                <div>
                    <div class="applicant-name">John Doe</div>
                    <div class="applicant-status">Accepted</div>
                </div>
                <a href="#" class="view-details">View Details</a>
            </div>
            <div class="applicant">
                <div>
                    <div class="applicant-name">Jane Smith</div>
                    <div class="applicant-status">Rejected</div>
                </div>
                <a href="#" class="view-details">View Details</a>
            </div>
            <div class="applicant">
                <div>
                    <div class="applicant-name">Bob Johnson</div>
                    <div class="applicant-status">Waiting</div>
                </div>
                <a href="#" class="view-details">View Details</a>
            </div> -->
            <?php foreach (($data['lamarans']) as $lamaran): ?>
                <div class="applicant">
                    <div>
                        <div class="applicant-name"><?= htmlspecialchars($lamaran['nama']) ?></div>
                        <div class="applicant-status"><?= htmlspecialchars($lamaran['status']) ?></div>
                    </div>
                    <a href="/company/lamaran/<?= htmlspecialchars($lamaran['lamaran_id']) ?>" class="view-details">View Details</a>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <div class="right-container">
        <h2>Job Actions</h2>
        <aside class="job-actions">
            <a href="/company/job/<?= $jobId ?>/editjob" >
                <button class="primary-btn" id="edit-button">Edit Job</button>
            </a>
          
            <button  class="secondary-btn" id="close-button"><?= $data['is_open'] ? 'Close Job' : 'Open Job' ?></button>

          
            <button class="danger-btn" id="delete-button">Delete Job</button>
        </aside>
    </div>
</div>
<script src="/public/scripts/company/job-detail.js"></script>