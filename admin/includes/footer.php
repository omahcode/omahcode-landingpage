    </div><!-- End Page Body -->

    <!-- Admin Footer -->
    <footer class="bg-white border-top py-3 px-4 text-center text-muted font-size-13 mt-auto">
        &copy; <?= date('Y') ?> <strong><?= e($siteName) ?> CMS</strong> &bull; Partner Digitalisasi dan Pengembangan Website Profesional di Cirebon
    </footer>
</div><!-- End Admin Main -->

<!-- JS Scripts -->
<script src="../assets/js/jquery-3.7.1.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Mobile sidebar toggle
    $('#toggle-sidebar').on('click', function() {
        $('#admin-sidebar').toggleClass('show');
    });

    // Close sidebar when clicking outside on mobile
    $(document).on('click', function(e) {
        if ($(window).width() < 992) {
            if (!$(e.target).closest('#admin-sidebar, #toggle-sidebar').length) {
                $('#admin-sidebar').removeClass('show');
            }
        }
    });

    // SweetAlert2 confirmation for delete actions
    $(document).on('click', '.btn-confirm-delete', function(e) {
        e.preventDefault();
        const deleteUrl = $(this).attr('href');
        const itemName = $(this).data('name') || 'data ini';

        Swal.fire({
            title: 'Konfirmasi Hapus Data',
            html: 'Apakah Anda yakin ingin menghapus <b>' + itemName + '</b>?<br><span class="text-danger font-size-13">Tindakan ini permanen dan tidak dapat dibatalkan.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa-solid fa-trash me-1"></i> Ya, Hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    });

    // SweetAlert2 confirmation for logout
    $(document).on('click', '.btn-confirm-logout', function(e) {
        e.preventDefault();
        const logoutUrl = $(this).attr('href');

        Swal.fire({
            title: 'Konfirmasi Logout',
            text: 'Apakah Anda yakin ingin mengakhiri sesi administrator?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#00B4D8',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="fa-solid fa-right-from-bracket me-1"></i> Ya, Logout',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = logoutUrl;
            }
        });
    });

    <?php if (isset($flash) && !empty($flash)): ?>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: '<?= $flash['type'] === 'success' ? 'success' : 'error' ?>',
        title: '<?= addslashes($flash['message']) ?>',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true
    });
    <?php endif; ?>
});
</script>
</body>
</html>

