<?php defined('__ROOT__') OR exit('No direct script access allowed'); ?>
<div class="container">
	<h1>All Users</h1><br>
	<?php foreach ($this->allUsers as $user): ?>
		<h4><?php echo $user['id'] . ': ' . $user['name']; ?></h4>
	<?php endforeach ?>
</div>
