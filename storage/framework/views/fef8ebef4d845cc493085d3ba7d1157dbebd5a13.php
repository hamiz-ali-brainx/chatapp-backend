<?php $__env->startSection('content'); ?>

<div class="container">
<form action="/update/<?php echo e($todos->id); ?>" method="post" class="mt-4 p-4">
    <?php echo csrf_field(); ?>
    <div class="form-group m-3">
        <label for="name">Todo Name</label>
        <input type="text" class="form-control" value="<?php echo e($todos->name); ?>" name="name">
    </div>
    <div class="form-group m-3">
        <label for="description">Todo Description</label>
        <textarea class="form-control" name="description" rows="3"> <?php echo e($todos->description); ?> </textarea>
    </div>
    <div class="form-group m-3">
        <input type="submit" class="btn btn-primary float-end" value="Submit">
    </div>
</form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/brainx/todo/resources/views/edit.blade.php ENDPATH**/ ?>