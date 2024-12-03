<header class="navbar navbar-expand-lg navbar-dark bg-dark p-3">
    <a class="navbar-brand" href="/dashboard">
        <img src="<?= base_url(); ?>public/assets/logo.png" alt="Logo" class="d-inline-block align-top rounded-circle"
            style="width: 40px; height: 40px;" class="">
        Sales & Inventory
    </a>

    <div class="ml-auto">
        <span class="text-white">username</span>
        <a href="<?=site_url('auth/logout');?>" class="btn btn-danger ml-3">Logout</a>
    </div>
</header>