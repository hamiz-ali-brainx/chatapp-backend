
<h1>Hello there, <?php echo e($user->name); ?>!</h1>


<br>

<p>Thank you for being a part of our growing community. Please click the link below to verify your account.</p>

<p>
  <a href="<?php echo e(url('/verification/' . $user->id)); ?>">Click here.</a>
</p><?php /**PATH /home/brainx/todo/resources/views/auth/verification.blade.php ENDPATH**/ ?>