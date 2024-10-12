<?php if (isset($toastMessage)): ?>
    <div id="toast"><?= htmlspecialchars($toastMessage) ?></div>
<?php endif; ?>

<!-- cara passing -->
<!-- return $this->views('signup', ['toastMessage' => 'Welcome to the site!',]); -->