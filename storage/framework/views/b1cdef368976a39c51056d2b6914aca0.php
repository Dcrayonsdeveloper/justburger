<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e($title ?? 'Admin'); ?> - <?php echo e(\App\Models\Setting::get('site_name', config('app.name'))); ?></title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <?php echo e($styles ?? ''); ?>

    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body class="antialiased layout-admin" x-data="{ sidebarOpen: false }" style="background:#f1f1f1;font-family:'Inter',system-ui,-apple-system,sans-serif">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <?php echo $__env->make('admin.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Content area -->
        <div class="flex flex-col flex-1 overflow-hidden" style="background:#f1f1f1">
            <!-- Admin Header -->
            <?php echo $__env->make('admin.partials.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main content -->
            <main class="flex-1 overflow-y-auto" style="scrollbar-width:thin;scrollbar-color:#ccc transparent;background:#f1f1f1;padding:16px 20px">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($header)): ?>
                    <div class="mb-4"><?php echo e($header); ?></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($statsBar)): ?>
                    <?php echo e($statsBar); ?>

                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php echo e($slot); ?>

            </main>
        </div>
    </div>

    <?php echo e($scripts ?? ''); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 4000,
            extendedTimeOut: 2000,
            showEasing: 'swing',
            hideEasing: 'linear',
            showMethod: 'fadeIn',
            hideMethod: 'fadeOut',
        };

        <?php if(session('success')): ?>
            toastr.success(<?php echo json_encode(session('success'), 15, 512) ?>);
        <?php endif; ?>

        <?php if(session('error')): ?>
            toastr.error(<?php echo json_encode(session('error'), 15, 512) ?>);
        <?php endif; ?>

        <?php if(session('warning')): ?>
            toastr.warning(<?php echo json_encode(session('warning'), 15, 512) ?>);
        <?php endif; ?>

        <?php if(session('info')): ?>
            toastr.info(<?php echo json_encode(session('info'), 15, 512) ?>);
        <?php endif; ?>
    </script>
</body>
</html>
<?php /**PATH /home/u322703740/domains/justburger.dcrayons.app/resources/views/components/layouts/admin.blade.php ENDPATH**/ ?>