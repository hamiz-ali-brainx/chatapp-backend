<?php $__env->startSection('content'); ?>

<div class="row mt-3">
    <div class="container">
        <h1 class="text-center">
            Welcome! <?php echo e($user); ?>

        </h1>
    </div>
    <div class="col-12 align-self-center">
        <?php if(session('success')): ?>
        <div class="alert alert-success text-center" role="alert">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>
        <div class="container">
            <ul class="list-group">
                <?php $__currentLoopData = $todos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $todo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="list-group-item">
                    <a style="text-decoration: none; color: black" href="/details/<?php echo e($todo->id); ?>">
                        <?php echo e($todo->name); ?>

                    </a>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>

        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brainx/VueTodo/server/resources/views/index.blade.php ENDPATH**/ ?>