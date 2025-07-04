<?php if (is_array($result) && !empty($result)): ?>
    <?php $file_names = implode(",", $result); ?>
    <script>
        alert('ERROR Uploading files: <?= $file_names; ?> Please try to re-upload!');
        location.href = "<?= base_url("supplier");?>";
    </script>
<?php else: ?>
    <script>
        alert('All fields are completed. Thank you for choosing Motortrade Group.');
        window.history.back();
        location.reload(); 
    </script>
<?php endif; ?>