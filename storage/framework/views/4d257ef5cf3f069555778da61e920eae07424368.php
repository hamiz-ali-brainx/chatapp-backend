<?php $__env->startSection('content'); ?>
<div class="col-12 align-self-center">
<?php if($error): ?>
<div class="alert alert-success text-center" role="alert">
    <?php echo e($error); ?>

</div>
<?php else: ?>
<div class="alert alert-success text-center" role="alert">
    Before proceeding, please check your email for a verification link. If you did not receive the email,
</div>
<?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brainx/todo/resources/views/verification/notice.blade.php ENDPATH**/ ?>